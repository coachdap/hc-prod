<?php

namespace NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints;

use NFMailchimp\EmailCRM\Mailchimp\RestApi\Responses\Response;
use NFMailchimp\EmailCRM\RestApi\Contracts\RequestContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\ResponseContract;
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetInterests as GetInterestsAction;

/**
 * Endpoint to get all interests of a Mailchimp interest category via Mailchimp API.
 */
class GetInterests extends GetList
{

	/** @inheritDoc */
	public function getUri(): string
	{
		return 'lists/'
				. $this->constructParameterUri('listId', 'alphanumeric') . '/interest-categories/'
				. $this->constructParameterUri('interestCategoryId', 'alphanumeric'). '/interests';
	}

	/** @inheritDoc */
	public function handleRequest(RequestContract $request): ResponseContract
	{
		$listId = $request->getParam('listId');
		$interestCategoryId = $request->getParam('interestCategoryId');
		
		$client = $this->getListsClient($request->getParam('apiKey'));
		$action = new GetInterestsAction($client);
		try {
			$entity = $action->requestInterests($listId, $interestCategoryId);
			return Response::fromEntity($entity);
		} catch (\Exception $exception) {
			$response = $this->constructExceptionResponse($exception, 'GetInterests');
			return $response;
		}
	}
}
