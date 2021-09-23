<?php
/**
 * Fired when the plugin is uninstalled.
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if (is_multisite())
{
    global $wpdb;
    $blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);

    if(!empty($blogs)) {
        foreach($blogs as $blog)  {
	    switch_to_blog($blog['blog_id']);
            abcfrggcl_delete_caps();
            abcfrggcl_delete_optns();
        }
    }
} else {
    abcfrggcl_delete_caps();
    abcfrggcl_delete_optns();
}

function abcfrggcl_delete_caps(){

    $delete_caps = array(
        'rggcl_manage_items',
        'rggcl_manage_galleries'
        );
    global $wp_roles;
    foreach ($delete_caps as $cap) {
        foreach (array_keys($wp_roles->roles) as $role) {
                $wp_roles->remove_cap($role, $cap);
        }
    }
}

function abcfrggcl_delete_optns(){
    delete_option('rggcl_default_tplate_id');
}