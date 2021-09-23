<?php

namespace NFMailchimp\EmailCRM\Mailchimp;

// Mailchimp
use NFMailchimp\EmailCRM\Mailchimp\Actions\GetList;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\GetsListFromApi;
use NFMailchimp\EmailCRM\Mailchimp\Contracts\MailchimpContract;

use NFMailchimp\EmailCRM\Mailchimp\Factories\ActionFactory;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ActionFactoryService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\DiagnoseExceptionFactory;
use NFMailchimp\EmailCRM\Mailchimp\Factories\DiagnoseExceptionService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\MailchimpApi;
use NFMailchimp\EmailCRM\Mailchimp\Factories\MailchimpApiService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConstructSubscriberFactory;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConstructSubscriberFactoryService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\AudienceService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\AudienceFactory;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConvertSubmissionDataToSubscriberFactory;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConvertSubmissionDataToSubscriberFactoryService;
use NFMailchimp\EmailCRM\Mailchimp\Factories\ConfigurationFactory;
// Shared
use NFMailchimp\EmailCRM\Shared\Containers\ServiceContainer;
use NFMailchimp\EmailCRM\Shared\Contracts\Module;

use NFMailchimp\EmailCRM\WpBridge\Http\MailchimpWpHttpClient;

/**
 * Exposes the top-level API of the package
 */
class Mailchimp extends ServiceContainer implements MailchimpContract
{

	/**
	 * Unique identifier for package
	 */
	const IDENTIFIER = 'Mailchimp';

	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
	}

	/**
	 * @inheritDoc
	 */
	public function registerServices(): Module
	{
		// Bind Mailchimp API service to container
		$this->bind(MailchimpApiService::class, function () {
					
					$httpClient = new MailchimpWpHttpClient();
					
					$mailchimpApi = new MailchimpApi();
					
					$mailchimpApi->setDefaultClient($httpClient);
			
					return $mailchimpApi;
		});

		// Bind action factory to the container
		$this->bind(ActionFactoryService::class, function () {
			return new ActionFactory($this->make(MailchimpApiService::class));
		});

		// Bind ConstructSubscriber factory to the container
		$this->bind(ConstructSubscriberFactoryService::class, function () {
			return new ConstructSubscriberFactory();
		});


				 // Bind ConvertSubmissionDataToSubscriber factory to the container
				 $this->bind(ConvertSubmissionDataToSubscriberFactoryService::class, function () {

					 return new ConvertSubmissionDataToSubscriberFactory();
				 });


		// Bind Configuration factory
		$this->bind(ConfigurationFactory::class, function () {

			return new ConfigurationFactory(__DIR__);
		});

		//Bind audience definition creator
		$this->bind(AudienceService::class, function () {
			return new AudienceFactory($this);
		});

		//Bind the exception diagnostics factory
		$this->bind(DiagnoseExceptionService::class, function () {
			return new DiagnoseExceptionFactory();
		});

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getContainer(): Container
	{
		return $this;
	}
}
