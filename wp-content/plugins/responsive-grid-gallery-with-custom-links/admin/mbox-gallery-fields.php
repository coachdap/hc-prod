<?php
//Render gallery metaboxes.

function abcfrggcl_mbox_gallery_fields( ){

    $optns = abcfrggcl_mbox_gallery_tabs_tplate_optns();
    $tplateOptns = $optns['tplateOptns'];
    abcfrggcl_mbox_gallery_field($tplateOptns, 'F1');
}

function abcfrggcl_mbox_gallery_tabs_tplate_optns(){
    global $post;
    $postID = $post->ID;
    $tplateOptns = get_post_custom( $postID );

    $obj = ABCFRGGCL_Main();
    return array(
        'postID' => $post->ID,
        'tplateOptns' => $tplateOptns,
        'pluginSlug' => $obj->pluginSlug
    );
}
