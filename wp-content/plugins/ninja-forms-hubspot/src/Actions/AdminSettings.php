<?php

namespace NFHubspot\Actions;

// Integrating Plugin
use NFHubspot\Contracts\NinjaFormsHubspotContract;

/**
 * Description of AdminSettings
 *
 */
class AdminSettings {

    /**
     *
     * @var NinjaFormsHubspotContract 
     */
    protected $mainInstance;

    public function __construct(NinjaFormsHubspotContract $mainInstance) {

        $this->mainInstance = $mainInstance;

        add_action('wp_ajax_nf_hubspot_admin_settings', array( $this, 'adminAjax' ));
    }

    /**
     * Handle AdminAJAX requests
     */
    public function adminAjax() {

        $case = \filter_input(INPUT_POST, 'nfHubspotTrigger');

        $return = [];
        switch ($case) {
            case 'updateCustomFields':
                $return[ 'value' ] = $this->updateCustomFields();
                $return[ 'source' ] = 'updateCustomFields';
                break;
            case 'saveApiKeyonChange':
                $return[ 'value' ] = $this->saveApiKeyOnChange();
                $return[ 'source' ] = 'nfHubspotSaveApiKeyonChange';
                break;
            default:
                break;
        }

        echo json_encode($return);
        die();
    }

    /**
     * Request custom field update, returning results for feedback
     * 
     * @return string
     */
    protected function updateCustomFields(): string {

        $customFields = $this->mainInstance->updateCustomFields();
        $value = implode(' , ', array_keys($customFields->toArray()));
        if (0 === strlen($value)) {
            $value = __('Custom fields requested; no custom fields returned', 'ninja-forms-hubspot');
        }
        return $value;
    }

    /**
     * Update Ninja Forms Api Key setting
     * @return string
     */
    protected function saveApiKeyOnChange(): string {
        $valueIn = filter_input(INPUT_POST, 'nfHubspotApiKey');

        Ninja_Forms()->update_setting('hubspotApiKey', $valueIn);
        return "nfHubspotSaveApiKeyonChange value in is $valueIn";
    }

}
