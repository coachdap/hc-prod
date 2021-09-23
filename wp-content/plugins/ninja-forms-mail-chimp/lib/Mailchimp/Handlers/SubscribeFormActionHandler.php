<?php

namespace NFMailchimp\EmailCRM\Mailchimp\Handlers;

// Contracts
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetAudienceDefinitionData;
use NFMailchimp\EmailCRM\Mailchimp\Entities\SingleList;
use NFMailchimp\EmailCRM\Shared\Contracts\FormActionHandler;
use NFMailchimp\EmailCRM\Shared\Contracts\SubmissionDataContract;
use NFMailchimp\EmailCRM\Shared\Contracts\FormContract;
use Mailchimp\http\MailchimpHttpClientInterface;
// Factories
use NFMailchimp\EmailCRM\Mailchimp\Factories\MailchimpApiService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConstructSubscriberFactoryService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConvertSubmissionDataToSubscriberFactoryService;
// Actions
use NFMailchimp\EmailCRM\Mailchimp\Contracts\ConvertSubmissionDataToSubscriberContract;
// Entitities
use NFMailchimp\EmailCRM\Mailchimp\Entities\AudienceDefinition;
// API
use Mailchimp\MailchimpLists;

/**
 * Subscribe a new member to Mailchimp
 *
 * Given the form SubmissionData and Form object upon form submission
 *
 *
 *
 */
class SubscribeFormActionHandler implements FormActionHandler
{

	/**
	 *
	 * @var ConstructSubscriberFactoryService
	 */
	protected $constructSubscriberFactory;

	/**
	 *
	 * @var ConvertSubmissionDataToSubscriberFactoryService
	 */
	protected $convertSubmissionDataToSubscriberFactory;

	/**
	 *
	 * @var MailchimpApiService
	 */
	protected $mailchimpApiFactory;

	/**
	 *
	 * @var MailchimpHttpClientInterface|null
	 */
	protected $httpClient;

	/**
	 * Collection of audience definitions, keyed on listId
	 * @var AudienceDefinition[]
	 */
	protected $audienceDefinitions = [];

	/**
	 *
	 * @var SubmissionDataContract
	 */
	protected $submissionData;

	/**
	 *
	 * @var FormContract
	 */
	protected $form;

	/**
	 * List ID for Mailchimp list
	 *
	 * Provided through submission data, it identifies which audience defintion
	 * is to be used in constructing the Subscriber entity
	 * @var string
	 */
	protected $listId;

	/**
	 * Object converting SubmissionData obejct into Subscriber object
	 * @var ConvertSubmissionDataToSubscriberContract
	 */
	public $convertSubmissionDataToSubscriber;

	public $response;

	/**
	 * Construct SubscribeFormActionHandler
	 *
	 * @param ConstructSubscriberFactoryService $constructSubscriberFactory
	 * @param ConvertSubmissionDataToSubscriberFactoryService $convertSubmissionDataToSubscriberFactory
	 * @param MailchimpApiService $mailchimpApi
	 * @param MailchimpHttpClientInterface $client
	 */
	public function __construct(
		ConstructSubscriberFactoryService $constructSubscriberFactory,
		ConvertSubmissionDataToSubscriberFactoryService $convertSubmissionDataToSubscriberFactory,
		MailchimpApiService $mailchimpApi,
		MailchimpHttpClientInterface $client = null
	) {
		$this->constructSubscriberFactory = $constructSubscriberFactory;
		$this->convertSubmissionDataToSubscriberFactory = $convertSubmissionDataToSubscriberFactory;
		$this->mailchimpApiFactory = $mailchimpApi;
		$this->httpClient = $client;
	}

	/**
	 * Add an AudienceDefinition to the collection
	 *
	 * These are the audience definitions to which Mailchimp can subscribe
	 * The form action provides the list ids from which the user selects one
	 * and the form action constructs the field maps from the selected audience
	 * definition
	 *
	 * @param AudienceDefinition $audienceDefinition
	 * @return \NFMailchimp\EmailCRM\Mailchimp\Handlers\SubscribeFormActionHandler
	 */
	public function addAudienceDefinition(AudienceDefinition $audienceDefinition): SubscribeFormActionHandler
	{
		$this->audienceDefinitions[$audienceDefinition->getListId()] = $audienceDefinition;
		return $this;
	}

	/** @inheritdoc */
	public function handle(SubmissionDataContract $submissionData, FormContract $form) : array
	{

		$this->submissionData = $submissionData;
		$this->form = $form;
		$this->listId = $this->submissionData->getValue('listId');
		$apiKey = $this->submissionData->getValue('apiKey');

		//If this request is to unsubscribe, then use a UnsubscribeHandler instead.
		$status = $this->submissionData->getValue('status');
		if ('unsubscribe' === $status) {
			$handler = new UnsubscribeHandler($this->mailchimpApiFactory, $this->httpClient);
			return  $handler->handle($submissionData, $form);
		}

		if (isset($this->audienceDefinitions[$this->listId])) {
			$audienceDefinition = $this->audienceDefinitions[$this->listId];
		} else {
			$audienceDefinition = (
			new GetAudienceDefinitionData(
				$this->mailchimpApiFactory->listsApi($apiKey, $this->httpClient),
				(new SingleList())->setId($this->listId)
			)
			)->handle();
		}
		$this->addAudienceDefinition($audienceDefinition);
		$this->constructSubscriber();
		$this->subscribeToList();
		if (is_a($this->response, \Exception::class)) {
			return  [
				'type' => 'error',
				'note' => $this->response->getMessage()
			];
		}
		return  [];
	}

	/**
	 * Construct subscriber from AudienceDefinition and SubmissionData
	 */
	protected function constructSubscriber()
	{

		$selectedAudienceDefinition = $this->audienceDefinitions[$this->listId];

		$constructSubscriber = $this->constructSubscriberFactory->
		getConstructSubscriber($selectedAudienceDefinition);

		$this->convertSubmissionDataToSubscriber = $this->convertSubmissionDataToSubscriberFactory
			->getConvertSubmissionDataToSubscriber($this->submissionData, $constructSubscriber);
	}

	/**
	 * Make request to Mailchimp to subscribe new subscriber to audience list
	 */
	protected function subscribeToList()
	{
		$apiKey = $this->submissionData->getValue('apiKey', '');
		$mailchimpLists = $this->mailchimpApiFactory->listsApi($apiKey, $this->httpClient);
		try {
			$response = $mailchimpLists->addOrUpdateMember(
				$this->listId,
				$this->convertSubmissionDataToSubscriber->getEmailAddress(),
				$this->convertSubmissionDataToSubscriber->getRequestBody()
			);
						
						$this->response = [
							'type'=>'success',
							'response'=>$response,
							'context'=>'SubscribeFormActionHandler_subscribeToList'
						];
		} catch (\Exception $exception) {
					$this->response = $exception;
		}
	}

	/** @inheritdoc */
	public function getStage(): string
	{
		//@TODO: ensure stage is in common location NF/CF
	}
}
