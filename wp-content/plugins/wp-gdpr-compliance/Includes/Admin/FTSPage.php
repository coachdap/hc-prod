<?php


namespace WPGDPRC\Includes\Admin;

use WPGDPRC\Includes\Consent;
use WPGDPRC\Includes\Helper;
use WPGDPRC\Includes\Page;
use WPGDPRC\WPGDPRC;

/**
 * Class Comment
 * @package WPGDPRC\Includes\Admin
 */
class FTSPage
{

    /**
     * Admin page identifier.
     *
     * @var string
     */
    const PAGE_IDENTIFIER = 'wp_gdpr_c_fts';

    /**
     * Completion status option.
     *
     * @var string
     */
    const WIZARD_COMPLETION_OPTION = 'wp_gdpr_c_fts_finished';

    /**
     * The id given to the notice
     *
     * @var string
     */
    const FTS_NOTICE_MESSAGE = 'wp_gdpr_c_notice_message';

    /**
     * consent save ajax action
     */
    const CONSENT_SAVE = 'wp_gdpr_save_consent';

    /**
     * Settings save ajax action.
     */
    const SETTINGS_SAVE = 'wp_gdpr_save_settings';

    /**
     * Get fts completion status
     *
     * @return false|mixed|void
     */
    public static function getFTSWasCompleted() {
        return get_option(self::WIZARD_COMPLETION_OPTION, false);
    }

    /**
     * set FTS completion status
     *
     * @param bool $status
     */
    public static function setFTSWasCompleted(bool $status = true) {
        update_option(self::WIZARD_COMPLETION_OPTION, $status);
    }

    /**
     * Add hooks when on the right page and/or the current user can manage options.
     */
    public function __construct()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        // set the global screen var to stop some notices from popping up in helper/util functions
        require_once ABSPATH . 'wp-admin/includes/class-wp-screen.php';

        if (!$this->checkFtsIsDone() && $this->shouldShowFts()) {

            add_action('wp_ajax_' . self::FTS_NOTICE_MESSAGE, [$this, 'FTSWasDismissed']);
            add_action('wp_ajax_' . self::CONSENT_SAVE, [$this, 'SaveConsent']);
            add_action('wp_ajax_' . self::SETTINGS_SAVE, [$this, 'SaveSettings']);
            add_action('admin_notices', [$this, 'ftsNotice']);
        }

        if (!$this->isFts() || ! $this->shouldShowFts()) {
            return;
        }

        // Register the page for the fts.
        add_action('admin_menu', [$this, 'addFtsPage']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAssets']);
        add_action('admin_init', [$this, 'renderFtsPage']);
    }

    /**
     * Registers fts
     */
    public function addFtsPage()
    {
        add_submenu_page(str_replace('-', '_', WP_GDPR_C_SLUG), '','', 'manage_options', self::PAGE_IDENTIFIER, array($this, 'renderFtsPage'));
    }

    /**
     * Show fts. Exit to stop the wp dashboard from f*ck!ng everything up.
     */
    public function renderFtsPage()
    {
        $this->showFts();
        exit;
    }

    /**
     * Enqueues the assets needed for the wizard.
     */
    public function enqueueAssets()
    {
        wp_enqueue_media();

        // default form styling. To be overwritten lator
        wp_enqueue_style('forms');

        $ftsHandel = 'wpgdprc.admin.fts.js';
        wp_enqueue_style('wpgdprc.admin.fts.css', WP_GDPR_C_URI_CSS . '/fts.min.css', array(), filemtime(WP_GDPR_C_DIR_CSS . '/fts.min.css'));
        wp_enqueue_script($ftsHandel, WP_GDPR_C_URI_JS . '/fts.min.js', array(), filemtime(WP_GDPR_C_DIR_JS . '/fts.min.js'));
        WPGDPRC::registerSharedAssets($ftsHandel);

        wp_enqueue_style('wpgdprc.admin.codemirror.css');
        wp_enqueue_script('wpgdprc.admin.codemirror.js');
        wp_enqueue_script('wpgdprc.admin.codemirror.additional.js');
    }

    /**
     * Setup Wizard Header.
     */
    public function showFts()
    {
        $this->enqueueAssets();
        $dashboard_url = self::getMainDashboardUrlAndSkipFts();
        ?>
            <!DOCTYPE html>
            <!--[if IE 9]>
            <html class="ie9" <?php language_attributes(); ?> >
            <![endif]-->
            <!--[if !(IE 9) ]><!-->
            <html <?php language_attributes(); ?>>
            <!--<![endif]-->
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1"/>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <title><?= __("First time setup wizard | WP GDPR Compliance", WP_GDPR_C_SLUG); ?></title>
                <!-- Stop the flash of un styled content by hiding the body until the main style is loaded in (which also shows the body again) -->
                <style>body{opacity: 0; visibility: hidden; background: #F1F1F1; transition: opacity 1s ease-in;}</style>
                <?php wp_print_head_scripts(); ?>
            </head>
            <body class="wp-admin wp-core-ui wpgdprc">
                <div class="container" id="wp-gdpr-fts">
                    <div class="row">
                        <div class="col-12 col-md-3 min-width">

                            <img class="logo" height="81" width="208" loading="lazy" src="<?= WP_GDPR_C_URI_SVG ?>/v2-logo-payoff.svg" alt="WP GDPR Logo and payoff">

                            <div class="d-flex flex-column" id="step-to-buttons">
                            </div>

                        </div>
                        <div class="col-12 col-md-8">
                            <div id="step-container">
                                <?php $this->renderSetupSteps(); ?>
                                <div class="step-container__footer d-flex justify-content-between">

                                    <button class="btn px-0" data-step="prev">
                                        <span class="dashicons dashicons-arrow-left-alt"></span>
                                        <?= __('Previous step', WP_GDPR_C_SLUG) ?>
                                    </button>
                                    <button class="btn btn-primary" data-step="next">
                                        <span class="me-2 spinner-wrapper d-none">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        </span>
                                        <?= __('Next step', WP_GDPR_C_SLUG) ?>
                                    </button>
                                    <a data-step="done" href="<?= self::getMainDashboardUrlAndSkipFts('finished') ?>" class="btn btn-primary d-none" disabled="">
                                        <?= __('Finish wizard', WP_GDPR_C_SLUG) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <footer class="col">
                            <a class="btn d-inline px-0" href="<?php echo esc_url($dashboard_url); ?>">
                                <?= __('I want to do this later', WP_GDPR_C_SLUG); ?>
                            </a>
                        </footer>
                    </div>
                </div>
                <?php
                    wp_print_media_templates();
                    wp_print_footer_scripts();
                ?>
            </body>
            </html>
        <?php
    }

    /**
     * Render the setup steps
     */
    public function renderSetupSteps() {
        $pluginData = Helper::getPluginData();
        ?>
            <div data-title="<?= __("Welcome", WP_GDPR_C_SLUG); ?>" class="step">
                <h3><?= __("Welcome to WP GDPR Compliance", WP_GDPR_C_SLUG); ?> <span><?php printf('v%s', $pluginData['Version']); ?></span></h3>
                <p><?= __("Thank you very much for choosing this plugin to help you with your GDPR Compliance. In this wizard we help you to setup the plugin so you can quickly start with making your website more compliant.", WP_GDPR_C_SLUG); ?></p>

                <div class="text-with-icon">
                    <div class="text-with-icon__icon">
                        <img height="48" width="48" loading="lazy" src="<?= WP_GDPR_C_URI_SVG ?>/sparkles.svg" alt="Sparkles">
                    </div>
                    <div class="text-with-icon__text">
                        <h3><?= __("We have some news to share", WP_GDPR_C_SLUG); ?></h3>
                        <p><?= __("We are happy to announce that WP GDPR Compliance has been acquired by the leading Consent Management Platform, Cookie Information. This will create tremendous benefits for all of the more than 200.000 websites using this plugin.", WP_GDPR_C_SLUG); ?>
                            <br><br> <?= __("You will get free upgrades to this plugin, and we will also expand the plugin with features targeted to business users that allow you to easier comply with GDPR. Planned features include cookie scanning, language support for 40+ languages, and much more. If you want to get a taste of what you can expect, you can try the full suite of Cookie Information for 30 days free and without a credit card.", WP_GDPR_C_SLUG); ?></p>
                        <strong>
                            <a target="_blank" href="https://cookieinformation.com/wpgdpr-premium-cookie-banner/?utm_campaign=van-ons-go-premium&utm_source=van-ons-wp&utm_medium=referral"><?= __("Try Cookie Information", WP_GDPR_C_SLUG); ?></a>
                        </strong>
                    </div>
                </div>
            </div>

            <?php
                $consents = new Consent();
                if ($consents->getTotal() < 1):
            ?>
                <div data-title="<?= __("Setup first consent", WP_GDPR_C_SLUG); ?>" class="step">
                    <h3><?= __("Setup your first consent", WP_GDPR_C_SLUG); ?></h3>
                    <p><?= __("Most websites use services and plugins for statistical and marketing that require the user's consent to comply with GDPR. Here you can add the first of the services you use. You can always change this later.", WP_GDPR_C_SLUG); ?></p>
                    <div class="step__form-wrapper" data-action="<?= self::CONSENT_SAVE ?>">
                        <?php
                            $id = (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;
                            Page::renderManageConsentPage($id)
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <div data-title="<?= __("Privacy policy", WP_GDPR_C_SLUG); ?>" class="step">
                <h3><?= __("Privacy policy", WP_GDPR_C_SLUG); ?></h3>
                <p><?= __("You are required to have a privacy policy on your website to comply with GDPR guidelines. Here you can add a link from your consent bar to your privacy policy.", WP_GDPR_C_SLUG); ?></p>

                <div class="step__form-wrapper" data-action="<?= self::SETTINGS_SAVE ?>">
                    <?php
                        Page::renderSettingsPage(true);
                    ?>
                </div>
            </div>

            <div data-title="<?= __("Done", WP_GDPR_C_SLUG); ?>" class="step">
                <h2><?= __("Thats it!", WP_GDPR_C_SLUG); ?></h2>
                <p><?= __("Thats it, we’re done. We just setup your site and now you are more complient already. Next steps are to check if all your consents are setup and check your pages.", WP_GDPR_C_SLUG); ?></p>
                <ul class="list-unstyled m-0">
                    <?php $adminUrl = Helper::getPluginAdminUrl(); ?>
                    <li class="mb-3">
                        <a href="<?= self::getMainDashboardUrlAndSkipFts('finished',  "$adminUrl&type=consents") ?>"><?= __("Add a new consent", WP_GDPR_C_SLUG); ?></a>
                    </li>
                    <li class="mb-3">
                        <a href="<?= self::getMainDashboardUrlAndSkipFts('finished',  "$adminUrl&type=settings") ?>#consents"><?= __("Style your consent bar", WP_GDPR_C_SLUG); ?></a>
                    </li>
                    <li>
                        <a href="<?= self::getMainDashboardUrlAndSkipFts('finished',  "$adminUrl&type=settings") ?>#privacy-policy"><?= __("Manage your Privacy Policy page", WP_GDPR_C_SLUG); ?></a>
                    </li>
                </ul>
            </div>
        <?php
    }

    /**
     * Is the current page the FTS?
     *
     * @return bool
     */
    protected function isFts(): bool
    {
        return (filter_input(INPUT_GET, 'page') === self::PAGE_IDENTIFIER);
    }

    /**
     * Get the FTS url.
     *
     * @return string
     */
    public static function getFtsUrl($restart = false): string
    {
        $url = admin_url('/admin.php?page=' . self::PAGE_IDENTIFIER);

        if ($restart) {
           $url .= '&' . self::PAGE_IDENTIFIER . '=restart';
        }

        return $url;
    }

    /**
     * Get the main dashboard url and skip the FTS
     *
     * @return string
     */
    public static function getMainDashboardUrlAndSkipFts($reason = 'skipped', $url = false) {
        if ($url === false)
            $url = Page::getAdminPageUrl();

        $parsedUrl = parse_url($url);
        if ($parsedUrl['path'] == null) {
            $url .= '/';
        }
        $separator = ($parsedUrl['query'] == NULL) ? '?' : '&';
        $url .= $separator . self::PAGE_IDENTIFIER . "=" . sanitize_title($reason);

        return $url;
    }

    /**
     * Render the notice to start the FTS
     */
    public function ftsNotice()
    {
        ?>
            <div id="<?= self::FTS_NOTICE_MESSAGE ?>" class="notice notice-success is-dismissible wpgdprc-message new wpgdprc-message--welcome">
                <div class="wpgdprc-message__container">
                    <div class="wpgdprc-message__content">
                        <h3 class="wpgdprc-message__title h3"><?= __('WP GDPR Compliance will become even better!', WP_GDPR_C_SLUG); ?></h3>
                        <p class="wpgdprc-message__text">
                            <?= __("We have decided to significantly extend the features of this plugin to protect our community against the increasing pressure from Data Protection Authorities making GDPR audits and giving hefty fines for non-compliant implementations of consent solutions. Over the following months, we will provide a series of free upgrades to this plugin and even start offering premium features targeted to business users. Planned features include cookie scanning, language support for 40+ languages, and much more. To enable this, we are happy to announce that WP GDPR Compliance has been acquired by the leading Consent Management Platform, ", WP_GDPR_C_SLUG) ?>
                            <a target="_blank" href="https://cookieinformation.com/?utm_campaign=van-ons-go-premium&utm_source=van-ons-wp&utm_medium=referral"> <?= __("Cookie Information", WP_GDPR_C_SLUG) ?></a><?= __(", who will lead the future development of the plug-in. If you want to get a taste of what you can expect, ", WP_GDPR_C_SLUG); ?>
                            <a target="_blank" href="https://cookieinformation.com/wpgdpr-premium-cookie-banner/?utm_campaign=van-ons-go-premium&utm_source=van-ons-wp&utm_medium=referral"><?=__("you can try the full suite of Cookie Information for 30 days free and without a credit card.", WP_GDPR_C_SLUG)?></a>
                        </p>
                        <p>
                            <?= __('It appears you have not yet completed the first time setup.', WP_GDPR_C_SLUG) ?>
                        </p>
                        <a href="<?= self::getFtsUrl() ?>" class="button"><?= __("Let's get you all set up!", WP_GDPR_C_SLUG) ?></a>

                    </div>
                    <div class="wpgdprc-message__icon">
                        <img height="96" width="96" loading="lazy" src="<?= WP_GDPR_C_URI_SVG ?>/icon-wave.svg" alt="Wave (Hello)">
                    </div>
                </div>
            </div>
        <?php
    }

    /**
     * Check if fts was already completed or skipped.
     *
     * @return bool
     */
    public function shouldShowFts(): bool
    {
        return !self::getFTSWasCompleted();
    }

    /**
     * When the FTS notices gets dismissed an ajax call is made to skipt the FTS.
     */
    public function FTSWasDismissed()
    {
        check_ajax_referer('wpgdprc', 'security', true);

        // do anything else we want to do when the fts gets skipped via the notice.
        self::setFTSWasCompleted();
    }

    /**
     * Save the first consent via a rest call instead of page reload.
     */
    public function SaveConsent() {
        check_ajax_referer('wpgdprc', 'security', true);

        $id = (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;

        ob_start();
        Page::renderManageConsentPage($id);
        $response = $this->generateResponse(ob_get_clean());

        $this->returnResponse($response);
    }

    /**
     * Save the privacy policy settings via a rest call instead of page reload.
     */
    public function SaveSettings() {
        check_ajax_referer('wpgdprc', 'security', true);

        $ppps = Page::getPrivacyPolacyPageSettings();
        foreach ($ppps as $setting) {
            if ( isset( $_REQUEST[ $setting ] ) ) {
                $value = $_REQUEST[ $setting ];
                if ( ! is_array( $value ) ) {
                    $value = trim( $value );
                }
                $value = wp_unslash( $value );
            }
            update_option( $setting, $value ?? null );
        }

        ob_start();
        Page::renderSettingsPage(true);
        $response = $this->generateResponse(ob_get_clean());

        $this->returnResponse($response);
    }

    /**
     * Generate the default response structure
     *
     * @param $content
     * @return object
     */
    public function generateResponse($content) {
        return (object) [
            'content' => $content,
            'success' => true,
        ];
    }

    /**
     * Set the correct headers, return the response and DIE!
     *
     * @param array $response
     * @param int $code
     */
    public function returnResponse( $response = [], $code = 200 ) {
        header( 'Content-type: application/json' );
        echo json_encode( $response );
        wp_die( '', $code );
    }

    /**
     * Check if the setup has been completed of been skipped with a query param.
     */
    public function checkFtsIsDone() {
        if (filter_input(INPUT_GET, 'page') === WP_GDPR_C_SLUG)
            return false;

        if (empty($ftsStatus = filter_input(INPUT_GET, self::PAGE_IDENTIFIER)))
            return false;

        if (!in_array($ftsStatus, ['skipped', 'finished', 'restart']))
            return false;

        self::setFTSWasCompleted($ftsStatus !== 'restart');

        return true;
    }
}
