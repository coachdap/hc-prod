<?php


namespace NFMailchimp\EmailCRM\Mailchimp\RestApi\Endpoints;

use NFMailchimp\EmailCRM\Mailchimp\RestApi\Responses\Response;
use NFMailchimp\EmailCRM\RestApi\Contracts\RequestContract;
use NFMailchimp\EmailCRM\RestApi\Contracts\ResponseContract;
// appends `action` to differentiate between action and endpoint
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetInterestCategories as GetInterestCategoriesAction;

/**
 * Endpoint to get all Interest Categories of a Mailchimp list via Mailchimp API.
 */
class GetInterestCategories extends GetList
{

	/** @inheritDoc */
	public function getUri(): string
	{
		return 'lists/' . $this->constructParameterUri('listId', 'alphanumeric') . '/interest-categories';
	}

	/** @inheritDoc */
	public function handleRequest(RequestContract $request): ResponseContract
	{
		$listId = $request->getParam('listId');
		$client = $this->getListsClient($request->getParam('apiKey'));
		$action = new GetInterestCategoriesAction($client);
		try {
			$entity = $action->requestInterestCategories($listId);
			return Response::fromEntity($entity);
		} catch (\Exception $exception) {
			$response = $this->constructExceptionResponse($exception, 'GetInterestCategories');
			return $response;
		}
	}
}
