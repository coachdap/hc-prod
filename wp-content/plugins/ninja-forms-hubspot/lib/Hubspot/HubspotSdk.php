<?php

namespace NFHubspot\EmailCRM\Hubspot;

// ApiModule
use NFHubspot\EmailCRM\Hubspot\Sdk\Contacts;
use NFHubspot\EmailCRM\Hubspot\Sdk\Companies;
use NFHubspot\EmailCRM\Hubspot\Sdk\Deals;
use NFHubspot\EmailCRM\Hubspot\Sdk\Tickets;
use NFHubspot\EmailCRM\Hubspot\Sdk\Properties;
use NFHubspot\EmailCRM\Hubspot\Sdk\Associations;
use NFHubspot\EmailCRM\Hubspot\Sdk\ExtractCreateEntryResults;
use NFHubspot\EmailCRM\Hubspot\Sdk\ExtractAssociationResponse;
use NFHubspot\EmailCRM\Hubspot\Sdk\ConvertFieldPropertiesIntoFormFields;
// Shared
use NFHubspot\EmailCRM\Shared\Entities\FormFields;
use NFHubspot\EmailCRM\Shared\Contracts\RemoteRequestContract;
use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;

/**
 * Handles communication to and from the Api
 * 
 * This class is constructed by the ApiModule with a RemoteRequest and ApiKey,
 * after which it can be provided to the Integrating Plugin for use.
 */
class HubspotSdk {

    /**
     * API Key
     * @var string
     */
    protected $apiKey;

    /**
     * Remote Request Object
     * @var RemoteRequestContract
     */
    protected $remoteRequest;

    /**
     *
     * @var Contacts
     */
    protected $contacts;
    /**
     *
     * @var Companies
     */
    protected $companies;
    /**
     *
     * @var Deals
     */
    protected $deals;
    /**
     *
     * @var Tickets
     */
    protected $tickets;
    /**
     * Associations route
     * 
     * Note that nomenclature for property name is different than other routes 
     * to differentiate between the route and the array of actual associations.
     * 
     * @var Associations
     */
    protected $associationsRoute;
    /**
     *
     * @var Properties
     */
    protected $properties;

    /**
     * Module Configuration
     * @var array
     */
    protected $moduleConfig;
    
    /**
     * Keyed array of newly created entries with their Ids
     * 
     * Used to link created objects together
     * @var array
     */
    protected $idArray=[];
    
    /**
     * Array of HandledResponse
     * @var HandledResponse[]
     */
    protected $handledResponses=[];
    
    /**
     * Keyed array of associations that link entries to each other
     * 
     * @var array
     */
    protected $associations=[];
    
    /**
     * Instantiate the ApiModule SDK
     * 
     * @param RemoteRequestContract $remoteRequest
     * @param string $apiKey
     * @param array $moduleConfig
     */
    public function __construct(RemoteRequestContract $remoteRequest, string $apiKey, array $moduleConfig) {
        $this->remoteRequest = $remoteRequest;
        $this->apiKey = $apiKey;
        $this->moduleConfig=$moduleConfig;
    }

    /**
     * Return all standard and custom Contact fields
     * 
     * @return FormFields
     */
    public function getContactFields(): FormFields {

        $responseBody = $this->getPropertiesRoute()
                ->getContactProperties()
                ->getResponseBody();

        $formFields = (new ConvertFieldPropertiesIntoFormFields())->handle($responseBody, 'contacts');

        return $formFields;
    }

    /**
     * Return all standard and custom Contact fields
     * 
     * @return FormFields
     */
    public function getCompanyFields(): FormFields {

        $responseBody = $this->getPropertiesRoute()
                ->getCompanyProperties()
                ->getResponseBody();

        $formFields = (new ConvertFieldPropertiesIntoFormFields())->handle($responseBody, 'companies');

        return $formFields;
    }

    /**
     * Return all standard and custom Deal fields
     * 
     * @return FormFields
     */
    public function getDealFields(): FormFields {

        $responseBody = $this->getPropertiesRoute()
                ->getDealProperties()
                ->getResponseBody();

        $formFields = (new ConvertFieldPropertiesIntoFormFields())->handle($responseBody, 'deals');

        return $formFields;
    }

    /**
     * Return all standard and custom Ticket fields
     * 
     * @return FormFields
     */
    public function getTicketFields(): FormFields {

        $responseBody = $this->getPropertiesRoute()
                ->getTicketProperties()
                ->getResponseBody();

        $formFields = (new ConvertFieldPropertiesIntoFormFields())->handle($responseBody, 'tickets');

        return $formFields;
    }

    /**
     * Make request to create entry(ies) from form submission
     * 
     * @param array $unsortedRequest
     * @return array
     */
    public function createEntry(array $unsortedRequest): array {

        $this->createModules($unsortedRequest);
        
        $this->createAssociations();

        return array_values($this->handledResponses);
    }

    /**
     * Iterate unsorted request to make requests to add entries
     * @param array $unsortedRequest
     */
    protected function createModules(array $unsortedRequest) {
        foreach (array_keys($this->moduleConfig['modules']) as $module) {
       
            if(!isset($unsortedRequest[$module]) || empty($unsortedRequest[$module])){
                continue;
            }
            
            $handledResponse = $this->createModule($unsortedRequest, $module);

            if (is_null($handledResponse)) {  continue;  }

            $this->handledResponses[$module] = (new ExtractCreateEntryResults())
                    ->extractResults($handledResponse);
            
            $this->handledResponses[$module]->setContext('Create_' . $module);
            
            $this->extractIds($module);
        }
    }
    /**
     * Make request to create the given module using the unsorted request data
     * 
     * @param string $module
     * @return HandledResponse|null
     */
    protected function createModule(array $unsortedRequest, string $module): ?HandledResponse {
         switch ($module) {

                case 'contacts':
                    $handledResponse = $this->getContactsRoute()
                        ->createContact(json_encode($unsortedRequest[$module]));
                    break;
                case 'companies':
                    $handledResponse = $this->getCompaniesRoute()
                        ->createCompany(json_encode($unsortedRequest[$module]));
                    break;
                case 'deals':
                    $handledResponse = $this->getDealsRoute()
                        ->createDeal(json_encode($unsortedRequest[$module]));
                    break;
                case 'tickets':
                    $handledResponse = $this->getTicketsRoute()
                        ->createTicket(json_encode($unsortedRequest[$module]));
                    break;
            }
            
            if (!is_null($handledResponse)) {
                return $handledResponse;
            }
    }
    
    /**
     * Extract Id of newly created entry with which to construct associations
     * 
     * @param string $module
     */
    protected function extractIds(string $module) {
          $extractedIdArray = $this->handledResponses[$module]->getRecords();
            
            if (!empty($extractedIdArray)) {
                $keys = array_keys($extractedIdArray);
                
                $associationKey = $this->moduleConfig['modules'][$module]['associationKey'];
                
                $this->idArray[$associationKey] = $keys[0];
                
                $this->buildAssociations($associationKey);
            }             
            
    }
    
    /**
     * Check if two entries have Ids that can be linked; add them to association array
     * 
     * @param string $associationKey
     * @return void
     */
    protected function buildAssociations(string $associationKey) {
        
        // Return UNLESS BOTH moduleConfig is defined and Id is set
        if(!isset($this->moduleConfig['relationships'][$associationKey]) ||
                !isset($this->idArray[$associationKey])){
            return;
        }else{
            $relationshipArray=$this->moduleConfig['relationships'][$associationKey];
        }
        
        foreach ($relationshipArray as $linkedKey => $associationType) {
            
            if(isset($this->idArray[$linkedKey])){
                $this->associations[]=[
                    'from'=>$this->idArray[$linkedKey],
                    'to'=>$this->idArray[$associationKey],
                    'type'=>$associationType
                ];
            }
        }
    }
    
    /**
     * Make all associations requests
     * 
     * Associations link created entries together
     * 
     * @return void
     */
    protected function createAssociations() {

        if (empty($this->associations)) {
            return;
        }

        $responseExtractor = new ExtractAssociationResponse();

        foreach ($this->associations as $association) {

            $handledResponse = $responseExtractor->extractResults(
                    $this->getAssociationsRoute()
                            ->createAssociation($association)
            );

            $handledResponse->setContext('Link_' . $association[ 'type' ]);

            $this->handledResponses[ $association[ 'type' ] ] = $handledResponse;
        }
    }

    /**
     * Return Properties route
     * 
     * @return Properties
     */
    protected function getPropertiesRoute(): Properties {
        if (!isset($this->properties)) {
            $this->properties = new Properties($this->remoteRequest, $this->apiKey);
        }

        return $this->properties;
    }

    /**
     * Return Contacts route
     * 
     * @return Contacts
     */
    protected function getContactsRoute(): Contacts {
        if (!isset($this->contacts)) {
            $this->contacts = new Contacts($this->remoteRequest, $this->apiKey);
        }

        return $this->contacts;
    }

    /**
     * Return Companies route
     * 
     * @return Companies
     */
    protected function getCompaniesRoute(): Companies {
        if (!isset($this->companies)) {
            $this->companies = new Companies($this->remoteRequest, $this->apiKey);
        }

        return $this->companies;
    }
    
    /**
     * Return Deals route
     * 
     * @return Deals
     */
    protected function getDealsRoute(): Deals {
        if (!isset($this->deals)) {
            $this->deals = new Deals($this->remoteRequest, $this->apiKey);
        }

        return $this->deals;
    }
    
    /**
     * Return Tickets route
     * 
     * @return Tickets
     */
    protected function getTicketsRoute(): Tickets {
        if (!isset($this->tickets)) {
            $this->tickets = new Tickets($this->remoteRequest, $this->apiKey);
        }

        return $this->tickets;
    }
    
    /**
     * Return Associations route
     * 
     * @return Associations
     */
    protected function getAssociationsRoute(): Associations{
        if(!isset($this->associationsRoute)){
            $this->associationsRoute = new Associations($this->remoteRequest, $this->apiKey);
        }
        
        return $this->associationsRoute;
    }
    
    /**
     * Return ID array - collection of Ids of newly created entries
     * 
     * @return array
     */
    public function getIdArray():array {
        return $this->idArray;
    }

    /**
     * Return associations array of links between newly created entries
     * 
     * @return array
     */
    public function getAssociations():array {
        return $this->associations;
    }


}
