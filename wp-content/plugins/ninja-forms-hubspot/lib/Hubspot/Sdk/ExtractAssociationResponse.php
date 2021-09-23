<?php

namespace NFHubspot\EmailCRM\Hubspot\Sdk;

use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;

/**
 * Extract Association results from HandledResponse
 */
class ExtractAssociationResponse {

    /**
     *
     * @var HandledResponse 
     */
    protected $handledResponse;

    /**
     * Decoded JSON response body
     * 
     * @var array
     */
    protected $body;

    /**
     * Extract pertinent information provided in the HandledResponse
     * 
     * Used extensively for troubleshooting rejections and other failures
     * 
     * @param HandledResponse $handledResponse
     * @return HandledResponse
     */
    public function extractResults(HandledResponse $handledResponse): HandledResponse {
        $this->handledResponse = $handledResponse;

        $this->body = json_decode($this->handledResponse->getResponseBody(), true);

        $checkComplete = $this->checkComplete();

        if (!$checkComplete) {
            $this->extractErrorData();
        }

        return $this->handledResponse;
    }

    /**
     * Check if association is successfully completed
     * 
     * @return bool
     */
    protected function checkComplete(): bool {

        if (isset($this->body[ 'status' ]) &&
                'COMPLETE' === strtoupper($this->body[ 'status' ])) {
            $complete = TRUE;
            $this->handledResponse->setIsSuccessful(TRUE);
            $this->handledResponse->setIsApiError(FALSE);
            $this->handledResponse->setIsException(FALSE);
            $this->handledResponse->setIsWpError(FALSE);
            $this->handledResponse->setRecordCount(1);
        } else {
            $complete = FALSE;
        }

        return $complete;
    }

    /**
     * Extract error data when error is previously confirmed
     */
    protected function extractErrorData() {

        $this->handledResponse->setIsSuccessful(FALSE);
        $this->handledResponse->setIsApiError(TRUE);
        $this->handledResponse->setIsException(FALSE);
        $this->handledResponse->setIsWpError(FALSE);
        $this->handledResponse->setRecordCount(0);

        if (isset($this->body[ 'status' ]) &&
                'error' === $this->body[ 'status' ]) {
            
            // set default error message
            $errorMessage = $this->body[ 'status' ];
            
            // overwrite not-so-helpful `error` message with more descriptive message
            if (isset($this->body[ 'message' ])) {
              $errorMessage = $this->body[ 'message' ];
            }        
            
            $this->handledResponse->appendErrorMessage($errorMessage);
        }
    }

}
