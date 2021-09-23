<?php

namespace NFHubspot\EmailCRM\Hubspot\Handlers;

// API Module
use NFHubspot\EmailCRM\Hubspot\Hubspot;
// Shared
use NFHubspot\EmailCRM\Shared\Entities\FormFields;
use NFHubspot\EmailCRM\Shared\Contracts\FormActionHandler;
use NFHubspot\EmailCRM\Shared\Contracts\FormContract;
use NFHubspot\EmailCRM\Shared\Contracts\SubmissionDataContract;
use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;
/**
 * Handle a submitted form's action request to create records in the API account
 * 
 * This class is activated for the form action handling process.  It is 
 * instantiated with the standard fields; shortly after, the custom fields
 * are set by the instantiating plugin.  When the form is submitted, the
 * SubmissionData provides the form submission data and this class can
 * match up submission data with the ApiFormFields to make the requests.
 *
 */
class CreateRecordsFormActionHandler implements FormActionHandler {

    /**
     *
     * @var Hubspot
     */
    protected $apiModule;

    /**
     *
     * @var SubmissionDataContract
     */
    protected $submissionData;

    /**
     *
     * @var FormContract
     */
    protected $form;

    /**
     * Standard (non-custom) fields in the API
     * 
     * Defined using shared structure ApiFormFields, these are fields that are
     * standard in any user's account.  Thus it can be coded and configured
     * within the ApiModule
     * 
     * @var FormFields
     */
    protected $standardApiFormFields;

    /**
     * Custom fields from the API
     * 
     * The integrating plugin is responsible for requesting to retrieve and to
     * store these fields.  The top level API Module makes requests for these
     * fields' definitions and also to create records with these.
     * 
     * @var FormFields
     */
    protected $customApiFormFields;

    /**
     *
     * @var array
     */
    protected $unsortedRequest = [];

    /**
     *
     * @var string
     */
    protected $accessToken = '';

    /**
     *
     * @var string
     */
    protected $subdomain = '';

    /**
     * Indexed array of HandledResponses
     * @var HandledResponse[]
     */
    protected $handledResponseCollection;
    /**
     * Instantiate with top level API Module
     * @param Hubspot $apiModule
     */
    public function __construct(Hubspot $apiModule) {

        $this->apiModule = $apiModule;

        $this->setStandardApiFormFields();
    }

    /**
     * Make requests to CreateRecords based on SubmissionData instructions
     * 
     * @param SubmissionDataContract $submissionData
     * @param FormContract $form
     */
    public function handle(SubmissionDataContract $submissionData, FormContract $form): array {

        $this->submissionData = $submissionData;

        $this->preHandle();
        
        $this->extractStandardFields();
        $this->extractCustomFields();

        $this->extractGlobalSettings();

        $sdk = $this->apiModule->sdk();

        $this->handledResponseCollection = $sdk->createEntry($this->unsortedRequest);

        $this->postHandle();
        
        return [];
    }

    /**
     * Perform platform specific pre-handling required 
     * 
     * This method provides access to the properties during the handling process
     * such that NF or CF child classes can adjust values as required.
     * @return void
     */
    protected function preHandle() {

        return;
    }

    /**
     * Perform platform specific post-handling required 
     * 
     * This method provides access to the properties during the handling process
     * such that NF or CF child classes can adjust values as required.
     * @return void
     */
    protected function postHandle() {

        return;
    }

    /**
     * Extract required Global Settings from SubmissionData
     * 
     * Hubspot does not refresh the API Key so the initial value stored in the
     * SDK at initialization suffices.  Hubspot does offer an OAuth integration,
     * which we may at some point need to implement.  With this standard method
     * already implemented, we know that we have a method of retrieving dynamic
     * settings from the submission, which OAuth (and possibly other API
     * implementations) require
     */
    protected function extractGlobalSettings() {
        $this->accessToken = $this->submissionData->getValue('hubspotApiKey', '');
    }

    /**
     * Extract standard fields from SubmissionData
     */
    protected function extractStandardFields() {
        // All fields handled through custom
    }

    /**
     * Extract custom fields from SubmissionData
     */
    protected function extractCustomFields() {
        foreach (array_keys($this->customApiFormFields->getFields()) as $key) {

            if (''!==$this->submissionData->getValue($key, '') ) {
                $rawValue = $this->submissionData->getValue($key);
                
                $fieldType = $this->customApiFormFields->getField($key)->getType();
                
                $validatedValue = $this->validateValueByFieldType($rawValue, $fieldType);
                
                $instructions = explode('_-_', $key);

                $this->unsortedRequest[$instructions[1]][ $instructions[0]] = $validatedValue;
                  
            }
        }
    }

    protected function validateValueByFieldType( $rawValue,  string $fieldType) {
        
        switch($fieldType){
            case 'listmultiselect':
                $validatedValue = implode(';', explode(',',$rawValue));
                break;
            case 'checkbox':
                
                if(in_array(strtolower($rawValue), ['checked','1',1,true])){
                    $validatedValue = TRUE;
                }else{
                    $validatedValue = FALSE;
                }
                $validatedValue='FailThis';
                break;
            default:
                $validatedValue = $rawValue;
        }
        
        return $validatedValue;
    }
    
    
    
    /**
     * Get the standard ApiFormFields, configured by top level API Module
     * 
     */
    protected function setStandardApiFormFields() {
        $this->standardApiFormFields = $this->apiModule
                ->getFormFields();
    }

    /**
     * Set the custom FormFields
     * 
     * @param FormFields $customApiFormFields
     * @return FormActionHandler
     */
    public function setCustomApiFormFields(FormFields $customApiFormFields): FormActionHandler {
        $this->customApiFormFields = $customApiFormFields;
        return $this;
    }

}
