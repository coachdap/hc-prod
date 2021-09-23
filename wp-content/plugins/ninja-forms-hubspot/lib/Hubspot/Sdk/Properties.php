<?php

namespace NFHubspot\EmailCRM\Hubspot\Sdk;

// API Module
use NFHubspot\EmailCRM\Hubspot\Sdk\ApiClient;

// Shared
use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;

/**
 * Handles requests made to the Contact route of the API Module
 */
class Properties extends ApiClient{

const MODULE_ROUTE ='properties';
    /*
     * Set fully constructed URL for contact related requests
     * 
    * @param string $endpoint
    */
    protected function setEndpoint(string $endpoint){
        $url = self::ROUTE.self::MODULE_ROUTE.$endpoint.'?hapikey='.$this->apiKey;     
        $this->remoteRequest->setUrl($url);
    }


 
    /**
     * Get Contact properties (standard and custom field definitions)
     * 
     * @return HandledResponse
     */
    public function getContactProperties(): HandledResponse{
        
        $this->setEndpoint('/contacts');
        $handledResponse = $this->makeRequest();

        return $handledResponse;
    }

    /**
     * Get Companies properties (standard and custom field definitions)
     * 
     * @return HandledResponse
     */
    public function getCompanyProperties(): HandledResponse{
        
        $this->setEndpoint('/companies');
        $handledResponse = $this->makeRequest();

        return $handledResponse;
    }

    /**
     * Get Deal properties (standard and custom field definitions)
     * 
     * @return HandledResponse
     */
    public function getDealProperties(): HandledResponse{
        
        $this->setEndpoint('/deals');
        $handledResponse = $this->makeRequest();

        return $handledResponse;
    }
    
        /**
     * Get Ticket properties (standard and custom field definitions)
     * 
     * @return HandledResponse
     */
    public function getTicketProperties(): HandledResponse{
        
        $this->setEndpoint('/tickets');
        $handledResponse = $this->makeRequest();

        return $handledResponse;
    }
}
