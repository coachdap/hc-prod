<?php

namespace NFMailchimp\NinjaForms\Mailchimp;

use NFMailchimp\EmailCRM\Mailchimp\Factories\MailchimpApi;
use NFMailchimp\EmailCRM\WpBridge\Http\MailchimpWpHttpClient;
use NFMailchimp\NinjaForms\Mailchimp\Contracts\NinjaFormsMailchimpContract;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\ConstructSubscribeAction;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\CreateAutogenerateModal;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\AuthorizesTrue;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\AutogenerateForm;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\NewsletterExtension;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\MailchimpOptIn;
use NFMailchimp\NinjaForms\Mailchimp\Endpoints\AutogenerateFormEndpoint;
use NFMailchimp\NinjaForms\Mailchimp\Handlers\OutputResponseDataMetabox;
// Mailchimp Bridge
use NFMailchimp\EmailCRM\Mailchimp\Contracts\MailchimpContract;
use NFMailchimp\EmailCRM\Mailchimp\Factories\MailchimpApiService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConfigurationFactory;
use NFMailchimp\EmailCRM\Mailchimp\Handlers\DiagnoseException;
use NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints\GetInterestCategories;
use NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints\GetInterests;
use NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints\GetList;
use NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints\GetLists;
use NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints\GetMergeFields;
use NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints\GetSegments;
//NF Bridge
use NFMailchimp\EmailCRM\NfBridge\Contracts\NfBridgeContract;
use NFMailchimp\EmailCRM\NfBridge\Actions\RegisterAction;
// Wordpress Bridge
use NFMailchimp\EmailCRM\WpBridge\RestApi\CreateWordPressEndpoints;
use NFMailchimp\EmailCRM\WpBridge\Database\TransientStore;
use NFMailchimp\EmailCRM\WpBridge\RestApi\AuthorizeRequestWithWordPressUser;
// REST API
use NFMailchimp\EmailCRM\RestApi\CachedEndpoint;

/**
 * Exposes the top-level API of the package
 */
class NinjaFormsMailchimp implements NinjaFormsMailchimpContract
{
		const VERSION = '3.2.0';
		const SLUG = 'mail-chimp';
		const NAME = 'MailChimp';
		const AUTHOR = 'The WP Ninjas';
		const PREFIX = 'NF_MailChimp';
	/**
	 * Unique identifier for package
	 */
	const IDENTIFIER = 'nf_mailchimp';

	/**
	 * REST Route for endpoints
	 */
	const RESTROUTE = 'nf-mailchimp/v2';

	/**
	 *
	 * @var MailchimpContract
	 */
	protected $mailchimpModule;

	/**
	 *
	 * @var NfBridgeContract
	 */
	protected $nfBridge;

	/**
	 * NinjaFormsMailchimp constructor.
	 *
	 * @param MailchimpContract $mailchimpModule
	 */
	public function __construct(MailchimpContract $mailchimpModule)
	{
		$this->mailchimpModule = $mailchimpModule;
	}

	/** @inheritDoc */
	public function getMailchimpModule(): MailchimpContract
	{
		return $this->mailchimpModule;
	}

	/** @inheritDoc */
	public function setNfBridge(NfBridgeContract $nfBridge): NinjaFormsMailchimpContract
	{
		$this->nfBridge = $nfBridge;
		return $this;
	}

	/** @inheritDoc */
	public function getNfBridge(): NfBridgeContract
	{
		return $this->nfBridge;
	}

	/** @inheritDoc */
	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
	}

	/**
	 * Initialize the REST API endpoints
	 *
	 * @since 4.0.0
	 *
	 * @uses "rest_api_init" hook.
	 */
	public function initApi(): void
	{
		$api = new CreateWordPressEndpoints('register_rest_route', self::RESTROUTE);

		/** @var MailchimpApi $factory */
		$factory = $this
			->getMailchimpModule()
			->make(MailchimpApiService::class);
		$factory->setDefaultClient(new MailchimpWpHttpClient());

		//Authorization for all REST API endpoints
		$authorizer = new AuthorizeRequestWithWordPressUser('manage_options');
		$diagnoseException = $this->makeDiagnoseException();

		//List endpoint
		$getList = new GetList($factory, $authorizer);
		$getList->addDiagnoseException($diagnoseException);
		$api->registerRouteWithWordPress(
			new CachedEndpoint($getList, new TransientStore($getList->getUri()))
		);

		//Lists endpoint
		$getLists = new GetLists($factory, $authorizer);
		$getLists->addDiagnoseException($diagnoseException);
		$api->registerRouteWithWordPress(
			new CachedEndpoint($getLists, new TransientStore($getLists->getUri()))
		);

		//Segments endpoint
		$getSegments = new GetSegments($factory, $authorizer);
		$getSegments->addDiagnoseException($diagnoseException);
		$api->registerRouteWithWordPress(
			new CachedEndpoint($getSegments, new TransientStore($getSegments->getUri()))
		);

		//Merge Fields endpoint
		$getMergeFields = new GetMergeFields($factory, $authorizer);
		$getMergeFields->addDiagnoseException($diagnoseException);
		$api->registerRouteWithWordPress(
			new CachedEndpoint($getMergeFields, new TransientStore($getMergeFields->getUri()))
		);

		//Get Interests endpoint
		$getInterests = new GetInterests($factory, $authorizer);
		$getInterests->addDiagnoseException($diagnoseException);
		$api->registerRouteWithWordPress(
			new CachedEndpoint($getInterests, new TransientStore($getInterests->getUri()))
		);

		//Get Interests categories endpoint
		$getInterestCategories = new GetInterestCategories($factory, $authorizer);
		$getInterestCategories->addDiagnoseException($diagnoseException);
		$api->registerRouteWithWordPress(
			new CachedEndpoint($getInterestCategories, new TransientStore($getInterestCategories->getUri()))
		);

		//Get Autogenerate Form Endpoint
		// AutogenerateFormEndpoint triggers form building and is not cached for that reason
		$endpoint = new AutogenerateFormEndpoint();
		$autogenerateForm = new AutogenerateForm($this);
		$endpoint->setAutogenerateForm($autogenerateForm);
		$endpoint->addAuthorizer($authorizer);
		$endpoint->addDiagnoseException($diagnoseException);
		$api->registerRouteWithWordPress(
			$endpoint
		);
	}

	/**
	 * Register Mailchimp Opt In Field
	 *
	 * Carryover from NF Mailchimp 3.0 version
	 *
	 * @param array $actions
	 * @return array $actions
	 */
	public function registerOptIn($actions)
	{
		$actions['mailchimp-optin'] = new MailchimpOptIn();

		return $actions;
	}

	/**
	 * Setup Admin
	 *
	 * Setup admin classes for Ninja Forms and WordPress.
	 */
	public function setupAdmin()
	{

		new OutputResponseDataMetabox();
	}

	/**
	 * Make and return DiagnoseException handler
	 *
	 * Configuration happens in the (CF/NF - Mailchimp plugin), thus the configuration
	 * and diagnostics can be customized per each plugin
	 * @return DiagnoseException
	 */
	protected function makeDiagnoseException(): DiagnoseException
	{
		$configurationFactory = $this->
		getMailchimpModule()
			->make(ConfigurationFactory::class);

		$exceptionDiagnostics = $configurationFactory->getExceptionDiagnostics();

		$diagnoseException = new DiagnoseException($exceptionDiagnostics);

		return $diagnoseException;
	}

	/**
	 * Register the Subscribe action wtih Ninja Forms
	 */
	public function addSubscribeAction()
	{
		$constructedNfAction = (new ConstructSubscribeAction($this))->getNinjaFormsAction();

		$registerAction = $this->getNfBridge()
			->make(RegisterAction::class);
		$registerAction->addNfAction($constructedNfAction);
	}

	/**
	 * Craates modal with Add New form autogeneration buttons
	 * @param array $templates
	 * @return array
	 */
	public function registerAutogenerateModal($templates)
	{
		$newsletterList = new NewsletterExtension($this);
		$lists = $newsletterList->getLists(true);
				
		if (!empty($lists)) {
					$modal = (new CreateAutogenerateModal())->handle($lists);

					$templates[$modal->getId()] = $modal->toArray();
		}

                // Remove the Mailchimp ad if present
                if(isset($templates['mailchimp-signup'])){
                    unset($templates['mailchimp-signup']);
                }
                
		return $templates;
	}
}
