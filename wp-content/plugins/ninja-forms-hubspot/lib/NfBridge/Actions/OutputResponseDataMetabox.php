<?php
namespace NFHubspot\EmailCRM\NfBridge\Actions;

// Shared
use NFHubspot\EmailCRM\Shared\Entities\HandledResponse;

final class OutputResponseDataMetabox extends \NF_Abstracts_SubmissionMetabox
{

    /**
     * HTML markup to output Response Data
     * @var string
     */
    protected $markup = '';

    /**
     * Key under which response data is stored in NinjaForms process() $data
     * 
     * @var string
     */
    protected $extraValueKey;

    /**
     *
     * @var NF_ConstantContact_Admin_MarkupResponseDataMetabox 
     */
    protected $markupResponseDataMetabox;

    /**
     * Collection of HandledResponse entities
     * @var HandledResponse[]
     */
    protected $handledResponseCollection = [];

    /**
     * 
     * @param string $extraValueKey
     * @param string $label
     * @param mixed $markupResponseDataMetabox
     */
    public function __construct( 
            string $extraValueKey = '', 
            string $label = '', 
            ?MarkupResponseDataMetabox $markupResponseDataMetabox=null) {
        parent::__construct();

        $this->extraValueKey = $extraValueKey;

        $this->_title = $label;


        if (is_null($markupResponseDataMetabox)) {
            $this->markupResponseDataMetabox = new MarkupResponseDataMetabox();
        } else {
            $this->markupResponseDataMetabox = $markupResponseDataMetabox;
        }
    }

    /**
     * Ninja Forms method that outputs metabox
     * 
     * @param mixed $post
     * @param mixed $metabox
     */
    public function render_metabox($post, $metabox) {
        
        if (!$this->sub->get_extra_value($this->extraValueKey)) {

            $this->addNoResponseDataMarkup();
        } else {
            $this->markup = '';
            $this->extractResponseData();

            foreach ($this->handledResponseCollection as $handledResponse) {
                $this->markup .= $this->markupResponseDataMetabox->markupHandledResponse($handledResponse);
            }
        }
        echo $this->markup;
    }


    /**
     * Construct collection of ResponseData entities
     */
    protected function extractResponseData() {
        $submissionDataHandledResponse = $this->sub->get_extra_value($this->extraValueKey);

        if (isset($submissionDataHandledResponse['responseData']) &&
                is_array($submissionDataHandledResponse['responseData']) && !empty($submissionDataHandledResponse['responseData'])) {
            foreach ($submissionDataHandledResponse['responseData'] as $handledResponse) {
                $this->handledResponseCollection[] = $handledResponse;
            }
        }
    }

    /**
     * Add markup for no response data available
     */
    protected function addNoResponseDataMarkup() {
        $markup = "<dl>"
                . "<dd><strong>".__('No response data available for this submission','ninja-forms-hubspot')."</strong></dd>"
                . "</dl>";

        $this->markup .= $markup;
    }

}
