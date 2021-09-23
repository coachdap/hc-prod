<?php
namespace NFHubspot\EmailCRM\Hubspot;

use NFHubspot\EmailCRM\Hubspot\Contracts\ConfigureContract;
use NFHubspot\EmailCRM\Hubspot\Contracts\HubspotContract;
use NFHubspot\EmailCRM\Hubspot\Factories\Configure;
use NFHubspot\EmailCRM\Hubspot\HubspotSdk;

// Shared
use NFHubspot\EmailCRM\Shared\Contracts\Module;
use NFHubspot\EmailCRM\Shared\Entities\FormFields;
use NFHubspot\EmailCRM\Shared\Containers\ServiceContainer;
use NFHubspot\EmailCRM\Shared\Entities\GlobalSettings;
use NFHubspot\EmailCRM\Shared\Contracts\RemoteRequestContract;
// WP Bridge
use NFHubspot\EmailCRM\WpBridge\Http\RemoteRequest;
/**
 * Exposes the top-level API of the package
 */
class Hubspot extends ServiceContainer implements HubspotContract
{
	/**
	 * Unique identifier for package
	 */
	const IDENTIFIER  = 'hubspot';
	
        /**
         *
         * @var GlobalSettings
         */
        protected $globalSettings;
        
        /**
         *
         * @var RemoteRequestContract 
         */
        protected $remoteRequest;
        
        /**
         * SDK that handles communication to and from the API
         * 
         * @var HubspotSdk
         */
        protected $sdk;
        
       /**
        * Module Configuration
        * @var array
        */
       protected $moduleConfig;
    
        /**
		 * Return GlobalSettings configured for the ApiModule
                 * 
                 * May NOT include values, as that must be provided by
                 * integrating plugin.
		 *
		 * @return GlobalSettings
		 */
	public function getGlobalSettings():GlobalSettings
	{
		/** @var ConfigureContract $configure */
            if(!isset($this->globalSettings)){
                
		$configure = $this->make('Configure');
                
                $this->globalSettings = $configure->globalSettings();
            }
		             
		return $this->globalSettings;
	}
        
        /**
         * Set GlobalSettings from external source, with values from data source
         * 
         * ApiKey authorization does not need storage capability as OpenAuth does,
         * so we need only the GlobalSettings with values as initiated.
         * 
         * @param GlobalSettings $globalSettings
         * @return HubspotContract
         */
        public function setGlobalSettings(GlobalSettings $globalSettings): HubspotContract{
            
            $this->globalSettings = $globalSettings;
            
            return $this;
        }
        
        /**
         * Return the RemoteRequest
         * 
         * If not explicitly set by external source, default remote request used
         * 
         * @return RemoteRequestContract
         */
        public function getRemoteRequest(): RemoteRequestContract {
            if(!isset($this->remoteRequest)){
                
                $this->remoteRequest = new RemoteRequest();
            }
            
            return $this->remoteRequest;
        }
        

        /**
         * Set RemoteRequest
         * 
         * @param RemoteRequestContract $remoteRequest
         * @return HubspotContract
         */
        public function setRemoteRequest(RemoteRequestContract $remoteRequest): HubspotContract {
            $this->remoteRequest = $remoteRequest;
            return $this;
        }
        
        /**
         * Return Module Configuration
         * 
         * @return array
         */
        public function getModuleConfig():array{
            if(!isset($this->moduleConfig)){
                $this->moduleConfig=$this->make('Configure')
                        ->moduleConfig();
            }
            
            return $this->moduleConfig;
        }
        
        /**
     * Provide the SDK for communication access to the API
         * 
     * @return HubspotSdk
     */
    public function sdk(): HubspotSdk {
        if (!isset($this->sdk)) {

            $remoteRequest = $this->getRemoteRequest();

            $apiKey = $this->globalSettings->getGlobalSetting('hubspotApiKey')->getValue();

            if (is_null($apiKey)) {
                $apiKey = '';
            }
            
            $moduleConfig = $this->getModuleConfig();
            
            $this->sdk = new HubspotSdk($remoteRequest, $apiKey, $moduleConfig);
        }
        return $this->sdk;
    }

    /**
		 * Return standard FormFields configured for the ApiModule
		 *
		 * @return FormFields
		 */
	public function getFormFields(): FormFields
	{
		/** @var ConfigureContract $configure */
		$configure = $this->make('Configure');
			
		return $configure->formFields();
	}
		
		
	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
	}

	/**
	 * Register the module's services
	 *
	 * @return Module
	 */
	public function registerServices(): Module
	{
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
}
