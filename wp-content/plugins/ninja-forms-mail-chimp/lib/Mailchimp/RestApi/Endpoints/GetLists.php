<?php


namespace NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints;

// Mailchimp
use NFMailchimp\EmailCRM\Mailchimp\Entities\Account;
use NFMailchimp\EmailCRM\Mailchimp\RestApi\Responses\Response;
use NFMailchimp\EmailCRM\Mailchimp\Handlers\DiagnoseException;

//REST API
use NFMailchimp\EmailCRM\RestApi\Contracts\RequestContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\ResponseContract;

/**
 * Class GetLists
 *
 * Api endpoint for getting all lists of an account from Mailchimp API
 */
class GetLists extends Endpoint
{
		/**
		 *
		 * @var DiagnoseException
		 */
		protected $diagnoseException;
	
	/** @inheritDoc */
	public function getUri(): string
	{
		return '/lists';
	}

	/** @inheritDoc */
	public function getArgs(): array
	{
		return [
			'apiKey' => [
				'type' => 'string',
				'required' => true
			]
		];
	}

	/** @inheritDoc */
	public function handleRequest(RequestContract $request): ResponseContract
	{
		$apiKey = $request->getParam('apiKey');

		//Having Account object here feels silly
		$account = new Account();
		$account->setApiKey($apiKey);
		$client = $this->getListsClient($apiKey);
		$action = new \NFMailchimp\EmailCRM\Mailchimp\Actions\GetLists($client, $account);
		try {
			$lists = $action->requestLists();
			return Response::fromEntity($lists);
		} catch (\Exception $exception) {
			$response = $this->constructExceptionResponse($exception, 'GetLists');
			return $response;
		}
	}
}
