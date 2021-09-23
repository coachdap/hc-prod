<?php
/**
 * Custom post types setup
*/
if ( ! defined( 'ABSPATH' ) ) {exit;}

add_action( 'init', 'abcfrggcl_register_post_type', 100 );

//----------------------------------------
function abcfrggcl_register_post_type() {

    $slug = 'edit.php?post_type=cpt_rggcl_item';

    register_post_type( 'cpt_rggcl_item', abcfrggcl_post_types_item() );
    register_post_type( 'cpt_rggcl_gallery', abcfrggcl_post_types_gallery( $slug ) );
}

function abcfrggcl_register_taxonomy() {
    register_taxonomy( 'tax_rggcl_cat', array( 'cpt_rggcl_item'), abcfrggcl_post_types_tax_cat() );
}

//-- Items --------------------------------------------------------------
function abcfrggcl_post_types_item_lbls() {

    $lbls = array(
            'menu_name' => 'Responsive Grid Gallery',
            'name'               => __( 'Grid Gallery Items', 'responsive-grid-gallery-custom-links' ), //Sliders table
            'add_new'            => __( 'Add New' ),
            'add_new_item'       => __( 'Grid Gallery Item', 'responsive-grid-gallery-custom-links' ),
            'edit_item'          => __( 'Grid Gallery Item', 'responsive-grid-gallery-custom-links' ),
            'new_item'           => __( 'New'),
            'all_items'          => __( 'Gallery Items', 'responsive-grid-gallery-custom-links' ), //Main menu label
            'search_items'       => __( 'Search', 'responsive-grid-gallery-custom-links-pro' ),
            'not_found'          => __( 'No records found', 'responsive-grid-gallery-custom-links' ),
            'not_found_in_trash' => __( 'No records found in the Trash', 'responsive-grid-gallery-custom-links' )
    );

    return $lbls;
}

function abcfrggcl_post_types_item() {

    $capabilities = array(
     'create_posts' => 'rggcl_manage_items',
     'publish_posts' => 'rggcl_manage_items',
     'edit_posts' => 'rggcl_manage_items',
     'edit_post' => 'rggcl_manage_items',
     'edit_others_posts' => 'rggcl_manage_items',
     'edit_published_posts' => 'rggcl_manage_items',
     'delete_posts' => 'rggcl_manage_items',
     'delete_post' => 'rggcl_manage_items',
     'delete_others_posts' => 'rggcl_manage_items',
     'manage_posts' => 'rggcl_manage_items',
     'read_private_posts' => 'rggcl_manage_items',
     'read_post' => 'rggcl_manage_items'
     );

    $args = array(
            'labels'        => abcfrggcl_post_types_item_lbls(),
            'description'   => '',
            'public'        => false,
    'exclude_from_search'   => true,
    'publicly_queryable'   => false,
    'show_in_nav_menus'   => false,
    'show_ui'       => true,
            'hierarchical'  => false,
            'supports'      => array( 'title' ),
            'has_archive'   => false,
            'show_in_menu'  => true,
        'menu_icon'   => 'dashicons-screenoptions',
        'menu_position' => 83,
        'capabilities' => $capabilities,
        'map_meta_cap' => false
    );
    return $args;
}

//-- Galleries ----------------------------------------------------
function abcfrggcl_post_types_gallery_lbls() {

    $lbls = array(
        'name'               => __( 'Gallery Template', 'responsive-grid-gallery-custom-links' ),
        'add_new'            => __( 'Add New' ),
        'add_new_item'       => __( 'Responsive Grid Gallery with Custom Links', 'responsive-grid-gallery-custom-links' ),
        'edit_item'          => __( 'Gallery Template', 'responsive-grid-gallery-custom-links' ),
        'new_item'           => __( 'New'),
        'all_items'          => __( 'Gallery Templates', 'responsive-grid-gallery-custom-links' ), //Main menu label
        'search_items'       => __( 'Search', 'responsive-grid-gallery-custom-links-pro' ),
        'not_found'          => __( 'No records found', 'responsive-grid-gallery-custom-links' ),
        'not_found_in_trash' => __( 'No records found in the Trash', 'responsive-grid-gallery-custom-links' )
    );

    return $lbls;
}

function abcfrggcl_post_types_gallery( $slug) {

    $capabilities = array(
     'create_posts' => 'rggcl_manage_galleries',
     'publish_posts' => 'rggcl_manage_galleries',
     'edit_posts' => 'rggcl_manage_galleries',
     'edit_post' => 'rggcl_manage_galleries',
     'edit_others_posts' => 'rggcl_manage_galleries',
     'edit_published_posts' => 'rggcl_manage_galleries',
     'delete_posts' => 'rggcl_manage_galleries',
     'delete_post' => 'rggcl_manage_galleries',
     'delete_others_posts' => 'rggcl_manage_galleries',
     'manage_posts' => 'rggcl_manage_galleries',
     'read_private_posts' => 'rggcl_manage_galleries',
     'read_post' => 'rggcl_manage_galleries'
     );


    $args = array(
            'labels'        => abcfrggcl_post_types_gallery_lbls(),
            'description'   => '',
            'public'        => false,
            'hierarchical'  => false,
            'supports'      => array( 'title' ),
            'has_archive'   => false,
            'show_ui'       => true,
            'show_in_menu'  => $slug,
            'capabilities' => $capabilities,
            'map_meta_cap' => false
    );

    return $args;
}