<?php

namespace NFHubspot\EmailCRM\Shared\Handlers;

use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;

/**
 * Consolidates collection of HandledResponses into single response
 * 
 * Form processing may make multiple requests for a single submission, each of 
 * which has its own HandledResponse.  This class consolidates the responses 
 * into a single response so that downstream operations have a single instance 
 * with which to work.
 */
class ConsolidateHandledResponses {

    /**
     * Collection of standardized response entity communicating results
     * 
     * @var HandledResponse[]
     */
    protected $handledResponseCollection;

    
    /**
     *
     * @var HandledResponse 
     */
    protected $consolidatedHandledResponse;
    
    /**
     * Consolidate collection of HandledResponses into single HandledResponse
     * 
     * @param array $handledResponseCollection
     * @return HandledResponse
     */
    public function handle(array $handledResponseCollection): HandledResponse {
        $this->handledResponseCollection=$handledResponseCollection;
        
        $this->consolidatedHandledResponse= new HandledResponse();
        
        $validCollection = $this->ensureValidCollection();
        
        if(!$validCollection){
            $this->setInvalidRequestResponse();
        }else{
            $this->consolidateResponses();
        }
        
        return $this->consolidatedHandledResponse;
    }
   
    /**
     * Consolidate responses into a single response
     * 
     * A failure in any boolean counts as a failure; all error messages
     * combined in response order; record counts summed.
     */
    protected function consolidateResponses() {
        
        foreach ($this->handledResponseCollection as $handledResponse) {
        // if any boolean fails, consolidate as failure
            if(!$handledResponse->isSuccessful()){
                $this->consolidatedHandledResponse->setIsSuccessful(false);
            }
            if($handledResponse->isApiError()){
                $this->consolidatedHandledResponse->setIsApiError(true);
            }
            if($handledResponse->isWpError()){
                $this->consolidatedHandledResponse->setIsWpError(true);
            }
            if($handledResponse->isException()){
                $this->consolidatedHandledResponse->setIsException(true);
            }
            
            $this->consolidatedHandledResponse->setRecordCount(
                    $this->consolidatedHandledResponse->getRecordCount()+
                    $handledResponse->getRecordCount()
                    );
            $this->consolidatedHandledResponse->setErrorMessages(
                    array_merge(
                            $this->consolidatedHandledResponse->getErrorMessages(),
                            $handledResponse->getErrorMessages()
                            )
                    );
        }
    }
    
    /**
     * Ensures incoming value is indexed array of HandledResponses
     * 
     * @return bool
     */
    protected function ensureValidCollection():bool {
               
        if(!is_array($this->handledResponseCollection)){
            
            $continue = false;
        }else{
            
            $continue = true;
            
            foreach ($this->handledResponseCollection as $element) {              
                if(!is_a($element,HandledResponse::class)){
                     $continue=false;
                    break;
                }
            }  
        }
        
        return $continue;
    }
    
    /**
     * Sets handled response when incoming request is invalid
     */
    protected function setInvalidRequestResponse() {
        
        $this->consolidatedHandledResponse->setIsSuccessful(false);
        $this->consolidatedHandledResponse->appendErrorMessage('handled_response_collection_not_valid');
    }
}
