<?php

namespace NFHubspot\EmailCRM\Hubspot\Sdk;

// API Module
use NFHubspot\EmailCRM\Hubspot\Sdk\ApiClient;

// Shared
use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;

/**
 * Handles requests made to the Contact route of the API Module
 */
class Tickets extends ApiClient{

const MODULE_ROUTE ='objects/tickets';
    /**
     * Set fully constructed URL for related requests
     * 
    * @param string $endpoint
    */
    protected function setEndpoint(string $endpoint){
        $url = self::ROUTE.self::MODULE_ROUTE.$endpoint.'?hapikey='.$this->apiKey;     
        $this->remoteRequest->setUrl($url);
        
    }


 
    /**
     * Create new ticket entry
     * 
     * @return HandledResponse
     */
    public function createTicket(string $body): HandledResponse{
        
        $json = json_encode(['properties'=>json_decode($body,true)]);
        $this->setEndpoint('');
        $this->remoteRequest->setHttpArg('method', 'POST');
        $this->remoteRequest->setBody($json);
        $handledResponse = $this->makeRequest();

        return $handledResponse;
    }



}
