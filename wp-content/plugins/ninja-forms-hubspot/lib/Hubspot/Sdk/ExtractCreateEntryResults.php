<?php

namespace NFHubspot\EmailCRM\Hubspot\Sdk;

use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;

/**
 * Extract CreateEntry results from HandledResponse
 */
class ExtractCreateEntryResults {

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
     * Extracts success response and troubleshooting support data on rejection
     * 
     * @param HandledResponse $handledResponse
     * @return HandledResponse
     */
    public function extractResults(HandledResponse $handledResponse): HandledResponse {
        $this->handledResponse = $handledResponse;

        $this->body = json_decode($this->handledResponse->getResponseBody(), true);
        
        $idCheck = $this->extractId();

        if (!$idCheck) {
            $this->extractBodyMessages();
        }   
        
        return $this->handledResponse;
    }

    /**
     * Extract returned Id
     * 
     * If request is accepted, response includes Id of newly created entry 
     * @return bool True fi Id extracted, false if not extracted
     */
     protected function extractId():bool {

         $idCheck = false;
        if (isset($this->body[ 'id' ])) {

            $id = $this->body[ 'id' ];

            $records = [
                $id => 'added'
            ];

            $this->handledResponse->setRecords($records);
            $this->handledResponse->setRecordCount(1);
            $idCheck = true;
        }
        
        return $idCheck;
    }
    
    /**
     * Extract body messages, if present, into error messages array
     */
    protected function extractBodyMessages() {

            $errors =[];
            
            $this->handledResponse->setIsApiError(TRUE);
            $this->handledResponse->setIsSuccessful(FALSE);

            if (isset($this->body[ 'message' ])) {
                $errors =array_merge($errors, $this->decodeMessage($this->body[ 'message' ]));
            }
            
            if (isset($this->body[ 'context' ][ 'properties' ])) {
                if (is_array($this->body[ 'context' ][ 'properties' ])) {

                    $errors[] = implode(', ', $this->body[ 'context' ][ 'properties' ]);
                } else {
                    $errors[] = $this->body[ 'context' ][ 'properties' ];
                }
            }

            $this->handledResponse->setErrorMessages($errors);
    }

    /**
     * Check for/extract for encoded troubleshooting data within message
     * 
     * @param string $message
     * @return string
     */
    protected function decodeMessage(string $message) {

        $errors = [];

        // Look for embedded JSON
        $errorString = strstr($message, '[', true);

        if (0 < strlen($errorString)) {
            // Embedded JSON found
            $errors[] = trim($errorString);
            $nextLevel = ltrim($message, $errorString);

            $decoded = json_decode($nextLevel, true);

            foreach ($decoded as $error) {
                $programmaticError = [];
                if (isset($error[ 'error' ])) {
                    $programmaticError[] = $error[ 'error' ];
                }

                if (isset($error[ 'name' ])) {
                    $programmaticError[] = $error[ 'name' ];
                }

                if (!empty($programmaticError)) {

                    $errors[] = implode(' - ', $programmaticError);
                }

                if (isset($error[ 'message' ])) {
                    $errors[] = $error[ 'message' ];
                }
            }
        }else{
            // No embedded JSON found
            $errors[]=$message;
        }
        return $errors;
    }

}
