<?php


namespace NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints;

// Mailchimp Bridge
use NFMailchimp\EmailCRM\Mailchimp\Factories\MailchimpApiService as MailchimpApiFactory;
use NFMailchimp\EmailCRM\Mailchimp\Handlers\DiagnoseException;
use NFMailchimp\EmailCRM\Mailchimp\RestApi\Responses\Response;

// REST API
use NFMailchimp\EmailCRM\RestApi\Contracts\AuthorizeRequestContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\RequestContract;
use NFMailchimp\EmailCRM\RestApi\Traits\ConstructsUris;

use Mailchimp\MailchimpLists;

/**
 * Class Endpoint
 *
 * Base class for REST API endpoints for Mailchimp functions.
 */
abstract class Endpoint extends \NFMailchimp\EmailCRM\RestApi\Endpoint
{

	use ConstructsUris;

	/**
	 * @var MailchimpApiFactory
	 */
	protected $mailchimpApiFactory;


	/**
	 * @var AuthorizeRequestContract
	 */
	protected $authorizer;

	/**
	 * Endpoint constructor.
	 * @param MailchimpApiFactory $mailchimpApiFactory
	 * @param AuthorizeRequestContract $authorizer
	 */
	public function __construct(MailchimpApiFactory $mailchimpApiFactory, AuthorizeRequestContract $authorizer)
	{
		$this->mailchimpApiFactory = $mailchimpApiFactory;
		$this->authorizer = $authorizer;
	}

	/**
	 * Get a list's client for an API key
	 *
	 * @param string $apiKey
	 * @return MailchimpLists
	 */
	protected function getListsClient(string $apiKey): MailchimpLists
	{
		return $this->mailchimpApiFactory->listsApi($apiKey);
	}

	/**
	 * @inheritDoc
	 */
	public function authorizeRequest(RequestContract $request): bool
	{
		return $this->authorizer->authorizeRequest($request);
	}

	/**
	 * Add a DiagnoseException handler
	 * @param DiagnoseException $diagnoseException
	 * @return void
	 */
	public function addDiagnoseException(DiagnoseException $diagnoseException): void
	{
		$this->diagnoseException = $diagnoseException;
	}

	/**
	 * Construct exception response from given exception
	 * @param \Exception $exception
	 * @param string $context
	 * @return Response
	 */
	protected function constructExceptionResponse($exception, string $context = ''): Response
	{
		$response = new Response();
		$exceptionString = $exception->getMessage();

		if (isset($this->diagnoseException)) {
			$diagnostics = $this->diagnoseException->handle($exceptionString, $context);
		} else {
			$diagnostics = [];
		}

		$data = [
			'message' => $exceptionString,
			'context' => $context,
			'diagnostics' => $diagnostics
		];

		$response->setData($data);

		$response->setStatus($exception->getCode() ? (int)$exception->getCode() : 500);
		return $response;
	}
}
