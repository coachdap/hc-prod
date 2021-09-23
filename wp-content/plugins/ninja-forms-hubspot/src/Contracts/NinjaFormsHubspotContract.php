<?php

namespace NFHubspot\Contracts;

// API Module
use NFHubspot\EmailCRM\Hubspot\Contracts\HubspotContract;
// NF Bridge
use NFHubspot\EmailCRM\NfBridge\Contracts\NfBridgeContract;
use NFHubspot\EmailCRM\Shared\Contracts\Module;
/**
 * Contract that describes the top-level API of the package
 */
interface NinjaFormsHubspotContract extends Module
{

	/**
	 * Initialize the REST API endpoints
	 *
	 * @since 3.2.0
	 *
	 * @uses "rest_api_init" hook.
	 */
	public function initRestApi(): void;

	/**
	 * Set the NfBridge
	 * @param NfBridgeContract $nfBridge
	 * @return NinjaFormsMailchimpContract
	 */
	public function setNfBridge(NfBridgeContract $nfBridge): NinjaFormsHubspotContract;

	/**
	 * Get the NfBridge
	 * @return NfBridgeContract
	 */
	public function getNfBridge(): NfBridgeContract;

	/**
	 * Get instance of top level API Module
	 *
	 * @return HubspotContract
	 * @since 3.0.0
	 *
	 */
	public function setApiModule(HubspotContract $apiModule): NinjaFormsHubspotContract;

	/**
	 * Set instance of top level API Module
	 *
	 * @return HubspotContract
	 * @since 3.0.0
	 *
	 */
	public function getApiModule(): HubspotContract;
}
