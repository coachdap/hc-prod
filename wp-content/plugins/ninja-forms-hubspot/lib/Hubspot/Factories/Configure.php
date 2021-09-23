<?php


namespace  NFHubspot\EmailCRM\Hubspot\Factories;

use NFHubspot\EmailCRM\Shared\Entities\GlobalSettings;
use NFHubspot\EmailCRM\Shared\Entities\FormFields;

// ApiModule
use NFHubspot\EmailCRM\Hubspot\Contracts\ConfigureContract;

/**
 * Provides configured ApiModule-specific entities
 */
class Configure implements ConfigureContract
{

	/**
	 * ApiModule's top level file location
	 *
	 * @var string
	 */
	protected $dir;
	/**
	 * ApiModule's configured GlobalSettings
	 *
	 * @var GlobalSettings
	 */
	protected $globalSettings;
	
	/**
	 * ApiModule's configured standard FormFields
	 *
	 * @var FormFields
	 */
	protected $formFields;
	
        /**
         * Configuration defining ApiModule's module data specifications
         * 
         * @var array
         */
        protected $moduleConfig;
        
        /**
	 * Instantiate with top-level file directory to provide access throughout
	 *
	 * @param string $dir
	 */
	public function __construct(string $dir)
	{
		$this->dir = $dir;
	}
	
	/**
	 * Return ApiModule's configured GlobalSettings entity
	 *
	 * @return GlobalSettings
	 */
	public function globalSettings(): GlobalSettings
	{
		if (!isset($this->globalSettings)) {
					$array = include $this->dir.'/Config/GlobalSettings.php';
		
					$this->globalSettings = GlobalSettings::fromArray($array);
		}
		
		return $this->globalSettings;
	}
	
		/**
	 * Return ApiModule's configured FormFields entity
	 *
	 * @return FormFields
	 */
	public function formFields(): FormFields
	{
		if (!isset($this->formFields)) {
					$array =  include $this->dir.'/Config/FormFields.php';
		
					$this->formFields =  FormFields::fromArray($array);
		}
		
		return $this->formFields;
	}
        
        /** 
         * Return module configuration specifying module data requirements 
         */
        public function moduleConfig(): array {
            if (!isset($this->moduleConfig)) {
                $this->moduleConfig = include $this->dir . '/Config/ModuleConfig.php';
            }

            return $this->moduleConfig;
        }

}
