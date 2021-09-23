<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'ms_theme_editor_parent_css' ) ):
    function ms_theme_editor_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap','hestia-font-sizes' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'ms_theme_editor_parent_css', 10 );
         
if ( !function_exists( 'ms_theme_editor_child_css' ) ):
    function ms_theme_editor_child_css() {
        wp_enqueue_style( 'ms_theme_editor_child_ms_separate', trailingslashit( get_stylesheet_directory_uri() ) . 'ms-separate-style.css', array( 'chld_thm_cfg_parent','hestia_style','hestia_woocommerce_style' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'ms_theme_editor_child_css', 20 );

// END ENQUEUE PARENT ACTION
// Custom Scripting to Move JavaScript from the Head to the Footer

function remove_head_scripts() {
remove_action(‘wp_head’, ‘wp_print_scripts’);
remove_action(‘wp_head’, ‘wp_print_head_scripts’, 9);
remove_action(‘wp_head’, ‘wp_enqueue_scripts’, 1);

add_action(‘wp_footer’, ‘wp_print_scripts’, 5);
add_action(‘wp_footer’, ‘wp_enqueue_scripts’, 5);
add_action(‘wp_footer’, ‘wp_print_head_scripts’, 5);
}
add_action( ‘wp_enqueue_scripts’, ‘remove_head_scripts’ );

// END Custom Scripting to Move JavaScript 
