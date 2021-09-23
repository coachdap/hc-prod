<?php

namespace NFMailchimp\NinjaForms\Mailchimp\Handlers;

// Integrating plugin
use NFMailchimp\NinjaForms\Mailchimp\Contracts\NinjaFormsMailchimpContract;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\ConstructActionEntity;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\NewsletterExtension;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\MailchimpSubscribeActionProcessHandler;
// Mailchimp
use NFMailchimp\EmailCRM\Mailchimp\Contracts\MailchimpContract;
use NFMailchimp\EmailCRM\Mailchimp\Factories\MailchimpApiService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConstructSubscriberFactoryService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConvertSubmissionDataToSubscriberFactoryService;
// NF Bridge
use NFMailchimp\EmailCRM\NfBridge\Contracts\NfBridgeContract;
use NFMailchimp\EmailCRM\NfBridge\Factories\NfActionFactoryContract;
use NFMailchimp\EmailCRM\NfBridge\Contracts\NfActionProcessHandler;
use NFMailchimp\EmailCRM\NfBridge\Contracts\FormProcessorsFactoryContract;
use NFMailchimp\EmailCRM\NfBridge\Contracts\NfActionContract;
use NFMailchimp\EmailCRM\NfBridge\Entities\ActionEntity;
// WP Bridge
use NFMailchimp\EmailCRM\WpBridge\WpHooksApi;
use NFMailchimp\EmailCRM\WpBridge\Http\MailchimpWpHttpClient;
// Mailchimp vendor API
use Mailchimp\http\MailchimpGuzzleHttpClient;

/**
 * Construct Subscribe to Mailchimp Newsletter action with Ninja Forms
 */
class ConstructSubscribeAction
{

	/**
	 * Top level of the NF Mailchimp plugin
	 * @var NinjaFormsMailchimpContract
	 */
	protected $nfMailchimp;

	/**
	 * Module providing access to Mailchimp package
	 * @var MailchimpContract
	 */
	protected $mailchimp;

	/**
	 * Module providing access to NF Bridge package
	 * @var NfBridgeContract
	 */
	protected $nfBridge;

	/**
	 * Entity describing the Ninja Forms action
	 * @var ActionEntity
	 */
	protected $actionEntity;

	/**
	 * Handler class processing the form submission
	 * @var NfActionProcessHandler
	 */
	protected $processHandler;

	/**
	 * NF Bridge factory injected into NF action
	 * @var FormProcessorsFactoryContract
	 */
	protected $formProcessorFactory;

	/**
	 * Ninja Forms action honoring NF Action contract
	 * @var NfActionContract
	 */
	protected $ninjaFormsAction;
	
	/**
	 *
	 * @param NinjaFormsMailchimpContract $nfMailchimp
	 */
	public function __construct(NinjaFormsMailchimpContract $nfMailchimp)
	{
		$this->nfMailchimp = $nfMailchimp;
		$this->nfBridge = $this->nfMailchimp->getNfBridge();
		$this->mailchimp = $this->nfMailchimp->getMailchimpModule();

		$this->constructActionEntity();
		$this->constructProcessHandler();
		$this->makeFormProcessorFactory();
		$this->constructNinjaFormsAction();
	}

	/**
	 * Construct action entity
	 */
	protected function constructActionEntity()
	{
		$this->actionEntity = (new ConstructActionEntity($this->nfMailchimp))->getActionEntity();
	}

	/**
	 * Construct process handler class
	 */
	protected function constructProcessHandler()
	{
		// make ConstructSubsSubscriberFactory
		$constructSubscriberFactory = $this->nfMailchimp->getMailchimpModule()
				->make(ConstructSubscriberFactoryService::class);

		$convertSubmissionDataToSubscriberFactory = $this->nfMailchimp->getMailchimpModule()
				->make(ConvertSubmissionDataToSubscriberFactoryService::class);

		$mailchimpApiService = $this->nfMailchimp->getMailchimpModule()->make(MailchimpApiService::class);

		$client = new MailchimpWpHttpClient();
		$this->processHandler = new MailchimpSubscribeActionProcessHandler(
			$constructSubscriberFactory,
			$convertSubmissionDataToSubscriberFactory,
			$mailchimpApiService,
			$client
		);
	}

	/**
	 * Make form process factory
	 */
	protected function makeFormProcessorFactory()
	{
		$this->formProcessorFactory = $this->nfMailchimp->getNfBridge()
				->make(FormProcessorsFactoryContract::class);
	}

		/**
		 * Construct Ninja Forms action
		 */
	protected function constructNinjaFormsAction()
	{
		$nfActionFactory = $this->nfMailchimp->getNfBridge()
				->make(NfActionFactoryContract::class);

		$wordpress = new WpHooksApi();

		$newsletterExtension = new NewsletterExtension($this->nfMailchimp);

		$this->ninjaFormsAction = $nfActionFactory->constructNinjaFormsNewsletterAction(
			$this->actionEntity, // external
			$this->processHandler,
			$this->formProcessorFactory,
			$wordpress,
			$newsletterExtension
		);
	}

	
	/**
	 * Get the constructed Ninja Forms SubscribeToMailchimp Action
	 * @return NfActionContract
	 */
	public function getNinjaFormsAction():NfActionContract
	{
		return $this->ninjaFormsAction;
	}
}
