<?php


namespace NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints;

use NFMailchimp\EmailCRM\Mailchimp\RestApi\Responses\Response;
use NFMailchimp\EmailCRM\RestApi\Contracts\RequestContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\ResponseContract;

/**
 * Class GetMergeFields
 *
 * Endpoint to get all merge fields of a Mailchimp list via Mailchimp API.
 */
class GetMergeFields extends GetList
{

	/** @inheritDoc */
	public function getUri(): string
	{
		return 'lists/' . $this->constructParameterUri('listId', 'alphanumeric') . '/merge-fields';
	}

	/** @inheritDoc */
	public function handleRequest(RequestContract $request): ResponseContract
	{
		$listId = $request->getParam('listId');
		$client = $this->getListsClient($request->getParam('apiKey'));
		$action = new \NFMailchimp\EmailCRM\Mailchimp\Actions\GetMergeFields($client);
		try {
			$entity = $action->requestMergeFields($listId);
			return Response::fromEntity($entity);
		} catch (\Exception $exception) {
			$response = $this->constructExceptionResponse($exception, 'GetMergeFields');
			return $response;
		}
	}
}
