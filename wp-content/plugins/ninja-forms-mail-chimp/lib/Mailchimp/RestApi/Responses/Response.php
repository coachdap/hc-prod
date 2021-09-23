<?php


namespace NFMailchimp\EmailCRM\Mailchimp\RestApi\Responses;

use NFMailchimp\EmailCRM\Mailchimp\Entities\MailChimpEntity;

/**
 * Class Response
 *
 * Response object with factory methods from entities or exceptions
 */
class Response extends \NFMailchimp\EmailCRM\RestApi\Response
{

	/**
	 * Create response object from any MailChimpEntity
	 *
	 * @param MailChimpEntity $entity Entity to return
	 * @param int $status Optional. HTTP status to set. Default is 200
	 * @return Response
	 */
	public static function fromEntity(MailChimpEntity $entity, int $status = 200): Response
	{
		$obj = new static();
		$obj->setData($entity->toArray());
		$obj->setStatus($status);
		return $obj;
	}

	/**
	 * Create response object from any Exception
	 *
	 * @param \Exception $exception Exception to respond with
	 * @return Response
	 */
	public static function fromException(\Exception $exception): Response
	{
		$obj = new static();
		$obj->setData(['message' => $exception->getMessage()]);
		$obj->setStatus($exception->getCode() ? (int)$exception->getCode() : 500);
		return $obj;
	}
}
