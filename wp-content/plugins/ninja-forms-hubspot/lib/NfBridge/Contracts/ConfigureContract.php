<?php

namespace NFHubspot\EmailCRM\NfBridge\Contracts;

use NFHubspot\EmailCRM\NfBridge\Entities\Modal;
use NFHubspot\EmailCRM\NfBridge\Entities\ActionEntity;

/**
 * Contract specifying required configurations for all NF Integrating Plugins
 */
interface ConfigureContract
{
	/**
	 * Provide a Modal entity for Autogenerating a form from the Add New menu
	 *
	 * @return Modal
	 */
	public function autogenerateModalMarkup(): Modal;
	
	/**
	 * Provide ActionEntity defining the primary action of the integrating plugin
	 *
	 * @return ActionEntity
	 */
	public function actionEntity():ActionEntity;
}
