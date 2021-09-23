<?php

namespace NFHubspot\Handlers;

// API Module
use NFHubspot\EmailCRM\Hubspot\Handlers\CreateRecordsFormActionHandler;
// NF Bridge
use NFHubspot\EmailCRM\NfBridge\Contracts\NfActionProcessHandlerContract;

/**
 * Extends the default ApiModule FormActionHandler  for NF-specific requirements
 * 
 * Extracts data from the NF ->process(...,$data) property needed for processing
 * 
 * Returns the handled responses for any downstream processing and post processing
 */
class NfHubspotCreateRecordsFormActionHandler extends CreateRecordsFormActionHandler implements NfActionProcessHandlerContract {

    public function getPostProcessData():array {
        if(!isset($this->handledResponseCollection)){
            $this->handledResponseCollection=[];
        }
        return $this->handledResponseCollection;
    }
    /**
     * Extract processing data from form fields to return key-value pairs
     *
     * Some data required by submission action is contained within form
     * fields.  Given the form fields data upon submission, extract the
     * required data to return it as key-value pairs such that it can be
     * added to the submission data and processed
     * @param array $data Form field process data
     * @return array
     */
    public function extractFormFieldProcessingData(array $data): array {
        return $data;
    }

}
