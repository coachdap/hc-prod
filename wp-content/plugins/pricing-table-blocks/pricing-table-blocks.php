<?php
/**
* Plugin Name: Pricing Table Blocks
* Plugin URI: https://fatcatapps.com/easypricingtables/
* Author: Fatcat Apps
* Author URI: https://fatcatapps.com/
* Description: Pricing Table Blocks for Gutenberg
* License: GPLv2
* Text Domain: pricing-table-blocks
* Version: 1.0.1
*/

defined( 'ABSPATH' ) or die( 'Unauthorized Access!' );

define( 'FCA_EPT_DEBUG', FALSE );
define( 'FCA_EPT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FCA_EPT_PLUGINS_URL', plugins_url( '', __FILE__ ) );
define( 'FCA_EPT_PLUGINS_BASENAME', plugin_basename(__FILE__) );
define( 'FCA_EPT_PLUGIN_FILE', __FILE__ );

if ( FCA_EPT_DEBUG ) {
   define( 'FCA_EPT_PLUGIN_VER', '1.0.' . time() );
} else {
   define( 'FCA_EPT_PLUGIN_VER', '1.0.1' );
}

// Load assets for editor
function fca_ept_admin() {
	wp_enqueue_script( 'fca-ept-editor', plugins_url( 'includes/block.js', __FILE__ ), array( 'wp-blocks', 'wp-element' ), FCA_EPT_PLUGIN_VER );
	wp_enqueue_style( 'fca-ept-layout2', plugins_url( 'includes/layouts/block-layout2.css', __FILE__ ), array(), FCA_EPT_PLUGIN_VER );
	wp_enqueue_style( 'fca-ept-editor', plugins_url( 'includes/block-editor.css', __FILE__ ), array(), FCA_EPT_PLUGIN_VER );
}

add_action( 'enqueue_block_editor_assets', 'fca_ept_admin' );

// Load assets for frontend
function fca_ept_frontend() {
	wp_enqueue_style( 'fca-ept-layout2', plugins_url( 'includes/layouts/block-layout2.css', __FILE__ ), array(), FCA_EPT_PLUGIN_VER );
}
add_action( 'wp_enqueue_scripts', 'fca_ept_frontend' );
