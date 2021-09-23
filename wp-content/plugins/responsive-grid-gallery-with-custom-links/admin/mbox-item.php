<?php
// Render input fields

function abcfrggcl_mbox_item(){

    global $post;
    $postID = $post->ID;
    $itemOptns = get_post_custom( $postID );
    $tplateID = $post->post_parent;
    if( $tplateID == 0 ) { $tplateID = get_option( 'rggcl_default_tplate_id', 0 ); }
    $tplateOptns = get_post_custom( $tplateID );

    abcfrggcl_mbox_item_img( $itemOptns );
    abcfrggcl_mbox_item_fields_T( $tplateOptns, $itemOptns, 'F1' );

    $obj = ABCFRGGCL_Main();
    $slug = $obj->pluginSlug;
    wp_nonce_field( $slug, $slug . '_nonce' );
}

function abcfrggcl_mbox_item_img_OLD( $itemOptns ){

    $imgID = isset( $itemOptns['_imgID'] ) ? esc_attr( $itemOptns['_imgID'][0] ) : 0;
    $imgUrl = isset( $itemOptns['_imgUrl'] ) ? esc_attr( $itemOptns['_imgUrl'][0] ) : '';
    $imgLnk = isset( $itemOptns['_imgLnk'] ) ? esc_attr( $itemOptns['_imgLnk'][0] ) : '';

    echo abcfl_input_hlp_lbl(abcfrggcl_txta(27), 'abcflMTop10', 14, 'B');
    echo abcfl_html_img_tag('', $imgUrl, '', '', 200, '', 'abcflMTop15');

    //imgUrl itemImgUrl
    echo abcfl_input_txt('imgUrl', '', $imgUrl, abcfrggcl_txta(17), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_hidden( 'imgID', 'imgID', $imgID );

    echo  abcfl_html_tag('div','','abcflPTop10');
        echo abcfl_input_btn('btnImg', 'btnImg', 'button', abcfrggcl_txta(239), 'button' );
    echo abcfl_html_tag_end('div');

    echo abcfl_input_txt('imgLnk', '', $imgLnk, abcfrggcl_txta(53), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');

    echo abcfl_input_sec_title( abcfrggcl_txta(85), 'abcflFontWPHdr abcflFontS12 abcflFontW600 abcflMTop15' );

    echo abcfl_input_hline('3', 15);
}

function abcfrggcl_mbox_item_img( $itemOptns ){

    $imgID = isset( $itemOptns['_imgID'] ) ? esc_attr( $itemOptns['_imgID'][0] ) : 0;
    $imgUrl = isset( $itemOptns['_imgUrl'] ) ? esc_attr( $itemOptns['_imgUrl'][0] ) : '';
    $imgLnk = isset( $itemOptns['_imgLnk'] ) ? esc_attr( $itemOptns['_imgLnk'][0] ) : '';
    //$imgTitle = isset( $itemOptns['_imgTitle'] ) ? esc_attr( $itemOptns['_imgTitle'][0] ) : '';
    $imgAlt = isset( $itemOptns['_imgAlt'] ) ? esc_attr( $itemOptns['_imgAlt'][0] ) : '';
    $imgLnkArgs = isset( $itemOptns['_imgLnkArgs'] ) ? esc_attr( $itemOptns['_imgLnkArgs'][0] ) : '';
    //$imgLnkClick = isset( $itemOptns['_imgLnkClick'] ) ? esc_attr( $itemOptns['_imgLnkClick'][0] ) : '';
    //-----------------------------------------------------

    //echo abcfl_input_hlp_lbl(abcfrggcl_txta(27), 'abcflMTop10', 14, 'B');
    //echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(27), abcfrggcl_aurl(0) );
    echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(27), abcfrggcl_aurl(12) );

    echo abcfl_html_img_tag('', $imgUrl, '', '', 200, '', 'abcflMTop15');

    echo abcfl_html_tag_cls('div', 'abcflFloatsCntr');
    echo abcfl_input_txt('imgUrl', '', $imgUrl, abcfrggcl_txta(17), '', '100%', '', '', 'abcflFloatL abcflWidth90Pc', 'abcflFldLbl');
    echo abcfl_input_txt_dr('readonly', true, 'imgID', '', $imgID, 'ID', '', '100%', '', '', 'abcflFloatL abcflWidth10Pc', 'abcflFldLbl');
    echo abcfl_html_tag_cls('div', 'abcflClr', true);
    echo abcfl_html_tag_end('div');

    echo  abcfl_html_tag('div','','abcflPTop10');
        echo abcfl_input_btn('btnImg', 'btnImg', 'button', abcfrggcl_txta(239), 'button' );
    echo abcfl_html_tag_end('div');
    //???????? 18

    $lbl = abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta( 238 ), abcfrggcl_aurl( 18 ), 'abcflFontWP abcflFontS13 abcflFontW400' );

    echo abcfl_input_txt( 'imgAlt', '', $imgAlt, $lbl, '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
    //echo abcfl_input_txt( 'imgAlt', '', $imgAlt, abcfrggcl_txta(238), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl' );
    
    //---------------------------------------------------------
    echo abcfl_input_hline('2', 15);
    echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(53), abcfrggcl_aurl(13) );
    echo abcfl_input_txt('imgLnk', '', $imgLnk, abcfrggcl_txta(53), abcfrggcl_txta(205), '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_txt('imgLnkArgs', '', $imgLnkArgs, abcfrggcl_txta(84), '', '100%', '', '', 'abcflFldCntr', 'abcflFldLbl');

    //echo abcfl_input_sec_title( abcfrggcl_txta(85), 'abcflFontWPHdr abcflFontS12 abcflFontW600 abcflMTop15' );

    echo abcfl_input_hline('3', 15);
}

//===================================================================
//Text.
function abcfrggcl_mbox_item_fields_T( $tplateOptns, $itemOptns, $F ){

    $lineTxt = isset( $itemOptns['_txt_' . $F] ) ? esc_attr( $itemOptns['_txt_' . $F][0] ) : '';
    $inputLbl = abcfrggcl_mbox_item_fields_line_number( $F , isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : '' );
    $inputHlp = isset( $tplateOptns['_inputHlp_' . $F] ) ? esc_attr( $tplateOptns['_inputHlp_' . $F][0] ) : '';

    echo abcfl_input_txt('txt_' . $F, '', $lineTxt, $inputLbl, $inputHlp, '100%', '', '', 'abcflFldCntr', 'abcflFldLbl  abcflFontW700');
}

function abcfrggcl_mbox_item_fields_line_number( $F , $inputLbl, $suffix='' ){

    return '<span class="abcflFontW600 abcflFontFVS12">' . $F . '.&nbsp&nbsp' . $inputLbl . '</span><span>' . $suffix . '</span>';
}


