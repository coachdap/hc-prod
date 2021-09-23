<?php

function abcfrggcl_dba_chidren_qty( $parentID ) {
    global $wpdb;
    return  $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(1) FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'cpt_rggcl_item' AND post_status != 'trash'", $parentID ) );
}

function abcfrggcl_dba_duplicate_post_meta( $postID, $newPostID ) {
    //duplicate all post meta just in two SQL queries
    global $wpdb;
    $postMetaInfo = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id= $postID");

    if ( count($postMetaInfo)!= 0 ) {
           $sqlQuery = "INSERT $wpdb->postmeta ( post_id, meta_key, meta_value ) ";
           foreach ($postMetaInfo as $metaInfo) {
                   $metaKey = $metaInfo->meta_key;
                   $metaValue = addslashes($metaInfo->meta_value);
                   $sqlQquerySel[]= "SELECT $newPostID, '$metaKey', '$metaValue'";
           }
           $sqlQuery.= implode(" UNION ALL ", $sqlQquerySel);
           $wpdb->query($sqlQuery);
   }
}

function abcfrggcl_dba_cbo_templates( $defaultTxt = ' - - - ' ) {
    global $wpdb;
    $cps = array();
    //$cps[0] = abcfrggcl_txta(244);
    $cps[0] = $defaultTxt;
    $dbRows = $wpdb->get_results( "SELECT ID, post_title FROM $wpdb->posts
        WHERE post_type = 'cpt_rggcl_gallery' AND post_status = 'publish'
        ORDER BY post_title" );
    if ($dbRows) { foreach ($dbRows as $row) {$cps[$row->ID] = $row->post_title;} }
    return $cps;
}

function abcfrggcl_dba_items_for_order($parentID) {
    global $wpdb;
    $dbRows = $wpdb->get_results( $wpdb->prepare(
    "SELECT ID, post_title, menu_order
    FROM $wpdb->posts
    WHERE post_parent = %d
    AND post_status = 'publish'
    ORDER BY menu_order ASC", $parentID ), OBJECT_K );
    return $dbRows;
}



