<?php
/**
 * Plugin Name: Ninja Forms - Hubspot Integration
 * Description: Integrate Ninja Forms with your Hubspot account
 * 
 * Author: Ninja Forms
 * Author URI: https://ninjaforms.com
 * 
 * Version: 3.0.1
 * 
 * Text Domain: ninja-forms-hubspot
 * Domain Path: /lang/
 * License: GPLv2
 */
/** IMPORTANT: This file MUST be PHP 5.2 compatible */
add_action('plugins_loaded', 'nf_hubspot_init', 0);

/**
 * License this plugin
 * 
 * Update version variable only;
 */
add_action('admin_init', function() {
    // Update with each release
    $version = '3.0.1';
    
    if (class_exists('NF_Extension_Updater')) {

        new \NF_Extension_Updater('Hubspot', $version, 'Ninja Forms', __FILE__, 'nf-hubspot');
    }
});

/**
 * Load plugin if possible
 *
 * @since 3.0.0
 */
function nf_hubspot_init() {
    // Load deprecated version is NF < 3.0
    if (version_compare(get_option('ninja_forms_version', '0.0.0'), '3', '<') || get_option('ninja_forms_load_deprecated', FALSE)) {

        return;
    }

    if (version_compare(PHP_VERSION, '7.1.0', '>=')) {
        if (class_exists('Ninja_Forms')) {
            include_once __DIR__ . '/bootstrap.php';
        } else {
            //Ninja Forms is not active
        }
    } else {
        add_action('admin_notices', 'nf_hubspot_php_nag');
    }
}

/**
 * Callback for admin notice shown when PHP version is not correct.
 *
 * @since 3.0.0
 */
function nf_hubspot_php_nag() {
    ?>
    <div class="notice notice-error">
        <p>
    <?php
    echo esc_html__(
            'Your version of PHP is incompatible with Ninja Forms Hubspot and can not be used.',
            'ninja-forms-hubspot'
    );
    printf(
            ' <a href="https://wordpress.org/php" target="__blank">%s</a>',
            esc_html__('Learn More', 'ninja-forms-hubspot')
    )
    ?>
        </p>
    </div>
    <?php
}
