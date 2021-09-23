<?php

function abcfrggcl_db_grid_items_ids( $parentID ) {
    global $wpdb;

    $postIDs = $wpdb->get_col( $wpdb->prepare(
    "SELECT ID
    FROM $wpdb->posts
    WHERE post_parent = %d
    AND post_status = 'publish'
    ORDER BY menu_order ASC", $parentID ));

    return $postIDs;
}

