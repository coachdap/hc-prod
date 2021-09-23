<?php
add_filter( 'wp_insert_post_data','abcfrggcl_autil_untrash_tplate', 10, 2 );
add_action( 'admin_action_duprggcltplate', 'abcfrggcl_autil_duplicate_tplate' );
add_action( 'admin_action_duprggclitem', 'abcfrggcl_autil_duplicate_item' );

//Don't delete a gallery it has items.
function abcfrggcl_autil_untrash_tplate($data, $postarr ){

    $out = abcfrggcl_autil_post_type ( $data['post_type'] );
    if( $out == 1){
        switch ( $data['post_status'] ) {
        case 'trash' :
            if( abcfrggcl_dba_chidren_qty( $postarr['ID'] ) > 0 ){
                wp_die(abcfrggcl_txta(204) );
                exit;
            }
            break;
        default:
            break;
        }
    }
    return $data;
}

//Duplicate template
function abcfrggcl_autil_duplicate_tplate(){

    if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'duprggcltplate' == $_REQUEST['action'] ) ) ) {
            wp_die('No post to duplicate has been supplied!');
            exit;
    }

    //get the original post id
    $postID = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);

    $post = get_post( $postID );
    if (!isset( $post )) { wp_die('Post creation failed, could not find original post: ' . $postID); }
    if ($post == null) { wp_die('Post creation failed, could not find original post: ' . $postID); }

    $out = abcfrggcl_autil_duplicate_custom_post($postID, $post);
    if( $out == 'KO' ){ wp_die('Post creation failed: ' . $postID);}

    wp_redirect( admin_url( 'edit.php?post_type=cpt_rggcl_gallery' ) );
    exit;
}

//Duplicate template
function abcfrggcl_autil_duplicate_item(){

    if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'duprggclitem' == $_REQUEST['action'] ) ) ) {
            wp_die('No post to duplicate has been supplied!');
            exit;
    }

    //get the original post id
    $postID = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);

    $post = get_post( $postID );
    if (!isset( $post )) { wp_die('Post creation failed, could not find original post: ' . $postID); }
    if ($post == null) { wp_die('Post creation failed, could not find original post: ' . $postID); }

    $out = abcfrggcl_autil_duplicate_custom_post($postID, $post);
    if( $out == 'KO' ){ wp_die('Post creation failed: ' . $postID);}

    //http://localhost:8080/blog/wp-admin/admin.php?action=duprggclitem&post=5870
    wp_redirect( admin_url( 'edit.php?post_type=cpt_rggcl_item' ) );
    exit;
}

//Create a copy of custom post.
function abcfrggcl_autil_duplicate_custom_post($postID, $post) {

    $out = 'KO';
    $newTitle = $post->post_title . ' - Copy';
    $postData = array(
            'comment_status' => $post->comment_status,
            'ping_status'    => $post->ping_status,
            'post_author'    => $post->post_author,
            'post_content'   => $post->post_content,
            'post_excerpt'   => $post->post_excerpt,
            'post_name'      => $post->post_name,
            'post_parent'    => $post->post_parent,
            'post_password'  => $post->post_password,
            'post_status'    => 'publish',
            'post_title'     => $newTitle,
            'post_type'      => $post->post_type,
            'to_ping'        => $post->to_ping,
            'menu_order'     => $post->menu_order
    );

    //Duplicate post
    $newPostID = wp_insert_post( $postData );

    if ( is_wp_error( $newPostID ) ) { return $out; }
    if (!$newPostID) { return $out; }

    wp_update_post( array('ID' => $newPostID, 'post_title'   => $newTitle . ' ' . $newPostID ) );

    //Duplicate all post meta.
    abcfrggcl_dba_duplicate_post_meta( $postID, $newPostID );

   return 'OK';
}

//Called from responsive-grid-gallery-custom-links. remove_permalink , remove_post_edit_links
function abcfrggcl_autil_post_type ( $postType ){
    $out = 0;

    switch ($postType) {
        case 'cpt_rggcl_gallery':
            $out = 1;
            break;
        case 'cpt_rggcl_item':
            $out = 2;
            break;
        default:
            break;
    }
    return $out;
}

//?????????????????????????????????????
function abcfrggcl_autil_cntr_icon( $cntr ){

    $src = ABCFRGGCL_PLUGIN_URL . '/images/container-' . $cntr . '.png';
    echo abcfl_html_img_tag('', $src, '', '');
}

//Generic class + style  section.
function abcfrggcl_autil_class_and_style( $clsName, $clsValue, $styleName, $styleValue, $F,
        $addHdr, $hline='', $clsLbl='', $styleLbl='', $clsHelp='',
        $styleHelp='', $aurl=2, $customHdrID='' ){

    //$hdr = true; Generic header is added to CSS section.
    //$customHdrID=''; Custom header is added to CSS section.
    //$aurl = 0; No ? icon.
    //If field label or text parameter is blank, defaults are shown.

    //Default labels and descriptions
    if ( empty( $clsLbl ) ) { $clsLbl = 51; }
    if ( empty( $styleLbl ) ) { $styleLbl = 18; }
    if ( empty( $clsHelp ) ) { $clsHelp = 223; }
    if ( empty( $styleHelp ) ) { $styleHelp = 224; }

    //Default text of a header.
    $hdrTxt = 80;
    if( !empty( $customHdrID ) ) {
        $addHdr = true;
        $hdrTxt = $customHdrID;
    }

    if( !empty( $hline ) ) { echo abcfl_input_hline( $hline ); }

    //? Icon is added to Header label or Class label.
    $lbl = abcfrggcl_txta( $clsLbl );
    if( $addHdr ) {
        echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta( $hdrTxt ), abcfrggcl_aurl( $aurl ) );
    }
    else{
        $lbl = abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta( $clsLbl ), abcfrggcl_aurl( $aurl ), 'abcflFontWP abcflFontS13 abcflFontW400' );
    }

    echo abcfl_input_txt( $clsName . $F, '', $clsValue, $lbl, abcfrggcl_txta( $clsHelp ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
    echo abcfl_input_txt( $styleName . $F, '', $styleValue, abcfrggcl_txta( $styleLbl ), abcfrggcl_txta( $styleHelp ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
}

//== SORTING FIELDS - START ===================================================
//Add new field to meta fields order. If field already exists exit with no updates. Called from save template.
function abcfrggcl_autil_add_new_field_to_field_order( $postID, $F ){

    $tplateOptns = get_post_custom( $postID );
    //delete_post_meta($postID, '_fieldOrder');
    $savedFieldOrder = isset( $tplateOptns['_fieldOrder'] ) ? $tplateOptns['_fieldOrder'][0] : '';

    if( empty( $savedFieldOrder ) ){
        abcfrggcl_autil_add_meta_field_order( $postID, '_fieldOrder', $F );
    }
    else{
         abcfrggcl_autil_update_meta_field_order( $postID, '_fieldOrder', $savedFieldOrder, $F );
    }
}

//No metadata option exists. Add new option and a single field (first one)
function abcfrggcl_autil_add_meta_field_order( $postID, $metaFieldName, $F ){

    $metaValue[1] = $F;
    update_post_meta( $postID, $metaFieldName, $metaValue );
}

//Metadata exists. Check if a field is already present. If so exit. Otherwise add a new field and exit.
function abcfrggcl_autil_update_meta_field_order( $postID, $metaFieldName, $savedFieldOrder, $F ){

    $metaDataArray = unserialize( $savedFieldOrder );

    //Check if field is already in an array. If so exit.
    if (in_array($F, $metaDataArray)) { return; }

    for ( $i = 1; $i <= 10; $i++ ) {
        //Add new field to first available key and exit.
        if(!isset($metaDataArray[$i])){
           $metaDataArray[$i] = $F;
           update_post_meta( $postID, $metaFieldName, $metaDataArray );
           return;
        }
    }
}
