<?php
//Field options for a single field (F)
function abcfrggcl_mbox_gallery_field( $tplateOptns, $F ){

    //echo"<pre>", print_r($tplateOptns), "</pre>";

    //Line container
    $tagType = isset( $tplateOptns['_tagType_' . $F] ) ? esc_attr( $tplateOptns['_tagType_' . $F][0] ) : 'div';
    $tagFont = isset( $tplateOptns['_tagFont_' . $F] ) ? esc_attr( $tplateOptns['_tagFont_' . $F][0] ) : 'D';
    $tagMarginT = isset( $tplateOptns['_tagMarginT_' . $F] ) ? esc_attr( $tplateOptns['_tagMarginT_' . $F][0] ) : 'N';
    $tagCls = isset( $tplateOptns['_tagCls_' . $F] ) ? esc_attr( $tplateOptns['_tagCls_' . $F][0] ) : '';
    $tagStyle = isset( $tplateOptns['_tagStyle_' . $F] ) ? esc_attr( $tplateOptns['_tagStyle_' . $F][0] ) : '';

    //Input field label & description
    $inputLbl = isset( $tplateOptns['_inputLbl_' . $F] ) ? esc_attr( $tplateOptns['_inputLbl_' . $F][0] ) : '';
    $inputHlp = isset( $tplateOptns['_inputHlp_' . $F] ) ? esc_attr( $tplateOptns['_inputHlp_' . $F][0] ) : '';

    echo abcfrggcl_mbox_gallery_field_section_hdr( 3, 226, false );
    abcfrggcl_mbox_gallery_field_input_field_name(  $inputLbl, $inputHlp, $F, 48, 209, 49, 220, 0, 'inputLbl_', 'inputHlp_' );

    echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(357), abcfrggcl_aurl(0), 'abcflFontWPHdr abcflFontS14 abcflFontW600 abcflMTop10' );
    //------------------------------------------------
    echo abcfrggcl_mbox_gallery_field_section_hdr( 0, 213 );
    abcfrggcl_mbox_gallery_field_field_cntr_type( $tagType, $F, 'tagType_' );
    abcfrggcl_mbox_gallery_field_font( 'tagFont_', $tagFont, $F );
    abcfrggcl_mbox_gallery_field_margin_t( 'tagMarginT_', $tagMarginT, $F );
    //------------------------------------------------
    abcfrggcl_autil_class_and_style( 'tagCls_', $tagCls, 'tagStyle_', $tagStyle, $F, false, '1' );
}

//=====================================================================
//Section header + optional help link (?)
function abcfrggcl_mbox_gallery_field_section_hdr( $aurl, $txta, $hline=true){
    if( $hline ) { echo abcfl_input_hline('2', '20'); }
    echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta($txta), abcfrggcl_aurl($aurl) );
}

//== FIELDS =========================================================================================
//Field container type
function abcfrggcl_mbox_gallery_field_field_cntr_type( $tagType, $F, $typeL='tagType_'){

    $cboTxtCntr = abcfrggcl_cbo_txt_cntr();
    echo abcfl_input_cbo_strings($typeL . $F, '',$cboTxtCntr, $tagType, abcfrggcl_txta_r(37), abcfrggcl_txta(211), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Input field name and help
function abcfrggcl_mbox_gallery_field_input_field_name(   $inputLbl, $inputHlp, $F, $name1, $help1, $name2, $help2, $name3, $lbl='inputLbl_', $hlp='inputHlp_'){

    echo abcfl_input_txt($lbl . $F, '', $inputLbl, abcfrggcl_txta_r($name1), abcfrggcl_txta($help1), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
    echo abcfl_input_info_lbl(abcfrggcl_txta($name3), '');

    echo abcfl_input_txt($hlp . $F, '', $inputHlp, abcfrggcl_txta($name2), abcfrggcl_txta($help2), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//-------------------------------------------------
//Fonts
function abcfrggcl_mbox_gallery_field_font( $fieldName, $fielValue, $F, $help=207, $lbl=47 ){

    $cboFont = abcfrggcl_cbo_font_size();
    echo abcfl_input_cbo_strings($fieldName . $F, '', $cboFont, $fielValue, abcfrggcl_txta_r( $lbl), abcfrggcl_txta( $help ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

//Top margin.
function abcfrggcl_mbox_gallery_field_margin_t( $fieldName, $fielValue, $F, $help=0, $lbl=15 ){

    $cboMarginTop = abcfrggcl_cbo_margin_top_field();
    echo abcfl_input_cbo_strings($fieldName . $F, '', $cboMarginTop, $fielValue, abcfrggcl_txta_r( $lbl), abcfrggcl_txta( $help ), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}
