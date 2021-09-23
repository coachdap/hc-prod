<?php
/*
Plugin Name: Ninja Forms for AMP
Plugin URI: https://ampforwp.com/ninja-forms
Description: Ninja forms compatibility for AMP
Version: 1.2.6
Author: Ahmed Kaludi, Mohammed Kaludi
Author URI: https://ampforwp.com/
Donate link: https://www.paypal.me/Kaludi/25usd
License: GPL2+
Text Domain: ninjaformsforamp
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

define('AMPFORWP_NINJA_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('AMPFORWP_NINJA_PLUGIN_DIR_URI', plugin_dir_url(__FILE__));
define('AMP_NINJA_FORMS_VERSION','1.2.6');


// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'AMP_NINJA_FORMS_STORE_URL', 'https://accounts.ampforwp.com/' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of your product. This should match the download name in EDD exactly
define( 'AMP_NINJA_FORMS_ITEM_NAME', 'Ninja Forms for AMP' );

// the download ID. This is the ID of your product in EDD and should match the download ID visible in your Downloads list (see example below)
//define( 'AMPFORWP_ITEM_ID', 2502 );
// the name of the settings page for the license input to be displayed
define( 'AMP_NINJA_FORMS_LICENSE_PAGE', 'ninja-forms' );
if(! defined('AMP_NINJA_ITEM_FOLDER_NAME')){
    $folderName = basename(__DIR__);
    define( 'AMP_NINJA_ITEM_FOLDER_NAME', $folderName );
}

add_action('plugins_loaded','ampforwp_ninja_initiate_plugin');
function ampforwp_ninja_initiate_plugin(){
    global $ninja_forms_processing;
  
    if(!defined('AMPFORWP_AMP__DIR__')){
    if ( class_exists('Ninja_Forms') && defined('AMP__DIR__') ){
        define( 'AMPFORWP_AMP__DIR__', AMP__DIR__);
    }elseif( defined('AMP__VENDOR__DIR__')){
        define( 'AMPFORWP_AMP__DIR__', AMP__VENDOR__DIR__);
    }
  }else{
       // add_action('admin_notices', 'ampforwp_ninja_general_admin_notice');
       return false;
    }
   add_action('wp', 'amp_ninja_start_form', 999);
    require_once AMPFORWP_NINJA_PLUGIN_DIR .'/class-amp-ninja-blacklist.php';
}

add_filter('amp_content_sanitizers','ampforwp_ninja_blacklist_sanitizer', 20);
function ampforwp_ninja_blacklist_sanitizer($data){
    if ( isset($data['AMP_Blacklist_Sanitizer']) && class_exists( 'AMPFORWP_ninja_Blacklist' )) {
        unset($data['AMP_Blacklist_Sanitizer']);
        unset($data['AMPFORWP_Blacklist_Sanitizer']);
        $data[ 'AMPFORWP_ninja_Blacklist' ] = array();
    }

    return $data;
}


//Ninja AMP settings
add_filter("redux/options/redux_builder_amp/sections", 'ampforwp_ninja_forms_settings');
if( ! function_exists('ampforwp_ninja_forms_settings') ){
  function ampforwp_ninja_forms_settings( $sections ){
    $sections[] = array(
          'title'      => __( 'AMP Ninja Forms', 'redux-framework-demo' ),
          'icon' => 'el el-envelope ',
          'id'  => 'ampforwp-ninja-forms-subsection',
          'desc'  => " ",
          'subsection' => false,
            'fields'    => array(
             array(
              'title' => __('ReCAPTCHA', 'accelerated-mobile-pages'),
              'id'  => 'ampforwp-ninja-forms-recaptcha-feature',
              'type'  => 'section',
              'indent'=> true,
              'layout_type' => 'accordion',
              'accordion-open'=> 1,
            ),
            array(
               'id'       => 'ampforwp-ninja-forms-recaptcha',
               'type'     => 'switch',
               'title'    => __(' ReCAPTCHA v3 ', 'accelerated-mobile-pages'),
               'desc'  => __('Enable or disable the Recaptcha v3 feature','accelerated-mobile-pages'),
               'default'  => 0,
            ),  
            array(
                'id'            =>'ampforwp-ninja-forms-recaptcha-site',
                'type'          => 'text',
               'title'         => esc_html__('Site Key','accelerated-mobile-pages'),
               'tooltip-subtitle'  => esc_html__('You can get the site key from here ','accelerated-mobile-pages').'<a target="_blank" href="https://www.google.com/recaptcha/admin/create">'.esc_html__('form here','accelerated-mobile-pages').'</a>',
                'default'       => '',
                'required' => array(
                  array('ampforwp-ninja-forms-recaptcha', '=' , '1')),
            ),  
            array(
                'id'            =>'ampforwp-ninja-forms-recaptcha-secerete',
                'type'          => 'text',
                'title'         => esc_html__('Secret Key','accelerated-mobile-pages'),
                'tooltip-subtitle'  => esc_html__('You can get the Secret Key from here ','accelerated-mobile-pages').'<a target="_blank" href="https://www.google.com/recaptcha/admin/create">'.esc_html__('form here','accelerated-mobile-pages').'</a>',
                'default'       => '',
                'required' => array(
                  array('ampforwp-ninja-forms-recaptcha', '=' , '1')),
            ),),
    );
    return $sections;
  }
}

function amp_ninja_start_form() {
	global $ninja_forms_processing;

	if ( (function_exists( 'ampforwp_is_amp_endpoint' ) && ampforwp_is_amp_endpoint()) ||  (function_exists( 'is_wp_amp' ) && is_wp_amp()) || (function_exists( 'is_amp_endpoint' ) && is_amp_endpoint()) ) {	 
		require AMPFORWP_NINJA_PLUGIN_DIR."ninja-forms-array-data.php";
		require AMPFORWP_NINJA_PLUGIN_DIR."ninja-forms-fields.php";
        add_filter('amp_post_template_data','amp_add_ninja_required_scripts', 21);
		// replace original handler with our
		add_shortcode( 'ninja_forms', 'ampforwp_ninja_forms_shortcode' );
		add_shortcode( 'ninja_form', 'ampforwp_ninja_forms_shortcode' );

	}
}

if(!function_exists('ampforwp_ninja_forms_shortcode')){
	function ampforwp_ninja_forms_shortcode($atts, $content = null, $code = ''){
		
		$form_id 	= (int) $atts['id'];
		$formoptions = amp_get_ninja_formData($form_id);
		// echo "<pre>";
  //       print_r($formoptions);die;

		$content = '';
    $ninja_form_recaptcha_v3 = '';
    global $redux_builder_amp;
    if(isset($redux_builder_amp['ampforwp-ninja-forms-recaptcha']) && $redux_builder_amp['ampforwp-ninja-forms-recaptcha'] == true){
      $ninja_form_sitekey = $redux_builder_amp['ampforwp-ninja-forms-recaptcha-site'];
      $ninja_form_recaptcha_v3 = '<amp-recaptcha-input layout="nodisplay" name="ninja-forms-recaptcha-response" data-sitekey="'.$ninja_form_sitekey.'" data-action="ninja_forms_recaptcha_response"></amp-recaptcha-input>';
    }
		ob_start();
        Ninja_Forms::template( 'display-form-container.html.php', compact( 'form_id' ) );
        $content .= ob_get_contents();
        ob_get_clean();

        //FieldWrapper
        $fieldWrapper = '';
        ob_start();
        Ninja_Forms::template( 'fields-wrap.html', compact( 'form_id' ) );
        $fieldWrapper = ob_get_contents();
        ob_get_clean();

        ob_start();
	    Ninja_Forms::template( 'fields-label.html', compact( 'form_id' ) );
	    $fieldlabel = ob_get_contents();
	    ob_get_clean();

        $wrapper = '';
        foreach($formoptions['fields'] as $key => $field){
            $removeFields = array('recaptcha');
            if(in_array($field['type'], $removeFields)){
                continue;
            }

        	$fieldsHtml = amp_ninja_field_markup($field);
        	$wrapper .= amp_ninja_wrapper_template_cleanup($fieldWrapper, $fieldlabel, $fieldsHtml,$field);
        }
        $content = str_replace('<div class="nf-loading-spinner"></div>', $wrapper, $content);
        $content = str_replace('>Submit', '', $content);
        $submit_url =  admin_url('admin-ajax.php?action=ninja_form_submission');
		$actionXhrUrl = preg_replace('#^https?:#', '', $submit_url);

        $content = wp_nonce_field('ninja_forms_display_nonce','_wpnonce',true,false).$content;
		$content = "<input type='hidden' name='form_detail' value='".$form_id."'> ".$content;
		$content = '<div id="ninja_form_'.$form_id.'" class="form-fields-wrapper">'.$content.'</div>
            '.$ninja_form_recaptcha_v3.'
            <div submit-success>
			<template type="amp-mustache" >
                <div class="ampforwp-form-status amp_success_message">
    			  <b>Success</b>! <strong>{{{data.actions.success_message}}}</strong>
                </div>
			</template>
		</div>
		<div submit-error>
		    <template type="amp-mustache" >
				<div class="ampforwp-form-status amp_error_message">
				{{message}}
				<div class="ampforwp-form-status amp_error_message">
				 {{#errors}} 
				 	<div>{{error_detail}}</div>
				 {{/errors}} 
				</div> 
				</div>
			</template>
		</div>
			';
		$amp_class_append = '';
        if(function_exists('saswp_schema_markup_output')){
        $amp_class_append =  'saswp-review-submission-form';
        }
        $content = '<form class="ninja_wrapper ampforwp-form-allow '.$amp_class_append.'" action-xhr="'.$actionXhrUrl.'" method="post" target="_top">'.$content.'</form>';
		add_action('amp_post_template_css', 'amp_ninja_form_styling');
        return $content;
	}
}

if(!function_exists('amp_ninja_display_no_id')){
	function amp_ninja_display_no_id(){
		$output = __( 'Notice: Ninja Forms shortcode used without specifying a form.', 'ninja-forms' );

        // TODO: Maybe support filterable permissions.
        if( ! current_user_can( 'manage_options' ) ) return "<!-- $output -->";

        // TODO: Log error for support reference.
        // TODO: Maybe display notice if not logged in.
        trigger_error( __( 'Ninja Forms shortcode used without specifying a form.', 'ninja-forms' ) );

        return "<div style='border: 3px solid red; padding: 1em; margin: 1em auto;'>$output</div>";
	}
}


add_action('wp_ajax_ninja_form_submission','ninja_form_submission');
add_action('wp_ajax_nopriv_ninja_form_submission','ninja_form_submission');

function ninja_form_submission(){
	if(!wp_verify_nonce($_POST['_wpnonce'],'ninja_forms_display_nonce')){
		header('HTTP/1.1 500 FORBIDDEN');
	}else{
    require_once AMPFORWP_NINJA_PLUGIN_DIR."submit/recaptcha_amp.php";
		require_once AMPFORWP_NINJA_PLUGIN_DIR."submit/submit_controller.php";
		require_once AMPFORWP_NINJA_PLUGIN_DIR."submit/submission.php";
		require_once AMPFORWP_NINJA_PLUGIN_DIR."submit/handle_submission.php";
	}
	header("access-control-allow-credentials:true");
    header("access-control-allow-headers:Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token");
    header("Access-Control-Allow-Origin:".$_SERVER['HTTP_ORIGIN']);
    $siteUrl = parse_url(
			get_site_url()
		);
    header("AMP-Access-Control-Allow-Source-Origin:".$siteUrl['scheme'] . '://' . $siteUrl['host']);
    header("access-control-expose-headers:AMP-Access-Control-Allow-Source-Origin");
    header("Content-Type:application/json");
     wp_die();
}

function amp_add_ninja_required_scripts($data){
    if ( is_singular() || is_home()) {
        // Adding Form Script
        if ( empty( $data['amp_component_scripts']['amp-form'] ) ) {
            $data['amp_component_scripts']['amp-form'] = 'https://cdn.ampproject.org/v0/amp-form-0.1.js';
        }
        // Adding bind Script
        if ( empty( $data['amp_component_scripts']['amp-bind'] ) ) {
            $data['amp_component_scripts']['amp-bind'] = 'https://cdn.ampproject.org/v0/amp-bind-0.1.js';
        }// Adding Mustache Script
        if ( empty( $data['amp_component_scripts']['amp-mustache'] ) ) {
            $data['amp_component_scripts']['amp-mustache'] = 'https://cdn.ampproject.org/v0/amp-mustache-latest.js';
        }
    }

    return $data;
}


function amp_ninja_form_styling(){
	?>.form-fields-wrapper span {
    display: inline;
}
.form-fields-wrapper form{
    margin-bottom: 40px;
    font-family: sans-serif;
}
.form-fields-wrapper label{font-size:12px;color:#555;letter-spacing:.5px;text-transform:uppercase;line-height:1;}
.form-fields-wrapper .field-wrap{
            margin-bottom: 7px;
}
.form-fields-wrapper input,select{
    padding: 10px 9px;
    border-radius: 2px;
    border: 1px solid #ccc;
    font-size: 14px;
    width: 100%;
}
 .form-fields-wrapper input[type="radio"],input[type="checkbox"]{
 width:auto;
}
.listcheckbox-wrap .nf-field-element ul{
    right:0px;
}
.listradio-wrap .nf-field-element ul{
    right:0px;
}
.hr-wrap .nf-field-label{
    display:none;
}
.ninja-forms-req-symbol {
    color: #e80000;
}
/*Star Rating Css Start*/
.ninja_wrapper .rating {
  --star-size: 2;  /* use CSS variables to calculate dependent dimensions later */
  padding: 0;  /* to prevent flicker when mousing over padding */
  border: none;  /* to prevent flicker when mousing over border */
  unicode-bidi: bidi-override; direction: rtl;  /* for CSS-only style change on hover */
  text-align: left;  /* revert the RTL direction */
  user-select: none;  /* disable mouse/touch selection */
  font-size: 3em;  /* fallback - IE doesn't support CSS variables */
  cursor: pointer;
  -webkit-tap-highlight-color: rgba(0,0,0,0);
  -webkit-tap-highlight-color: transparent;
}

    
.ninja_wrapper .rating > *:hover,
.ninja_wrapper .rating > *:hover ~ label,
.ninja_wrapper .rating:not(:hover) > input:checked ~ label {
  /*color: transparent;*/  /* reveal the contour/white star from the HTML markup */
  cursor: inherit;  /* avoid a cursor transition from arrow/pointer to text selection */
}
.ninja_wrapper .rating > *:hover:before,
.ninja_wrapper .rating > *:hover ~ label:before{
 content: "★";
  position: absolute;
  left: -4px;
  color: orangered;
  
}
.ninja_wrapper .rating:not(:hover) > input:checked ~ label:before {
  content: "★";
  position: absolute;
  left: -4px;
  color: gold;
}
.ninja_wrapper .rating > input {
  position: relative;
  transform: scale(3);  /* make the radio buttons big; they don't inherit font-size */
  transform: scale(var(--star-size));
  /* the magic numbers below correlate with the font-size */
  top: -0.5em;  /* margin-top doesn't work */
  top: calc(var(--star-size) / 6 * -1em);
  margin-left: -2.5em;  /* overlap the radio buttons exactly under the stars */
  margin-left: calc(var(--star-size) / 6 * -5em);
  z-index: 2;  /* bring the button above the stars so it captures touches/clicks */
  opacity: 0;  /* comment to see where the radio buttons are */
  font-size: initial; /* reset to default */
}
.ninja_wrapper .rating > input{
    font-size:8px;
}
.ninja_wrapper .rating{
    font-size: calc(var(--star-size) * 0.8em);
}
.ninja_wrapper .rating > label {
  display: inline-block;
  position: relative;
  width: 1.1em;  /* magic number to overlap the radio buttons on top of the stars */
  width: calc(var(--star-size) / 3 * 1.1em);
  font-size:inherit;
}
/*Star Rating Css End*/
/*Select image field css*/
.listimage-wrap ul li{
    width:200px;
}
.listimage-wrap li input {
    display: none;
}
.listimage-wrap ul li input:checked + label .amp-wp-enforced-sizes { 
  border:2px solid #007acc;
}
/*Select image field css*/
<?php 
global $redux_builder_amp;
if ( 2 == ampforwp_get_setting('amp-design-selector') || 3 == ampforwp_get_setting('amp-design-selector')){?>
    .nf-field-element ul {
        position: relative;
        right: 46px;
    }
<?php } 

if ( 4 == ampforwp_get_setting('amp-design-selector')){?>
    .nf-field-element ul {
        position: relative;
        right: 25px;
    }
.artl-cnt .form-fields-wrapper ul li:before{display:none;}
<?php } ?>

.form-fields-wrapper input[type="radio"], ul li {
    list-style: none;
}
 .form-fields-wrapper input[type=submit] {
    background: #333;
    width: auto;
    border: 0;
    font-size: 11px;
    padding: 15px 30px;
    text-transform: uppercase;
    margin-top: -5px;
    letter-spacing: 2px;
    font-weight: 700;
    color: #fff;
    box-shadow: 2px 3px 6px rgba(102,102,102,0.33);
    top: 14px;
    position: relative;    
}
.form-fields-wrapper textarea{ padding: 10px 9px;width: 100%;    height: 200px;box-sizing: border-box;}
form.amp-form-submit-success .form-fields-wrapper {
  display: none
}
.amp_success_message{background:#DCEDC8;padding: 10px;}.amp_error_message{background:#FFF9C4;padding: 10px;}
<?php
}//Css Function Closed 


// CODE TO ADD LICENSE ACTIVATION FATURE FOR NON AMPFORWP
if(!defined('AMPFORWP_PLUGIN_DIR')){
  $redux_builder_amp = get_option('redux_builder_amp',true);
  add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'amp_ninja_form_ext_plugin_activation_link' );
  function amp_ninja_form_ext_plugin_activation_link( $links ) {
      $_link = '<a href="admin.php?page=amp-ninja-form-license-activation" target="_blank">License Activation</a>';
      $links[] = $_link;
      return $links;
  }
  if(file_exists(ABSPATH . 'wp-admin/includes/plugin.php')){
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
  add_action('init', 'amp_ninja_form_set_extension_license_key_page');
  function amp_ninja_form_set_extension_license_key_page(){
    require_once(dirname( __FILE__ ) . '/license/license-activation.php');
    if(function_exists('add_submenu_page')){
      add_submenu_page(
          '',
          'License Activation',
          'License Activation',
          'manage_options',
          'amp-ninja-form-license-activation',
          'amp_ninja_form_license_activation'
      );
      }
  }
  function amp_ninja_form_license_activation(){
    require_once(dirname( __FILE__ ) . '/license/license-activation-view.php');
  }
}

/**
*
* Update Codes
*
*
**/

// Notice to enter license key once activate the plugin

$path = plugin_basename( __FILE__ );
add_action("after_plugin_row_{$path}", function( $plugin_file, $plugin_data, $status ) {
    global $redux_builder_amp;
     if(! defined('AMP_NINJA_ITEM_FOLDER_NAME')){
    $folderName = basename(__DIR__);
        define( 'AMP_NINJA_ITEM_FOLDER_NAME', $folderName );
    }
    $pluginsDetail = @$redux_builder_amp['amp-license'][AMP_NINJA_ITEM_FOLDER_NAME];
    
    if(!empty($pluginsDetail['status'])){
    $pluginstatus = $pluginsDetail['status'];
    }
     
        $activation_link = 'amp_options&tabid=opt-go-premium';
          if(!defined('AMPFORWP_PLUGIN_DIR')){
            $activation_link = 'amp-ninja-form-license-activation';
          }
    if(empty($redux_builder_amp['amp-license'][AMP_NINJA_ITEM_FOLDER_NAME]['license'])){
        echo "<tr class='active'><td>&nbsp;</td><td colspan='2'><a href='".esc_url(  self_admin_url( 'admin.php?page='.$activation_link )  )."'>Please enter the license key</a> to get the <strong>latest features</strong> and <strong>stable updates</strong></td></tr>";
            }elseif($pluginstatus=="valid"){
                $update_cache = get_site_transient( 'update_plugins' );
        $update_cache = is_object( $update_cache ) ? $update_cache : new stdClass();
        if(isset($update_cache->response[ AMP_NINJA_ITEM_FOLDER_NAME ]) 
            && empty($update_cache->response[ AMP_NINJA_ITEM_FOLDER_NAME ]->download_link) 
          ){
           unset($update_cache->response[ AMP_NINJA_ITEM_FOLDER_NAME ]);
        set_site_transient( 'update_plugins', $update_cache );
        }
        
   }
}, 10, 3 );




/**
*    Plugin Update Method
**/
require_once dirname( __FILE__ ) . '/updater/EDD_SL_Plugin_Updater.php';
// Check for updates
function amp_ninja_forms_plugin_updater() {

    // retrieve our license key from the DB
    //$license_key = trim( get_option( 'amp_ads_license_key' ) );
    $selectedOption = get_option('redux_builder_amp',true);
    $license_key = '';//trim( get_option( 'amp_ads_license_key' ) );
    $pluginItemName = '';
    $pluginItemStoreUrl = '';
    $pluginstatus = '';
    if( isset($selectedOption['amp-license']) && "" != $selectedOption['amp-license'] && isset($selectedOption['amp-license'][AMP_NINJA_ITEM_FOLDER_NAME])){

       $pluginsDetail = $selectedOption['amp-license'][AMP_NINJA_ITEM_FOLDER_NAME];
       $license_key = $pluginsDetail['license'];
       $pluginItemName = $pluginsDetail['item_name'];
       $pluginItemStoreUrl = $pluginsDetail['store_url'];
       $pluginstatus = $pluginsDetail['status'];
    }
    
    // setup the updater
    $edd_updater = new AMP_NINJA_FORMS_EDD_SL_Plugin_Updater( AMP_NINJA_FORMS_STORE_URL, __FILE__, array(
            'version'   => AMP_NINJA_FORMS_VERSION,                // current version number
            'license'   => $license_key,                        // license key (used get_option above to retrieve from DB)
            'license_status'=>$pluginstatus,
            'item_name' => AMP_NINJA_FORMS_ITEM_NAME,          // name of this plugin
            'author'    => 'Mohammed Kaludi',                   // author of this plugin
            'beta'      => false,
        )
    );
}
add_action( 'admin_init', 'amp_ninja_forms_plugin_updater', 0 );