<?php

namespace NFHubspot\EmailCRM\NfBridge\Factories;

use NFHubspot\EmailCRM\NfBridge\Contracts\NfActionContract;
use NFHubspot\EmailCRM\NfBridge\Contracts\FormProcessorsFactoryContract;
use NFHubspot\EmailCRM\NfBridge\Contracts\NfActionFactoryContract;
use NFHubspot\EmailCRM\NfBridge\Contracts\NfActionProcessHandlerContract;
use NFHubspot\EmailCRM\NfBridge\Entities\ActionEntity;
use NFHubspot\EmailCRM\NfBridge\Actions\NfAction;
use NFHubspot\EmailCRM\NfBridge\Actions\NfNewsletterAction;
use NFHubspot\EmailCRM\WpBridge\WpHooksApi;

/**
 * Factory for creating an NF Action
 */
class NfActionFactory implements NfActionFactoryContract
{

	/** @inheritdoc */
	public function constructNinjaFormsAction(
		ActionEntity $actionEntity,
		NfActionProcessHandlerContract $processHandler,
		FormProcessorsFactoryContract $formProcessorsFactory,
		WpHooksApi $wordpress
	): NfActionContract {

		$action = new NfAction($actionEntity, $processHandler, $formProcessorsFactory, $wordpress);

		return $action;
	}
		
			/** @inheritdoc */
	public function constructNinjaFormsNewsletterAction(
		ActionEntity $actionEntity,
		NfActionProcessHandlerContract $processHandler,
		FormProcessorsFactoryContract $formProcessorsFactory,
		WpHooksApi $wordpress,
		$newsletterExtension
	): NfActionContract {

		$action = new NfNewsletterAction($actionEntity, $processHandler, $formProcessorsFactory, $wordpress, $newsletterExtension);

		return $action;
	}
}
