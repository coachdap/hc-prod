<?php

namespace NFHubspot\EmailCRM\NfBridge\Actions;

// API Module
use NFHubspot\EmailCRM\Shared\Entities\FormField;
use NFHubspot\EmailCRM\Shared\Entities\FormFields;

// Shared
use NFHubspot\EmailCRM\Shared\Entities\GlobalSetting;
// NF Bridge
use NFHubspot\EmailCRM\NfBridge\Entities\ActionEntity;
use NFHubspot\EmailCRM\NfBridge\Entities\ActionSetting;
use NFHubspot\EmailCRM\NfBridge\Entities\ActionSettings;
use NFHubspot\EmailCRM\NfBridge\Entities\ApiSettings;
use NFHubspot\EmailCRM\Shared\Contracts\GlobalSettingsStorageContract;
// WP Bridge
use NFHubspot\EmailCRM\WpBridge\WpHooksApi;

/**
 * Creates the ActionEntity object from which a NF action can be constructed
 * 
 * An ActionEntity object is the complete definition of a Ninja Form action.  It
 * defines labels and programmatic slugs used for identification.  
 *
 */
class ConstructActionEntity {

    /**
     * ActionEntity is an object containing the properties defining a NF action
     * 
     * @var ActionEntity
     */
    protected $actionEntity;

    /**
     * API Settings are site-wide settings (i.e. independent of a specific form)
     * 
     * ApiSettings is the NF-specific counterpart of the GlobalSettings entity,
     * which is shared across all form platforms.  ApiSettings was created
     * in case there were certain properties specific to  NF that had to be
     * added.
     * 
     * These are constructed into NF Plugin Settings.
     * 
     * @var ApiSettings
     */
    protected $apiSettings;

    /**
     * Action Settings are form-specific settings
     * 
     * In CRMs, this consists primarily of field mapping
     * These are constructed into NF Action Settings
     * 
     * @var ActionSettings
     */
    protected $actionSettings;

    /**
     * Configuration array defining top level parameters of ActionEntity
     * 
     * @var array
     */
    protected $actionConfiguration;
    
    /**
     * Store, retrieve, and provide GlobalSettings from a data storage source
     * 
     * Initially defined by the ApiModule, the settings storage instance is
     * appended with additional plugin settings not defined by the API, UI
     * interfaces for example.
     * 
     * @var GlobalSettingsStorageContract 
     */
    protected $globalSettingsStorage;
    
    /**
     * Collection of standard API Form Fields
     * 
     * These are standard fields in the API and are provided by the ApiModule
     * 
     * @var FormFields
     */
    protected $standardApiFormFields;
    
    /**
     * Collection of Custom API FormField entities
     *  
     * @var FormFields
     */
    protected $customApiFormFields;

    /**
     * 
     * @param array $actionConfiguration
     * @param GlobalSettingsStorageContract $globalSettingsStorage
     * @param FormFields $standardApiFormFields
     * @param FormFields $customApiFormFields
     */
    public function __construct(
            array $actionConfiguration,
            GlobalSettingsStorageContract $globalSettingsStorage,
            FormFields $standardApiFormFields,
            FormFields $customApiFormFields) {


        $this->actionConfiguration = $actionConfiguration;
        
        $this->globalSettingsStorage = $globalSettingsStorage;
        
        $this->globalSettingsStorage->retrieveGlobalSettings();
                
        $this->appendIntegrationSpecificGlobalSettings();

        
        $this->standardApiFormFields = $standardApiFormFields;
        
        $this->customApiFormFields = $customApiFormFields;

        $this->instantiateActionEntity();

        $this->convertGlobalSettingsToApiSettings();

        $this->addActionSettings();

        (new WpHooksApi())->addFilter('ninja_forms_field_settings_groups', [$this, 'createActionSettingsGroups']);
    }

    /**
     * Construct ActionEntity's API settings from the global settings
     * 
     * The API's global settings are shared construction between CF and NF.  API
     * Settings are specific to NF and is used to construct the plugin
     * settings.
     * 
     * GlobalSettings and ApiSettings have similar structures and
     * can be passed straight through.  This may not always be the case as
     * other integrations or CF may require additional data or structural changes
     * in the GlobalSettings.  This method provides a means to convert the
     * GlobalSetting into the standard NF structure in that scenario.
     * 
     */
    protected function convertGlobalSettingsToApiSettings() {

        $array = $this->globalSettingsStorage->getGlobalSettings()->toArray();
        $array['apiSettings'] = $array['globalSettings'];
        unset($array['globalSettings']);

        $this->apiSettings = ApiSettings::fromArray($array);
        
        $this->actionEntity->setApiSettings($this->apiSettings);
    }

    /**
     * Add Custom Field and Reauthorization buttons to the GlobalSettings
     * 
     * By default, no additional settings are appended.  An integrating plugin
     * can extend this class and override this method to customize this behavior.
     */
    protected function appendIntegrationSpecificGlobalSettings() {
        
    }

    /**
     * Construct ActionEntity's Action Settings
     * 
     * Action Settings are form-specific settings.  For CRM applications, this
     * consists primarily of field mapping.
     */
    protected function addActionSettings() {

        $this->actionSettings = new ActionSettings();

        $this->addStandardApiFormFields();

        $this->appendCustomFormFields();

        $this->actionEntity->setActionSettings($this->actionSettings);
    }

    /**
     * Add standard API fields to Action Settings
     */
    protected function addStandardApiFormFields() {

        foreach ($this->standardApiFormFields->getFields() as $apiFormField) {

            $actionSetting = $this->constructActionSettingFromFormField($apiFormField);

            $this->actionSettings->addActionSetting($actionSetting);
        }
    }

    /**
     * Appends the injected custom FormFields to the action settings
     */
    protected function appendCustomFormFields() {

        foreach ($this->customApiFormFields->getFields() as $apiFormField) {

            $actionSetting = $this->constructActionSettingFromFormField($apiFormField);

            $this->actionSettings->addActionSetting($actionSetting);
        }
    }

    /**
     * Create a single field map setting for an ApiFormField
     * 
     * @param FormField $apiFormField
     * @return ActionSettings
     */
    protected function constructActionSettingFromFormField(FormField $apiFormField) {

        $group = $this->determineActionSettingGroup($apiFormField);

        $actionSetting = ActionSetting::fromArray([
                    'width' => 'full',
                    'group' => $group,
                    'useMergeTags'=>true
        ]);

        $actionSetting->setName($apiFormField->getId());

        $actionSetting->setLabel($apiFormField->getLabel());

        $actionSetting->setType('textbox');

        return $actionSetting;
    }

    /**
     * Determine the group location for a given FormField
     * 
     * Default group is 'primary'.  Integrating plugins can extend and override
     * this method to specify custom action settings group.
     * 
     * @param FormField $apiFormField
     * @return string
     */
    protected function determineActionSettingGroup(FormField $apiFormField): string {
        
        $group = 'primary';
        
        return $group;
    }

    /**
     * Create groupings for the action field mapping
     * 
     * Enables large lists of field maps to be organized into manageable groups.
     * 
     * Default group is 'primary'.  Integrating plugins can extend and override
     * this method to specify custom action settings group.
     * 
     */
    public function createActionSettingsGroups($groups) {

        return $groups;
    }

    /**
     * Initialize an ActionEntity with standard values
     */
    protected function instantiateActionEntity() {

        $array = [
            'name' => $this->actionConfiguration['name'],
            'nicename' => $this->actionConfiguration['nicename'],
            'tags' => $this->actionConfiguration['tags'],
            'timing' => $this->actionConfiguration['timing'],
            'priority' => $this->actionConfiguration['priority']
        ];

        $this->actionEntity = ActionEntity::fromArray($array);
    }

    /**
     * Get the constructed Action Entity
     * 
     * @return ActionEntity
     */
    public function getActionEntity(): ActionEntity {

        return $this->actionEntity;
    }

}
