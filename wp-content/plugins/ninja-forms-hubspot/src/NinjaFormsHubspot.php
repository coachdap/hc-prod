<?php

namespace NFHubspot;

// Integrating Plugin
use NFHubspot\Contracts\NinjaFormsHubspotContract;
use NFHubspot\Factories\Configure;
use NFHubspot\Actions\ConstructCreateEntryActionEntity;
use NFHubspot\Handlers\NfHubspotCreateRecordsFormActionHandler;
use NFHubspot\Actions\AdminSettings;
use NFHubspot\Endpoints\AutogenerateFormEndpoint;
// API Module
use NFHubspot\EmailCRM\Hubspot\Hubspot;
use NFHubspot\EmailCRM\Hubspot\Contracts\HubspotContract;
use NFHubspot\EmailCRM\Hubspot\HubspotSdk;
//NF Bridge
use NFHubspot\EmailCRM\NfBridge\Contracts\NfBridgeContract;
use NFHubspot\EmailCRM\NfBridge\Actions\OutputResponseDataMetabox;
use NFHubspot\EmailCRM\NfBridge\Contracts\FormProcessorsFactoryContract;
use NFHubspot\EmailCRM\NfBridge\Actions\NfAction;
use NFHubspot\EmailCRM\NfBridge\Actions\RegisterAction;
use NFHubspot\EmailCRM\NfBridge\Actions\AutogenerateForm;
use NFHubspot\EmailCRM\NfBridge\Actions\CreateAddNewModal;
// Shared
use NFHubspot\EmailCRM\Shared\Containers\ServiceContainer;
use NFHubspot\EmailCRM\Shared\Contracts\Module;
use NFHubspot\EmailCRM\Shared\Contracts\ApiModuleContract;
use NFHubspot\EmailCRM\NfBridge\Actions\NfSettingsGlobalSettingsStorage;
use NFHubspot\EmailCRM\Shared\Entities\FormFields;
// WP Bridge
use NFHubspot\EmailCRM\WpBridge\Database\TransientStore;
use NFHubspot\EmailCRM\WpBridge\Database\OptionsStore;
use NFHubspot\EmailCRM\WpBridge\WpHooksApi;
use NFHubspot\EmailCRM\WpBridge\RestApi\CreateWordPressEndpoints;
use NFHubspot\EmailCRM\WpBridge\RestApi\AuthorizeRequestWithWordPressUser;

/**
 * Exposes the top-level API of the Integrating Plugin
 */
class NinjaFormsHubspot extends ServiceContainer implements NinjaFormsHubspotContract {

    /**
     * Plugin Name
     */
    const NAME = 'Hubspot';

    /**
     * Version Number
     */
    const VERSION = '3.0.0';

    /**
     * Plugin Author
     */
    const AUTHOR = 'Ninja Forms';

    /**
     * Programmatic Slug
     */
    const SLUG = 'nf-hubspot';

    /**
     * Unique identifier for package
     */
    const IDENTIFIER = 'nf_hubspot';

    /**
     * REST Route for endpoints
     */
    const RESTROUTE = 'nf-hubspot/v1';

    /**
     * Api Module
     * 
     * @var Hubspot
     */
    protected $apiModule;

    /**
     *
     * @var HubspotSdk 
     */
    protected $sdk;

    /**
     * Creates modal with Add New form autogeneration button
     * 
     * The modal configuration is provided through the configuration factory.
     * A nonce field is generated at the time of modal construction.
     * The endpoint points to a registered REST API endpoint that will handle
     * the request.
     * 
     * @param array $templates
     * @return array
     */
    public function registerAutogenerateModal($templates) {

        $wpHooks = new WpHooksApi();
        $configure = $this->make('Configure');

        $modalConfiguration = $configure->autogenerateModalMarkup();

        $nonceField = $wpHooks->wpNonceField('wp_rest', '_wpnonce', true, false);

        $url = $wpHooks->wpRestUrl() . self::RESTROUTE . '/nf-autogenerate';

        $modal = (new CreateAddNewModal())->handle($modalConfiguration, $url, $nonceField);

        $templates[ $modal->getId() ] = $modal->toArray();

        return $templates;
    }

    /**
     * Register the CreateEntry action
     * 
     * Custom fields are retrieved from storage, or request via the API Module
     * This collection is injected into BOTH the action entity, which defines
     * the action, AND the FormActionHandler.  By coordinating their
     * construction, both the defining action and the action handler have
     * the same set of data and the handler has instructions on every piece
     * of data submitted.
     */
    public function registerCreateEntryAction() {
        /** @var NfHubspotCreateRecordsFormActionHandler $formActionHandler */
        /** @var Configure $configure */
        $configure = $this->make('Configure');
        // Construct the ActionEntity
        $actionConfiguration = $configure->actionEntity()->toArray();

        $globalSettings = $this->apiModule->getGlobalSettings();
        $globalSettingsStorage = new NfSettingsGlobalSettingsStorage($globalSettings);

        $standardApiFormFields = $this->apiModule->getFormFields();

        $customApiFormFields = $this->getCustomApiFormFields();

        $actionEntityConstructor = new ConstructCreateEntryActionEntity(
                $actionConfiguration,
                $globalSettingsStorage,
                $standardApiFormFields,
                $customApiFormFields);

        $actionEntity = $actionEntityConstructor->getActionEntity();

        // Construct the FormActionHandler
        $formActionHandler = new NfHubspotCreateRecordsFormActionHandler($this->apiModule);
        $formActionHandler->setCustomApiFormFields($customApiFormFields);

        $formProcessorsFactory = $this->nfBridge->make(FormProcessorsFactoryContract::class);

        $wpHooks = new WpHooksApi();
        // Construct the Action from the Action entity
        $nfAction = new NfAction($actionEntity, $formActionHandler, $formProcessorsFactory, $wpHooks);

        // Register the Action
        $registerAction = $this->nfBridge->make(RegisterAction::class);
        $registerAction->addNfAction($nfAction);
    }

    /**
     * Initialize the REST API endpoints
     *
     * @since 3.0.0
     *
     * @uses "rest_api_init" hook.
     */
    public function initRestApi(): void {
        $api = new CreateWordPressEndpoints('register_rest_route', self::RESTROUTE);

        //Authorization for all REST API endpoints
        $authorizer = new AuthorizeRequestWithWordPressUser('manage_options');

        //Get Autogenerate Form Endpoint
        // AutogenerateFormEndpoint triggers form building and is not cached for that reason
        $endpoint = new AutogenerateFormEndpoint();
        $actionEntity = $this->make('Configure')
                ->actionEntity();

        $standardFormFields = $this->getApiModule()
                ->getFormFields();

        $customFormFields = $this->getCustomApiFormFields();
        $autogenerateForm = new AutogenerateForm($actionEntity, $standardFormFields, $customFormFields);
        $endpoint->setAutogenerateForm($autogenerateForm);
        $endpoint->addAuthorizer($authorizer);
        $api->registerRouteWithWordPress(
                $endpoint
        );
    }

    /**
     * Store custom fields as requested and provided by the API Module
     */
    public function updateCustomFields(): FormFields {
        $sdk = $this->apiModule->sdk();

        $contactFields = $sdk->getContactFields()->toArray();
        $companyFields = $sdk->getCompanyFields()->toArray();
        $dealFields = $sdk->getDealFields()->toArray();
        $ticketFields = $sdk->getTicketFields()->toArray();

        $customFields = FormFields::fromArray(array_merge($contactFields, $companyFields, $dealFields, $ticketFields));

        // Data storage switched to OptionsStore, was TransientStore
        // See issue #20
        $dataStorage = new OptionsStore(self::IDENTIFIER . '_custom_fields');

        $dataStorage->saveData($customFields->toArray());

        return $customFields;
    }

    /**
     * Return stored Custom API Form fields
     * 
     * Custom API Fields are stored and provided by the Integrating Plugin
     * 
     * In NF, a request is made, usually from the settings page and the data
     * is stored in WP Options.
     * 
     * @return FormFields
     */
    public function getCustomApiFormFields(): FormFields {

        // Data storage switched to OptionsStore, was TransientStore
        $dataStorage =  new OptionsStore(self::IDENTIFIER . '_custom_fields');
        $apiFieldsArray = $dataStorage->getData();

        // Those who have not refreshed custom fields since this update will
        // only have data stored in the transient, so provide a fallback
        if ([] == $apiFieldsArray) {

            $transientStore = new TransientStore(self::IDENTIFIER . '_custom_fields');
            $apiFieldsArray = $transientStore->getData();
        }

        $apiFields = FormFields::fromArray($apiFieldsArray);

        return $apiFields;
    }

    /**
     * Set the NF Bridge to provide NF functionality
     *
     * @param NfBridgeContract $nfBridge
     * @return NinjaFormsHubspot
     */
    public function setNfBridge(NfBridgeContract $nfBridge): NinjaFormsHubspotContract {
        $this->nfBridge = $nfBridge;
        return $this;
    }

    /**
     * Return the NF Bridge object
     * 
     * @return NfBridgeContract
     */
    public function getNfBridge(): NfBridgeContract {
        return $this->nfBridge;
    }

    /**
     * Set the API Module
     *
     * @param ApiModuleContract $apiModule
     * @return MainInstanceContract
     */
    public function setApiModule(HubspotContract $apiModule): NinjaFormsHubspotContract {
        $this->apiModule = $apiModule;
        $this->initializeApiModule();
        return $this;
    }

    /**
     * Initialize API Module with settings values
     */
    protected function initializeApiModule() {
        $globalSettings = $this->apiModule->getGlobalSettings();
        $globalSettingsStorage = new NfSettingsGlobalSettingsStorage($globalSettings);
        $retrievedGlobalSettings = $globalSettingsStorage->retrieveGlobalSettings()->getGlobalSettings();

        $this->apiModule->setGlobalSettings($retrievedGlobalSettings);
    }

    /**
     * Return the API Module
     * 
     * @return ApiModuleContract
     */
    public function getApiModule(): HubspotContract {
        return $this->apiModule;
    }

    /**
     * Binds instances of classes used by the API Module
     *
     * The API module can then provide those instances in any injected
     * dependency when requested by calling the make() method with the
     * requested class name
     */
    public function registerServices(): Module {
        /*
         * Configure provides configured files and entities
         *
         * API-specific data can be configured in a preferred format and
         * delivered via this object
         *
         * Uses the `lazy-loaded singleton` technique
         */
        $this->singleton('Configure', function () {

            $singleton = new Configure(__DIR__);
            return $singleton;
        });


        return $this;
    }

    
    /**
     * Setup Admin
     *
     * Setup admin classes for Ninja Forms and WordPress.
     */
    public function setupAdmin() {
        new AdminSettings($this);
    }
    /** @inheritDoc */
    public function getIdentifier(): string {
        return self::IDENTIFIER;
    }

}
