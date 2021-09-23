<?php
function abcfrggcl_mbox_gallery_layout( $tplateOptns ){

  echo  abcfl_html_tag('div','GO1','inside abcflFadeIn');

    $gridCols = isset( $tplateOptns['_gridCols'] ) ? esc_attr( $tplateOptns['_gridCols'][0] ) : '2';
    $vAid = isset( $tplateOptns['_vAid'] ) ? esc_attr( $tplateOptns['_vAid'][0] ) : 'N';

    $gCntrW = isset( $tplateOptns['_gCntrW'] ) ? esc_attr( $tplateOptns['_gCntrW'][0] ) : '';
    $gCntrCenter = isset( $tplateOptns['_gCntrCenter'] ) ? esc_attr( $tplateOptns['_gCntrCenter'][0] ) : 'N';
    $gCntrCls = isset( $tplateOptns['_gCntrCls'] ) ? esc_attr( $tplateOptns['_gCntrCls'][0] ) : '';
    $gCntrStyle = isset( $tplateOptns['_gCntrStyle'] ) ? esc_attr( $tplateOptns['_gCntrStyle'][0] ) : '';

    $itemPadLR = isset( $tplateOptns['_itemPadLR'] ) ? esc_attr( $tplateOptns['_itemPadLR'][0] ) : 'N';
    $itemMarginB = isset( $tplateOptns['_itemMarginB'] ) ? esc_attr( $tplateOptns['_itemMarginB'][0] ) : 'N';
    $itemCls = isset( $tplateOptns['_itemCls'] ) ? esc_attr( $tplateOptns['_itemCls'][0] ) : '';
    $itemStyle = isset( $tplateOptns['_itemStyle'] ) ? esc_attr( $tplateOptns['_itemStyle'][0] ) : '';

    $imgCls = isset( $tplateOptns['_imgCls'] ) ? esc_attr( $tplateOptns['_imgCls'][0] ) : '';
    $imgStyle = isset( $tplateOptns['_imgStyle'] ) ? esc_attr( $tplateOptns['_imgStyle'][0] ) : '';

    $txtCntrCls = isset( $tplateOptns['_txtCntrCls'] ) ? esc_attr( $tplateOptns['_txtCntrCls'][0] ) : '';
    $txtCntrStyle = isset( $tplateOptns['_txtCntrStyle'] ) ? esc_attr( $tplateOptns['_txtCntrStyle'][0] ) : '';
    $addMaxW = isset( $tplateOptns['_addMaxW'] ) ? esc_attr( $tplateOptns['_addMaxW'][0] ) : 'N';

    abcfrggcl_mbox_gallery_layout_columns_cntr( $gridCols );
    abcfrggcl_mbox_gallery_layout_grid_item_cntr( $itemPadLR,  $itemMarginB, $itemCls, $itemStyle, $vAid );
    abcfrggcl_mbox_gallery_layout_img_cntr( $imgCls, $imgStyle );
    abcfrggcl_mbox_gallery_layout_txt_cntr( $txtCntrCls, $txtCntrStyle, $addMaxW );
    abcfrggcl_mbox_gallery_layout_gallery_cntr( $gCntrW, $gCntrCls, $gCntrStyle, $gCntrCenter );

  echo abcfl_html_tag_end('div');
}
//===============================================================================
//Number of columns
function abcfrggcl_mbox_gallery_layout_columns_cntr( $gridCols ){
    $cboCols = abcfrggcl_cbo_grid_columns();

    abcfl_input_sec_icon_hdr_hlp( ABCFRGGCL_ICONS_URL, 'gallery-columns.png', abcfrggcl_txta(16), abcfrggcl_txta(0), abcfrggcl_aurl(0) );
    echo abcfl_input_cbo_strings('gridCols', '',$cboCols, $gridCols, abcfrggcl_txta_r(16), '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Gallery Item style.
function abcfrggcl_mbox_gallery_layout_grid_item_cntr( $itemPadLR, $itemMarginB, $itemCls, $itemStyle, $vAid ){

    $cboItemMB = abcfrggcl_cbo_margin_top_bottom();
    $cboItemPadLR = abcfrggcl_cbo_pad_lr();
    $cboYN = abcfrggcl_cbo_yn();

    //abcfrggcl_mbox_gallery_layout_section_hdr( 'item-container.png', 65, 0 );
    echo abcfl_input_hline('2');
    abcfl_input_sec_icon_hdr_hlp( ABCFRGGCL_ICONS_URL, 'item-container.png', abcfrggcl_txta(65), '', abcfrggcl_aurl(0) );

    echo abcfl_input_cbo_strings('itemPadLR', '', $cboItemPadLR, $itemPadLR, abcfrggcl_txta_r(39), '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_cbo_strings('itemMarginB', '', $cboItemMB, $itemMarginB, abcfrggcl_txta_r(25), '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');

    abcfrggcl_autil_class_and_style( 'itemCls', $itemCls, 'itemStyle', $itemStyle, '', false, '1' );
    //abcfrggcl_mbox_gallery_layout_style_and_class( 'itemCls', $itemCls, 'itemStyle', $itemStyle);

    echo abcfl_input_cbo_strings('vAid', '',$cboYN, $vAid, abcfrggcl_txta(64), abcfrggcl_txta(202), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Image Style.
function abcfrggcl_mbox_gallery_layout_img_cntr( $imgCls, $imgStyle ){

    //abcfrggcl_mbox_gallery_layout_section_hdr( 'image-container.png', 43, 0 );
    echo abcfl_input_hline('2');
    abcfl_input_sec_icon_hdr_hlp( ABCFRGGCL_ICONS_URL, 'image-container.png', abcfrggcl_txta(43), '', abcfrggcl_aurl(0) );

    abcfrggcl_autil_class_and_style( 'imgCls', $imgCls, 'imgStyle', $imgStyle, '', false, '' );
    //abcfrggcl_mbox_gallery_layout_style_and_class( 'imgCls', $imgCls, 'imgStyle', $imgStyle, 234);
}

//Text Container Style.
function abcfrggcl_mbox_gallery_layout_txt_cntr( $txtCntrCls, $txtCntrStyle, $addMaxW ){

    $cboYN = abcfrggcl_cbo_yn();
    //abcfrggcl_mbox_gallery_layout_section_hdr( 'text-container.png', 67, 0 );
    echo abcfl_input_hline('2');
    abcfl_input_sec_icon_hdr_hlp( ABCFRGGCL_ICONS_URL, 'text-container.png', abcfrggcl_txta(67), '', abcfrggcl_aurl(0) );

    echo abcfl_input_cbo_strings('addMaxW', '',$cboYN, $addMaxW, abcfrggcl_txta(68), abcfrggcl_txta(233), '50%',  '', '', 'abcflFldCntr', 'abcflFldLbl');

    abcfrggcl_autil_class_and_style( 'txtCntrCls', $txtCntrCls, 'txtCntrStyle', $txtCntrStyle, '', false, '' );
    //abcfrggcl_mbox_gallery_layout_style_and_class( 'txtCntrCls', $txtCntrCls, 'txtCntrStyle', $txtCntrStyle, 224);
}

//Gallery main container style
function abcfrggcl_mbox_gallery_layout_gallery_cntr( $gCntrW, $gCntrCls, $gCntrStyle, $gCntrCenter ){

    //abcfrggcl_mbox_gallery_layout_section_hdr( 'gallery-container.png', 66, 0 );
    echo abcfl_input_hline('2');
    abcfl_input_sec_icon_hdr_hlp( ABCFRGGCL_ICONS_URL, 'gallery-container.png', abcfrggcl_txta(66), '', abcfrggcl_aurl(0) );

    echo abcfl_input_txt('gCntrW', '', $gCntrW, abcfrggcl_txta(14), abcfrggcl_txta(218), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    abcfrggcl_mbox_gallery_layout_center_yn( $gCntrCenter );
    //echo abcfl_input_info_lbl(abcfrggcl_txta(241), '', 12);

    abcfrggcl_autil_class_and_style( 'gCntrCls', $gCntrCls, 'gCntrStyle', $gCntrStyle, '', false, '' );
    //abcfrggcl_mbox_gallery_layout_style_and_class('gCntrCls', $gCntrCls, 'gCntrStyle', $gCntrStyle);
}

function abcfrggcl_mbox_gallery_layout_center_yn( $gCntrCenter ){
    $cboYN = abcfrggcl_cbo_yn();
    echo abcfl_input_cbo( 'gCntrCenter', '',$cboYN, $gCntrCenter, abcfrggcl_txta(69), abcfrggcl_txta(242), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl' );
}

//==Generic Inputs ==============================================================
//Section header
function abcfrggcl_mbox_gallery_layout_section_hdr( $iconName, $lblID, $helpID, $hline = true ){

    $src = ABCFRGGCL_ICONS_URL . $iconName;

    if( $hline ){ echo abcfl_input_hline('2'); }

    echo abcfl_html_tag_cls(  'div', 'abcflPosRel', false );
    echo abcfl_html_tag( 'div', '', 'abcflFloatL abcflPTop2 abcflLineH1' );
        echo abcfl_html_img_tag('', $src, '', '');
    echo abcfl_html_tag_end('div');

    echo abcfl_html_tag( 'div', '', 'abcflFloatL abcflPLeft20' );
        echo abcfl_input_info_lbl(abcfrggcl_txta($lblID), 'abcflMTop15', 16, 'SB');
        echo abcfl_input_info_lbl(abcfrggcl_txta($helpID), 'abcflMTop5', 12, 'SB');
    echo abcfl_html_tag_end('div');

    echo abcfl_html_tag_cls(  'div', 'abcflClr', true );
    echo abcfl_html_tag_end('div');

}

//Style and Class.
//function abcfrggcl_mbox_gallery_layout_style_and_class( $clsName, $clsValue, $styleName, $styleValue, $helpCls=223, $helpStyle=224){
//    echo abcfl_input_txt($clsName, '', $clsValue, abcfrggcl_txta(51), abcfrggcl_txta($helpCls), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
//    echo abcfl_input_txt($styleName, '', $styleValue, abcfrggcl_txta(18), abcfrggcl_txta($helpStyle), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
//}

//Top margin
function abcfrggcl_mbox_gallery_layout_margin_t( $fieldName, $fielValue, $help, $lbl=15 ){
    $cboMarginTop = abcfrggcl_cbo_margin_top_bottom();
    echo abcfl_input_cbo_strings($fieldName, '', $cboMarginTop, $fielValue, abcfrggcl_txta( $lbl ), abcfrggcl_txta( $help ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}













