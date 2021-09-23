<?php

namespace NFHubspot\Actions;

// API Module
use NFHubspot\EmailCRM\Shared\Entities\FormField;
// Shared
use NFHubspot\EmailCRM\Shared\Entities\GlobalSetting;
// NF Bridge
use NFHubspot\EmailCRM\NfBridge\Actions\ConstructActionEntity;

/**
 * Creates the ActionEntity object from which a NF action can be constructed
 * 
 */
class ConstructCreateEntryActionEntity extends ConstructActionEntity {

    /**
     * Add Custom Field and Reauthorization buttons to the GlobalSettings
     * 
     * Provides UI interfaces inside NF plugin settings
     */
    protected function appendIntegrationSpecificGlobalSettings() {

        // Set preconfigured global settings
        $configuredGlobalSettings = $this->globalSettingsStorage->getGlobalSettings();

        $customFieldButton = GlobalSetting::fromArray([
                    'id' => 'hubspotGetCustomFields',
                    'label' => __('GetCustomFields','ninja-forms-hubspot'),
                    'expectedDataType' => 'externallySetString',
                    'value' => '<div id="nfHubspotUpdateCustomFields" class="button">'.__('Retrieve Hubspot Fields','ninja-forms-hubspot').'</div>'
        ]);

        $feedbackElement = GlobalSetting::fromArray([
                    'id' => 'hubspotFeedbackElement',
                    'label' => __('Status', 'ninja-forms-hubspot'),
                    'expectedDataType' => 'externallySetString',
                    'value' => '<div id="nfHubspotFeedbackElement"></div>'
        ]);

        $configuredGlobalSettings->addGlobalSetting($customFieldButton);
        $configuredGlobalSettings->addGlobalSetting($feedbackElement);

        $this->globalSettingsStorage->setGlobalSettings($configuredGlobalSettings);
    }

    /**
     * Determine the group location for a given FormField
     * 
     * 
     * @param FormField $apiFormField
     * @return string
     */
    protected function determineActionSettingGroup(FormField $apiFormField): string {

        $group = 'primary';

        $slug = $this->actionEntity->getName();
        $id = $apiFormField->getId();

        $explode = explode('_-_', $id);

        if (isset($explode[1])) {
            $group = $slug . '_' . $explode[1];
        }

        return $group;
    }

    /**
     * Create groupings for the action field mapping
     * 
     * Enables large lists of field maps to be organized into manageable groups
     * 
     */
    public function createActionSettingsGroups($groups) {

        $slug = $this->actionEntity->getName();

        $groups[$slug . '_contacts'] = [
            'id' => $slug . '_contacts',
            'label' => __('Contacts','ninja-forms-hubspot'),
            'display' => TRUE,
            'priority' => 110
        ];

        $groups[$slug . '_companies'] = [
            'id' => $slug . '_companies',
            'label' => __('Companies','ninja-forms-hubspot'),
            'display' => TRUE,
            'priority' => 115
        ];
        $groups[$slug . '_deals'] = [
            'id' => $slug . '_deals',
            'label' => __('Deals','ninja-forms-hubspot'),
            'display' => TRUE,
            'priority' => 120
        ];
        $groups[$slug . '_tickets'] = [
            'id' => $slug . '_tickets',
            'label' => __('Tickets','ninja-forms-hubspot'),
            'display' => TRUE,
            'priority' => 125
        ];
        return $groups;
    }

}
