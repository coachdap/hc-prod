<?php
/**
 * Add scripts, styles and icons
*/
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_enqueue_scripts', 'abcfrggcl_script_enq_css_grid', 21 );

function abcfrggcl_script_enq_css_grid() {

    $customURL = '';
    $uploadDir = wp_upload_dir();
    $custom = 'abcfolio/rggcl.css';
    $baseDir = $uploadDir['basedir'];
    $baseURL = $uploadDir['baseurl'];
    $customFile = trailingslashit( $baseDir ) . $custom;

    if ( file_exists( $customFile ) ) {
         $customURL = trailingslashit( $baseURL ) . $custom;
    }

    $obj = ABCFRGGCL_Main();
    $ver = $obj->pluginVersion;

    wp_register_style('abcf-rggcl', ABCFRGGCL_PLUGIN_URL . 'css/rggcl.css', array(), $ver, 'all');
    wp_enqueue_style('abcf-rggcl');

    if(!empty($customURL)){
        wp_register_style('abcf-rggcl-custom', $customURL, array(), $ver, 'all');
        wp_enqueue_style( 'abcf-rggcl-custom');
    }
}
