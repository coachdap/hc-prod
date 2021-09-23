<?php

namespace NFHubspot\EmailCRM\Hubspot\Sdk;

// Shared
use NFHubspot\EmailCRM\Shared\Entities\FormField;
use NFHubspot\EmailCRM\Shared\Entities\FormFields;

/**
 * Converts API-structured response body into standardized FormFields
 */
class ConvertFieldPropertiesIntoFormFields {

    /**
     * JSON Response body Custom Fields GET request
     * 
     * @var string
     */
    protected $responseBody;

    /**
     *
     * @var string
     */
    protected $module;

    /**
     * FormFields collection
     * 
     * @var FormFields
     */
    protected $apiFormFields;

    /**
     * Raw custom fields array from request
     * 
     * @var array
     */
    protected $customFieldsArray = [];

    /**
     * Converts API-structured response body into standardized FormFields
     * 
     * 
     * @param string $responseBody
     * @param string|null $module
     * @return type
     */
    public function handle(string $responseBody, ?string $module)/* : FormFields */ {


        $this->responseBody = $responseBody;

        if (!is_null($module)) {
            $this->module = $module;
        }
        $this->apiFormFields = new FormFields();

        $this->extractCustomFieldArray();

        $this->extractFields();

        return $this->apiFormFields;
    }

    /**
     * Extract field collection into into field definition keyed on field id
     * 
     * @param string $module
     * @param array $fieldsCollection
     */
    protected function extractFields() {

        foreach ($this->customFieldsArray as $fieldDefinitionArray) {
            // Value must be set and must be false to add field
            if (isset($fieldDefinitionArray['modificationMetadata']['readOnlyValue']) &&
                    $fieldDefinitionArray['modificationMetadata']['readOnlyValue'] === false &&
                    $fieldDefinitionArray['hidden'] == false) {
                $this->extractFieldDefinitions($fieldDefinitionArray);
            }
        }
    }

    /**
     * Extract field definition into a FormField structure
     * 
     * @param string $module
     * @param string $key
     * @param array $fieldDefinitionArray
     */
    protected function extractFieldDefinitions($fieldDefinitionArray) {
        $fieldType = $this->getFieldType($fieldDefinitionArray);

        $id = $fieldDefinitionArray['name'];
        if (isset($this->module)) {
            $id .= '_-_' . $this->module;
        }

        $definitions = [
            "id" => $id,
            "required" => false,
            "label" => $fieldDefinitionArray['label'],
            "type" => $fieldType
        ];

        if (isset($fieldDefinitionArray['options'])) {
            $definitions['options'] = $fieldDefinitionArray['options'];
        }
        $this->appendApiFormField($definitions);
    }

    /**
     * Append field definition array into FormFields collection
     * 
     * @param array $definitions
     */
    protected function appendApiFormField($definitions) {

        $apiField = FormField::fromArray($definitions);

        $this->apiFormFields->addFormField($apiField);
    }

    /**
     * Determine FormField type from FieldType code
     * 
     * Lookup values provided only in API specifications; requires manual method
     * to convert into known FormField types
     * 
     * @param array $fieldDefinitionArray
     * @return string
     */
    protected function getFieldType($fieldDefinitionArray): string {

        switch ($fieldDefinitionArray['fieldType']) {
            case 'number':
                $fieldType = 'number';
                break;
            case 'booleancheckbox':
                $fieldType = 'checkbox';
                break;
            case 'select':
                $fieldType = 'listselect';
                if (!isset($fieldDefinitionArray['options'])) {
                    $fieldType = 'textbox';
                }
                break;
            case 'checkbox':
                $fieldType = 'listmultiselect';
                if (!isset($fieldDefinitionArray['options'])) {
                    $fieldType = 'textbox';
                }
                break;
            case 'date':
                $fieldType = 'date';
                break;
            case 'textarea':
                $fieldType = 'textarea';
                break;
            case 'radio':
                $fieldType = 'listradio';
                if (!isset($fieldDefinitionArray['options'])) {
                    $fieldType = 'textbox';
                }
                break;
            case 'phonenumber':
            case 'text':
            default:
                $fieldType = 'textbox';
                break;
        }

        return $fieldType;
    }

    /**
     * Extract custom field array from known location inside API response body
     */
    protected function extractCustomFieldArray() {

        $array = json_decode($this->responseBody, true);

        if (isset($array['results'])) {
            $this->customFieldsArray = $array['results'];
        }
    }

}
