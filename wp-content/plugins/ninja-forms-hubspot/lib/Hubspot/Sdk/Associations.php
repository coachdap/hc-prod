<?php

namespace NFHubspot\EmailCRM\Hubspot\Sdk;

// API Module
use NFHubspot\EmailCRM\Hubspot\Sdk\ApiClient;
// Shared
use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;

/**
 * Handles requests made to the Associations route of the API Module
 */
class Associations extends ApiClient {

    const MODULE_ROUTE = 'associations';

    /*
     * Set fully constructed URL for contact related requests
     * 
     * @param string $endpoint
     */

    protected function setEndpoint(string $endpoint) {
        $url = self::ROUTE . self::MODULE_ROUTE . $endpoint . '/batch/create?hapikey=' . $this->apiKey;
        $this->remoteRequest->setUrl($url);
    }

    /**
     * Create a batch of associations
     * 
     * @return HandledResponse
     */
    public function createAssociation(array $association): HandledResponse {

        $json = json_encode($this->buildBatchBody($association));

        switch ($association['type']) {
            case 'contact_to_company':
                $endpoint='/contacts/companies';           
                break;
            case 'contact_to_deal':
                $endpoint='/contacts/deals';           
                break;
            case 'company_to_deal':
                $endpoint='/companies/deals';           
                break;
            case 'contact_to_ticket':
                $endpoint='/contacts/tickets';           
                break;
            case 'company_to_ticket':
                $endpoint='/companies/tickets';           
                break;
            case 'deal_to_ticket':
                $endpoint='/deals/tickets';           
                break;

            default:
                $endpoint='';
                break;
        }
        $this->setEndpoint($endpoint);
        
        $this->remoteRequest->setHttpArg('method', 'POST');
        $this->remoteRequest->setBody($json);
        $handledResponse = $this->makeRequest();

        return $handledResponse;
    }

    protected function buildBatchBody(array $association): array {


        $batch = [ 'inputs' => [
                [
                    'from' => [ 'id' => $association[ 'from' ] ],
                    'to' => [ 'id' => $association[ 'to' ] ],
                    'type' => $association[ 'type' ]
                ]
            ]
        ];


        return $batch;
    }

}
