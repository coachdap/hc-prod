<?php

namespace NFHubspot\EmailCRM\Hubspot\Contracts;

// Shared
use NFHubspot\EmailCRM\Shared\Entities\GlobalSettings;
use NFHubspot\EmailCRM\Shared\Entities\FormFields;

/**
 * Ensures ApiModule's Configure instance provides the required data
 */
interface ConfigureContract
{

	/**
	 * Return ApiModule's configured GlobalSettings entity
	 *
	 * @return GlobalSettings
	 */
	public function globalSettings(): GlobalSettings;

	/**
	 * Return ApiModule's configured FormFields entity
	 *
	 * @return FormFields
	 */
	public function formFields(): FormFields;
        
        /**
         * Return module configuration specifying module data requirements
         * 
         * An array unique to the needs of a given API; this is not standardized,
         * but rather optimized for the given ApiModule
         * 
         * @return array
         */
        public function moduleConfig():array;
}
