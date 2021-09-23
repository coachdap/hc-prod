<?php
/*
Plugin Name: Responsive Grid Gallery Custom Links
Plugin URI: http://abcfolio.com/wordpress-plugin-responsive-grid-gallery-custom-links/
Description:  Responsive grid galleries with custom links.
Author: abcFolio - Quality WordPress Plugins
Author URI: http://www.abcfolio.com
Text Domain: responsive-grid-gallery-custom-links
Domain Path: /languages
Version: 0.2.2
------------------------------------------------------------------------
Copyright 2009-2015 abcFolio.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses.
*/


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'ABCF_RGGCL' ) ) {

final class ABCF_RGGCL {

    private static $instance;
    public $pluginSlug = 'responsive-grid-gallery-custom-links';
    public $prefix = 'rggcl';
    public $pluginVersion = '0.2.2';

    /**
     * Main PLUGIN Instance
     * Insures that only one instance of plugin exists in memory at any one time. Also prevents needing to define globals all over the place.
     */
    public static function instance() {
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof ABCF_RGGCL ) ) {
                    self::$instance = new ABCF_RGGCL;
                    self::$instance->setup_constants();
                    self::$instance->includes();
                    self::$instance->setup_actions();
                    self::$instance->load_textdomain();
            }
            return self::$instance;
    }

    private function __construct (){}

    private function setup_constants() {

        // Plugin version pversion
        if ( ! defined( 'ABCFRGGCL_VERSION' ) ) { define( 'ABCFRGGCL_VERSION', $this->pluginVersion ); }
        if ( ! defined( 'ABCFRGGCL_ABSPATH' ) ) {  define('ABCFRGGCL_ABSPATH', ABSPATH); }
        // Plugin Folder QPath
        if( ! defined( 'ABCFRGGCL_PLUGIN_DIR' ) ){ define( 'ABCFRGGCL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); }
        // Plugin Folder URL
        if ( ! defined( 'ABCFRGGCL_PLUGIN_URL' ) ) { define( 'ABCFRGGCL_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); }
        // Plugin folder name abcfolio-responsive-grid-gallery-custom-links
        if( ! defined( 'ABCFRGGCL_PLUGIN_FOLDER' ) ){ define('ABCFRGGCL_PLUGIN_FOLDER', basename( dirname(__FILE__) ) ); }
        // Plugin Root File QPath
        if ( ! defined( 'ABCFRGGCL_PLUGIN_FILE' ) ){ define( 'ABCFRGGCL_PLUGIN_FILE', __FILE__ ); }
        if ( ! defined( 'ABCFRGGCL_ICONS_URL' ) ){ define( 'ABCFRGGCL_ICONS_URL', trailingslashit(trailingslashit(ABCFRGGCL_PLUGIN_URL) . 'images')); }
     }


    //Include required files
    private function includes() {
        require_once ABCFRGGCL_PLUGIN_DIR . 'inc/db.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'inc/post-types.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'inc/scripts.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'inc/grid-items.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'inc/grid.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'inc/shortcode.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'inc/util.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'inc/img.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'library/abcfl-css.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'library/abcfl-html.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'library/abcfl-attr.php';
        require_once ABCFRGGCL_PLUGIN_DIR . 'library/abcfl-util.php';

        if( is_admin() ) {
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/admin-scripts.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/dba.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/autil.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/class-menu.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/cbos.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/class-mbox-gallery.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/class-mbox-item.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/ajax-handlers.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/txt-admin.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/txt-aurl.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'library/abcfl-input.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'library/abcfl-mbox-save.php';

            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/mbox-gallery-tabs.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/v-tabs.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/mbox-gallery-layout.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/mbox-gallery-item-order.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/mbox-gallery-shortcode.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/mbox-gallery-field.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/mbox-gallery-fields.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/admin-help.php';
            require_once ABCFRGGCL_PLUGIN_DIR . 'admin/admin-default-tplate.php';

            include_once (ABCFRGGCL_PLUGIN_DIR . 'admin/admin-help.php');

            $mboxLst = new ABCFRGGCL_MBox_Gallery();
            $mboxLstItem = new ABCFRGGCL_MBox_Item();
        }
    }

    private function setup_actions() {
        add_action( 'admin_print_styles-post-new.php', array( $this, 'remove_permalink' ), 1 );
        add_action( 'admin_print_styles-post.php', array( $this, 'remove_permalink' ), 1000 );
        add_action( 'load-edit.php', array( $this, 'add_custom_columns' ), 10, 2 );

        add_filter( 'post_row_actions', array( $this, 'remove_post_edit_links' ), 10, 1 );

        add_action( 'admin_init', array( $this, 'add_role_caps' ), 999 );
        register_activation_hook( __FILE__, array( $this, 'activation' ) );
    }

    //-------------------------------------------------
    public function activation() {
        $this->add_caps( 'administrator' );
        $this->add_caps( 'editor' );
    }

    public function add_role_caps() {
        $this->add_caps( 'administrator' );
        $this->add_caps( 'editor' );
    }

    public function add_caps( $toRole ) {

        $role = get_role( $toRole );

        if ( ! is_null( $role ) ) {

            //- Gallery
            $role->add_cap( 'rggcl_manage_items');
            $role->add_cap( 'rggcl_manage_galleries');
        }
    }


    //===CUSTOM COLUMNS=========================================================================================
   function add_custom_columns() {
       //manage_edit-{$post_type}_columns add_filter
       // manage_{$post_type}_posts_custom_column

        add_filter( 'manage_cpt_rggcl_item_posts_columns', array( $this,'add_staff_columns'), 10 );
        add_action( 'manage_cpt_rggcl_item_posts_custom_column', array( $this, 'render_staff_columns' ), 10, 2 );
        add_filter( 'post_row_actions', array( $this, 'duplicate_post_link'), 10, 2);

        add_filter( 'manage_cpt_rggcl_tplate_posts_columns', array( $this,'add_template_columns'), 10 );
        add_action( 'manage_cpt_rggcl_tplate_posts_custom_column', array( $this, 'render_template_columns' ), 10, 2 );
        add_action( 'pre_get_posts', array( $this, 'gallery_items_order'));
    }

    //== duplicate ==
    //Add the duplicate link to action list for post_row_actions
   function duplicate_post_link( $actions, $post ) {

        if ($post->post_type=='cpt_rggcl_gallery' && current_user_can('edit_posts')) {
            $actions['duplicate'] = '<a href="admin.php?action=duprggcltplate&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
        }

        if ($post->post_type=='cpt_rggcl_item' && current_user_can('edit_posts')) {
            $actions['duplicate'] = '<a href="admin.php?action=duprggclitem&amp;post=' . $post->ID . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
        }
        return $actions;
   }

    //Add custom columns to post list admin colums
    function add_staff_columns($defaults) {

        $defaults['menu-order'] = 'Order';
        $defaults['lst-name'] = 'Gallery';
        $defaults['item-img'] = 'Image';
        $defaults['post-id'] = 'ID';
        return $defaults;
    }

    function add_template_columns($defaults) {

        $defaults['post-id'] = 'ID';
        return $defaults;
    }

    function render_template_columns($column_name, $postID) {
        if($column_name === 'post-id'){ echo $postID; }
    }

    function render_staff_columns($column_name, $postID) {

        $lstName = '';
        if ($column_name == 'lst-name') {

            $parentID = wp_get_post_parent_id( $postID );
            if($parentID){
                $parent = get_post($parentID);
                if($parent){$lstName = $parent->post_title;}
            }
            echo $lstName;
        }

        if ($column_name == 'item-img') {
            //$optns = get_post_custom($postID);
            //$imgUrl = isset( $optns['_imgUrl'] ) ? esc_attr( $optns['_imgUrl'][0] ) : '';
            $imgUrl = get_post_meta( $postID, '_imgUrl', true );
            echo abcfl_html_img_tag('', $imgUrl, '', '', 60);
        }

        if ($column_name == 'menu-order') { echo get_post_field( 'menu_order', $postID ); }
        if ($column_name == 'lst-id') {  echo get_post_field( 'post_parent', $postID ); }
        if($column_name === 'post-id'){ echo $postID; }
}

    function add_sortable_columns( $columns ) {
       //$columns[ 'lst-id' ] = 'lst-id';
       $columns[ 'menu-order' ] = 'menu-order';
       return $columns;
    }

    function gallery_items_order( $query ) {

       $postType = $query->get('post_type');

        if ( $postType == 'cpt_rggcl_item') {
            if ( $query->get( 'orderby' ) == '' ) {
                $query->set( 'orderby', array( 'post_parent' => 'ASC', 'menu_order' => 'ASC',  ));
            }
            /* Post Order: ASC / DESC */
            if( $query->get( 'order' ) == '' ){
                $query->set( 'order', 'ASC' );
            }
        }
    }

    //--Remove permalink and preview buttons from custom posts screen. -----------------------
    function remove_permalink() {
        global $post_type;;
        if ( abcfrggcl_autil_post_type( $post_type ) > 0 ) {
            echo '<style type="text/css">#edit-slug-box,#view-post-btn,#post-preview,.updated p a{display: none;}</style>';
        }
    }

    //Remove view and quick edit from custom posts list.
    function remove_post_edit_links( $actions ){

        $postType = get_post_type();
        if ( abcfrggcl_autil_post_type( $postType ) > 0 ) {
            unset( $actions['view'] );
            unset( $actions['inline hide-if-no-js'] );
        }
        return $actions;
    }
    //----------------------------------------------------
    // TODO
    function load_textdomain() {

        $pslug = $this->pluginSlug;
        $langDir = plugin_basename( dirname( __FILE__ ) ) . '/languages';

        // Set filter for plugin's languages directory
        $langDir = apply_filters( 'abcfrggcl_languages_directory', $langDir );

        // Traditional WordPress plugin locale filter
        $locale  = apply_filters( 'plugin_locale',  get_locale(), $pslug );
        $mofile  = sprintf( '%1$s-%2$s.mo', $pslug, $locale );

        // Setup paths to current locale file
        $mofileLocal  = $langDir . $mofile;
        $mofileGlobal = WP_LANG_DIR . '/' . $pslug . '/' . $mofile;

        if ( file_exists( $mofileGlobal ) ) {
            load_textdomain( $pslug, $mofileGlobal );
        } elseif ( file_exists( $mofileLocal ) ) {
            load_textdomain( $pslug, $mofileLocal );
        } else {
            load_plugin_textdomain( $pslug, false, $langDir );
        }
    }
}
} // End class_exists check
/**
 * The main function responsible for returning the one true ABCFRGGCL_Main instance to functions everywhere.
 * Use this function like you would a global variable, except without needing to declare the global.
 *  * Example: $object = ABCFRGGCL_Main();
 */
function ABCFRGGCL_Main() {
    return ABCF_RGGCL::instance();
}
// Get plugin Running
ABCFRGGCL_Main();