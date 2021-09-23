<?php
/*
 * Return a fully configured GlobalSettings entity, in array form
 */
return [
	/*
	 * ID of the ApiModule's GlobalSettings
	 * Must be unique across all integrations for a given platform
	 */
	'id' => 'hubspot',
	/*
	 * Displayed name of the settings collection
	 */
	'label' => __('Hubspot Settings','ninja-forms-hubspot'),
	'globalSettings' => [
		/*
		 * Id is prefixed with ApiModule id to ensure uniqueness
		 */
		'hubspotApiKey' => [
			/*
			 * Must match setting key
			 */
			'id' => 'hubspotApiKey',
			/*
			 * Displayed setting name
			 *
			 * Note: doesn't have to be prefixed so to prevent redundancy
			 */
			'label' => __('API Key','ninja-forms-hubspot'),
			/*
			 * Types:
			 *
			 * userProvidedString : User prompted to enter value (e.g. API Key)
			 * externallySetString : Value is set through non-user method (e.g. automatically generated RefreshToken )
			 *
			 */
			'expectedDataType' => 'userProvidedString'
		]
	]
];
