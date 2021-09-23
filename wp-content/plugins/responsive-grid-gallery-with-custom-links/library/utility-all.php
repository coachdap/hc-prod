<?php
/**
 * Utility functions.
 * Version 1.3.0
*/

//===  MESSAGES  =========================================================
if ( !function_exists( 'abcfl_util_div_err_msg' ) ){
    function abcfl_util_div_err_msg($msg1, $msg2=''){

        if(!abcfl_html_isblank($msg1)){ $msg1 = '<p>' . $msg1 . '</p>'; }
        if(!abcfl_html_isblank($msg2)){ $msg2 = '<p>' . $msg2 . '</p>'; }

        $msg = $msg1 . $msg2;
        if(abcfl_html_isblank($msg)){ return; }
        echo ('<div class="abcfDivErrMsg">' . $msg . '</div>');
    }
}

if ( !function_exists( 'abcfl_util_msg_ok' ) ){
    function abcfl_util_msg_ok() {
        echo '<div class="wrap"><div id="abcfalOK" class="updated" style="line-height: 250%;">&nbsp; OK &nbsp;</div></div>';
    }
}


if ( !function_exists( 'abcfl_util_msg_info' ) ){
    function abcfl_util_msg_info($txt) { echo '<div class="wrap"><div class="updated fade" id="message"><p>' . $txt . '</p></div></div>' . "\n"; }
}


if ( !function_exists( 'abcfl_util_msg_err' ) ){
    function abcfl_util_msg_err($txt) { echo '<div class="wrap"><div class="error" id="error"><p>' . $txt . '</p></div></div>'; }
}

//==   LICENCE ==================================================================
if ( !function_exists( 'abcfl_util_pg_license' ) ){
function abcfl_util_pg_license($optnName) {
    abcfl_util_permission_check();

    // if check_admin_referer() fails it will print a "Are you sure you want to do this?" page and die.
    if ( isset($_POST['btnAddLicense']) ){
        check_admin_referer( $optnName );
        $licenseKey = (isset( $_POST['licenseKey'] ) ? esc_attr($_POST['licenseKey']) : '');

        abcfl_util_add_licence_key($licenseKey, $optnName);
        abcfl_util_msg_ok();
    }
    $key = abcfl_util_get_licence_key($optnName);

    echo  abcfl_html_tag('div','', 'wrap' );
        echo abcfl_html_tag('h2', '');
        echo 'License';
        echo abcfl_html_tag_end('h2');
    echo abcfl_input_hline( '2', '20', '50Pc' );
    abcfl_html_div_clr();
    echo abcfl_html_form( 'frmLicense', 'frmLicense' );
        wp_nonce_field($optnName);
        echo abcfl_input_txt('licenseKey', '', $key, 'License Key', '', '50%', 'abcflLicenseKey', '', 'abcflFldCntr', 'abcflFldLbl');
        echo  abcfl_html_tag('div','', 'submit' );
        echo abcfl_input_btn( 'btnAddLicense', 'btnAddLicense', 'submit', 'Activate Key', 'button-primary abcficBtnWide' );
    echo abcfl_html_tag_ends('div,form,div');
    echo abcfl_input_hline( '2', '20', '50Pc' );
    echo abcfl_html_tag('p', '');
        echo __( 'The license key is required for automated updates.', 'responsive-grid-gallery-custom-links' );
    echo abcfl_html_tag_end('p');
    echo abcfl_html_tag('p', '');
        echo __( 'Lost your key? No problem. <a href="http://abcfolio.com/quality-wordpress-plugins-contact-us/">Contact us to get your License Key.</a>', 'responsive-grid-gallery-custom-links' );
    echo abcfl_html_tag_ends('p,div');
}
}

if ( !function_exists( 'abcfl_util_add_licence_key' ) ){
function abcfl_util_add_licence_key($key, $optnName){

    $optns = abcfl_util_saved_optns($optnName);
    $key = abcfl_util_fix_key(trim($key));
    $optns['license_key'] = strtoupper($key) ;
    update_option( $optnName, $optns );
    //update_option( 'abcfkap_optns', $optns );
}
}

if ( !function_exists( 'abcfl_util_get_licence_key' ) ){
function abcfl_util_get_licence_key($optnName){

    $optns = abcfl_util_saved_optns($optnName);
    return $optns['license_key'];
}
}

if ( !function_exists( 'abcfl_util_saved_optns' ) ){
function abcfl_util_saved_optns($optnName) {

    $defaults = array( 'license_key' => '' );
    return wp_parse_args(get_option( $optnName, array() ), $defaults );
}
}

if ( !function_exists( 'abcfl_util_fix_key' ) ){
//Remove everything except -, a-z, A-Z and 0-9:
function abcfl_util_fix_key($str) { return preg_replace("/[^a-zA-Z0-9-]+/", "", $str); }
}
//-----------------------------------------------------

if ( !function_exists( 'abcfl_util_permission_check' ) ){
//Check if user is an admin
function abcfl_util_permission_check() {
    if ( !current_user_can('manage_options')){
        echo abcfl_util_msg_err('Error');
        die();
    }
}
}
//==================================================================================
//Returns empty string or custom CSS URL if custom file exists.
if ( !function_exists( 'abcfl_util_custom_css_url' ) ){
function abcfl_util_custom_css_url( $fileName ) {

    if(empty($fileName)){ return ''; }

    $url = '';
    $custom = trailingslashit( 'abcfolio') . $fileName ;
    $uploadDir = wp_upload_dir();
    $fileQPat = trailingslashit( $uploadDir['basedir'] ) . $custom;
    $customFileURL = trailingslashit( $uploadDir['baseurl'] ) . $custom;

    if ( file_exists( $fileQPat )) { $url = $customFileURL; }
    return $url;
}}
