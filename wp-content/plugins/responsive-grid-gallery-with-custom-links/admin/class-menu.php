<?php
if (!class_exists("ABCFRGGCL_Admin_Menu")) {

    class ABCFRGGCL_Admin_Menu {

    function __construct() {
        add_action( 'admin_menu', array (&$this, 'add_menu') );
    }

    function add_menu() {

    $menu_slug = 'edit.php?post_type=cpt_rggcl_item';

        $capability = 'edit_pages';
        //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );dashicons-format-gallery
       //add_menu_page(abcfrggcl_txta(58), abcfrggcl_txta(58), $capability, $menu_slug, '', 'dashicons-screenoptions', 85);

        //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
        add_submenu_page( $menu_slug, abcfrggcl_txta(1), abcfrggcl_txta(1), $capability, 'abcfrggcl-admin-tabs', array (&$this, 'load_page'));
    }

    function load_page() {

        switch ($_GET['page']){
            case 'abcfrggcl-admin-tabs' :
                include_once ( ABCFRGGCL_PLUGIN_DIR . 'admin/admin-tabs.php' );
                abcfrggcl_admin_tabs();
                break;
            default:
                break;
        }
    }
}
}

$abcfrfs = new ABCFRGGCL_Admin_Menu();
