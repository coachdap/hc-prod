<?php

namespace NFHubspot\EmailCRM\Hubspot\Sdk;

// Shared
use NFHubspot\EmailCRM\Shared\Contracts\RemoteRequestContract;
use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;

/**
 * Abstract class for making requests to and returning response from API
 *
 */
abstract class ApiClient {
    /**
     * Route under which all endpoints reside
     */
    const ROUTE = 'https://api.hubapi.com/crm/v3/';
    /**
     * Remote Request object
     * 
     * @var RemoteRequestContract
     */
    protected $remoteRequest;

    /**
     *
     * @var string
     */
    protected $apiKey;
    /**
     * Construct instance that handles API requests
     * 
     *
     * @param RemoteRequestContract $remoteRequest
     * @param string $apiKey
     */
    public function __construct(RemoteRequestContract $remoteRequest, string $apiKey) {
        $this->remoteRequest = $remoteRequest;
        $this->apiKey=$apiKey;
    }

    /**
     * Set endpoint, including apiKey 
     */
    abstract protected function setEndpoint(string $endpoint);

    /**
     * Make request to the specified enpoint, returning the handled response
     * 
     * @return HandledResponse
     */
    protected function makeRequest(): HandledResponse {

        $this->constructRequestHeader();

        $handledResponse = $this->remoteRequest->handle();

        return $handledResponse;
    }

    /**
     * Construct request header
     */
    protected function constructRequestHeader() {
        $this->remoteRequest->setHeaderParameter('Content-Type', 'application/json');
    }

}
