<?php
function abcfrggcl_mbox_gallery_css( $tplateOptns ){

//echo"<pre>", print_r($tplateOptns), "</pre>"; die;

  echo  abcfl_html_tag('div','','inside');

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

    abcfrggcl_mbox_gallery_css_columns_cntr( $gridCols );
    abcfrggcl_mbox_gallery_css_grid_item_cntr( $itemPadLR,  $itemMarginB, $itemCls, $itemStyle, $vAid );
    abcfrggcl_mbox_gallery_css_img_cntr( $imgCls, $imgStyle );
    abcfrggcl_mbox_gallery_css_txt_cntr( $txtCntrCls, $txtCntrStyle, $addMaxW );
    abcfrggcl_mbox_gallery_css_gallery_cntr( $gCntrW, $gCntrCls, $gCntrStyle, $gCntrCenter );

    echo abcfl_html_tag_end('div');
}
//===============================================================================221
//Number of columns
function abcfrggcl_mbox_gallery_css_columns_cntr( $gridCols ){
    $cboCols = abcfrggcl_cbo_grid_columns();
    echo abcfl_input_cbo_strings('gridCols', '',$cboCols, $gridCols, abcfrggcl_txta_reqired(16, '', true), '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Gallery Item style.
function abcfrggcl_mbox_gallery_css_grid_item_cntr( $itemPadLR, $itemMarginB, $itemCls, $itemStyle, $vAid ){

    $cboItemMB = abcfrggcl_cbo_margin_top_bottom();
    $cboItemPadLR = abcfrggcl_cbo_pad_lr();
    $cboYN = abcfrggcl_cbo_yn();

    abcfrggcl_mbox_gallery_css_section_hdr( 'item-container.png', 65, 0 );

    echo abcfl_input_cbo_strings('itemPadLR', '', $cboItemPadLR, $itemPadLR, abcfrggcl_txta_reqired(39, '', true), '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_cbo_strings('itemMarginB', '', $cboItemMB, $itemMarginB, abcfrggcl_txta_reqired(25, '', true), '', '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    abcfrggcl_mbox_gallery_css_style_and_class( 'itemCls', $itemCls, 'itemStyle', $itemStyle);

    echo abcfl_input_cbo_strings('vAid', '',$cboYN, $vAid, abcfrggcl_txta(64), abcfrggcl_txta(202), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Image Style.
function abcfrggcl_mbox_gallery_css_img_cntr( $imgCls, $imgStyle ){

    abcfrggcl_mbox_gallery_css_section_hdr( 'image-container.png', 43, 0 );
    abcfrggcl_mbox_gallery_css_style_and_class( 'imgCls', $imgCls, 'imgStyle', $imgStyle, 234);
}

//Text Container Style.
function abcfrggcl_mbox_gallery_css_txt_cntr( $txtCntrCls, $txtCntrStyle, $addMaxW ){

    $cboYN = abcfrggcl_cbo_yn();
    abcfrggcl_mbox_gallery_css_section_hdr( 'text-container.png', 67, 0 );
    echo abcfl_input_cbo_strings('addMaxW', '',$cboYN, $addMaxW, abcfrggcl_txta(68), abcfrggcl_txta(233), '50%',  '', '', 'abcflFldCntr', 'abcflFldLbl');
    abcfrggcl_mbox_gallery_css_style_and_class( 'txtCntrCls', $txtCntrCls, 'txtCntrStyle', $txtCntrStyle, 224);
}

//Gallery main container style
function abcfrggcl_mbox_gallery_css_gallery_cntr( $gCntrW, $gCntrCls, $gCntrStyle, $gCntrCenter ){

    abcfrggcl_mbox_gallery_css_section_hdr( 'gallery-container.png', 66, 0 );
    echo abcfl_input_txt('gCntrW', '', $gCntrW, abcfrggcl_txta(14), abcfrggcl_txta(218), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    abcfrggcl_mbox_gallery_css_center_yn( $gCntrCenter );
    //echo abcfl_input_info_lbl(abcfrggcl_txta(241), '', 12);

    abcfrggcl_mbox_gallery_css_style_and_class('gCntrCls', $gCntrCls, 'gCntrStyle', $gCntrStyle);
}

function abcfrggcl_mbox_gallery_css_center_yn( $gCntrCenter ){
    $cboYN = abcfrggcl_cbo_yn();
    echo abcfl_input_cbo( 'gCntrCenter', '',$cboYN, $gCntrCenter, abcfrggcl_txta(69), abcfrggcl_txta(242), '50%', true, '', '', 'abcflFldCntr', 'abcflFldLbl' );
}

//==Generic Inputs ==============================================================
//Section header
function abcfrggcl_mbox_gallery_css_section_hdr( $iconName, $lblID, $helpID, $hline = true ){

    $src = ABCFRGGCL_PLUGIN_URL . '/images/' . $iconName;

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
function abcfrggcl_mbox_gallery_css_style_and_class( $clsName, $clsValue, $styleName, $styleValue, $helpCls=223, $helpStyle=224){
    echo abcfl_input_txt($clsName, '', $clsValue, abcfrggcl_txta(51), abcfrggcl_txta($helpCls), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_txt($styleName, '', $styleValue, abcfrggcl_txta(18), abcfrggcl_txta($helpStyle), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Top margin
function abcfrggcl_mbox_gallery_css_margin_t( $fieldName, $fielValue, $help, $lbl=15 ){
    $cboMarginTop = abcfrggcl_cbo_margin_top_bottom();
    echo abcfl_input_cbo_strings($fieldName, '', $cboMarginTop, $fielValue, abcfrggcl_txta( $lbl ), abcfrggcl_txta( $help ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}













