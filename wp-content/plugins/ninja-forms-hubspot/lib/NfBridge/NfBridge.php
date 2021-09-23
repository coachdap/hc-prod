<?php

namespace NFHubspot\EmailCRM\NfBridge;

use NFHubspot\EmailCRM\NfBridge\Contracts\NfBridgeContract;
use NFHubspot\EmailCRM\Shared\Containers\ServiceContainer;
use NFHubspot\EmailCRM\Shared\Contracts\Module;

use NFHubspot\EmailCRM\NfBridge\Factories\FormFactory;
use NFHubspot\EmailCRM\NfBridge\Factories\FormFactoryContract;
use NFHubspot\EmailCRM\NfBridge\Factories\NfActionFactory;
use NFHubspot\EmailCRM\NfBridge\Factories\NfActionFactoryContract;
use NFHubspot\EmailCRM\NfBridge\Factories\SubmissionDataFactory;
use NFHubspot\EmailCRM\NfBridge\Contracts\SubmissionDataFactoryContract;
use NFHubspot\EmailCRM\NfBridge\Contracts\FormProcessorsFactoryContract;
use NFHubspot\EmailCRM\NfBridge\Factories\FormProcessorsFactory;
use NFHubspot\EmailCRM\NfBridge\Actions\RegisterAction;
use NFHubspot\EmailCRM\NfBridge\Actions\CreateAddNewModal;
use NFHubspot\EmailCRM\Shared\Contracts\ServiceContainerContract;
use NFHubspot\EmailCRM\WpBridge\WpHooksApi;
use NFHubspot\EmailCRM\WpBridge\Contracts\WpHooksContract;

/**
 * Exposes the top-level API of the package
 */
class NfBridge extends ServiceContainer implements NfBridgeContract
{

	/**
	 * Unique identifier for package
	 */
	const IDENTIFIER = 'nf-bridge';

		/**
		 *
		 * @var WpHooksContract
		 */
		protected $wpHooks;

		/**
		 * Set WpHooks to provide WP action hooks and filters
		 * @param WpHooksContract $wpHooks
		 */
	public function setWpHooks(WpHooksContract $wpHooks)
	{
		$this->wpHooks = $wpHooks;
	}

	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
	}

	/** @inheritDoc */
	public function getContainer(): ServiceContainerContract
	{
		return $this;
	}

	/**
	 * Register the module's services
	 *
	 * @return Module
	 */
	public function registerServices(): Module
	{
				// Bind FormFactory service to container
		$this->bind(FormFactoryContract::class, function () {
			return new FormFactory();
		});

		// Bind NFActionFactory to the container
		$this->bind(NfActionFactoryContract::class, function () {
			return new NfActionFactory();
		});

				// Bind SubmissionDataFactory to the container
				$this->bind(SubmissionDataFactoryContract::class, function () {

					return new SubmissionDataFactory();
				});

				// Bind FormProcessorsFactory to the container
				$this->bind(FormProcessorsFactoryContract::class, function () {
					if (is_null($this->wpHooks)) {
						$this->wpHooks= new WpHooksApi();
					}
					return new FormProcessorsFactory($this->wpHooks);
				});

				// Bind RegisterAction to the container
				$this->bind(RegisterAction::class, function () {
					if (is_null($this->wpHooks)) {
						$this->wpHooks= new WpHooksApi();
					}
					return new RegisterAction($this->wpHooks);
				});

                                // Bind CreateAddNewModal to the container
				$this->bind('CreateAddNewModal', function () {

					return new CreateAddNewModal();
				});
			return $this;
	}
}
