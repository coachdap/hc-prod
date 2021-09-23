<?php
//== FROM PRO START ==========================================

//== LINKS START =========================================
//Get href parts: url + link text. Check for 'IL' and NT strings.
function abcfrggcl_util_txt_lnk_optns( $itemOptns, $F ){

    $imgLnk = isset( $itemOptns['_imgLnk'] ) ? esc_attr( $itemOptns['_imgLnk'][0] ) : '';
    $url = isset( $itemOptns['_url_' . $F] ) ? esc_attr( $itemOptns['_url_' . $F][0] ) : '';
    $urlTxt = isset( $itemOptns['_urlTxt_' . $F] ) ? esc_attr( $itemOptns['_urlTxt_' . $F][0] ) : '';
    $imgLnkClick = isset( $itemOptns['_imgLnkClick'] ) ? esc_attr( $itemOptns['_imgLnkClick'][0] ) : '';
    $imgLnkArgs = isset( $itemOptns['_imgLnkArgs'] ) ? esc_attr( $itemOptns['_imgLnkArgs'][0] ) : '';

    $lnk['target'] = '';
    $lnk['txt'] = $urlTxt;
    $lnk['href'] = $urlTxt;
    $lnk['onclick'] = abcfrggcl_util_lnk_onclick( $imgLnkClick );
    $lnk['args'] = abcfrggcl_util_lnk_args( $imgLnkArgs );

    if( $url == 'IL' ) {
        $out = abcfrggcl_util_lnk_target( $imgLnk );
        $lnk['href'] = $out['href'];
        $lnk['target'] = $out['target'];
    }
    else {
        $out = abcfrggcl_util_lnk_target( $url );
        $lnk['href'] = $out['href'];
        $lnk['target'] = $out['target'];
    }

    if( abcfl_html_isblank( $urlTxt ) ) { $lnk['txt'] = $lnk['href']; }

    return $lnk;
}

function abcfrggcl_util_img_lnk_optns( $itemOptns ){

    $imgID = isset( $itemOptns['_imgID'] ) ? esc_attr( $itemOptns['_imgID'][0] ) : 0;
    $imgLnkClick = isset( $itemOptns['_imgLnkClick'] ) ? esc_attr( $itemOptns['_imgLnkClick'][0] ) : '';
    $imgLnk = isset( $itemOptns['_imgLnk'] ) ? esc_attr( $itemOptns['_imgLnk'][0] ) : '';
    $imgLnkArgs = isset( $itemOptns['_imgLnkArgs'] ) ? esc_attr( $itemOptns['_imgLnkArgs'][0] ) : '';

    $ht = abcfrggcl_util_lnk_target( $imgLnk );

    $lnkOptns['id'] = abcfrggcl_util_img_lnk_id( $imgID );
    $lnkOptns['href'] = $ht['href'];
    $lnkOptns['target'] = $ht['target'];
    $lnkOptns['onclick'] = abcfrggcl_util_lnk_onclick( $imgLnkClick );
    $lnkOptns['args'] = abcfrggcl_util_lnk_args( $imgLnkArgs );

    return $lnkOptns;
}

//Check for NT new tab.
function abcfrggcl_util_lnk_target( $linkIn ){

    $out['href'] = $linkIn;
    $out['target'] = '';

    $targetNT = substr( $linkIn, 0, 2 );
    if( $targetNT == 'NT' ) {
        $out['href'] = trim( substr( $linkIn, 2 ) );
        $out['target'] = '_blank';
    }
    return $out;
}

function abcfrggcl_util_lnk_onclick( $imgLnkClick ){
    //Check mix of dounle and single quotes. Return empty if true;
    //replace double quotes with single ones
    return $imgLnkClick;
}

function abcfrggcl_util_lnk_args( $lnkArgs ){

    //Convert HTML entities to characters. Double quotes only;
    if(!empty($lnkArgs)){ $lnkArgs = html_entity_decode($lnkArgs, ENT_COMPAT); }
    return $lnkArgs;
}

function abcfrggcl_util_img_lnk_id( $imgID ){
    if( $imgID == 0 ) { return '';}
    return $imgID;
}

function abcfrggcl_util_img_title( $imgTitle ){
    return $imgTitle;
}

//function abcfrggcl_util_img_alt( $imgID ){
//
//    $imgMeta = '';
//    if($imgID > 0){ $imgMeta = get_post_meta($imgID, '_wp_attachment_image_alt', true); }
//
//    return $imgMeta;
//}
//== LINKS END =========================================

//Generic DIV container.
function abcfrggcl_util_generic_div( $pfix, $baseCls, $customCls, $customStyle, $divID, $vaAidCls='' ){

    $cntrCls = abcfrggcl_util_class_bldr( $pfix, $baseCls, $customCls, $vaAidCls  );

    $div['cntrS'] = abcfl_html_tag( 'div', $divID, $cntrCls, $customStyle );
    $div['cntrE'] = abcfl_html_tag_end( 'div');

    return $div;
}

//Return class name or empty string. Useg for cbos Class: None, Custom or Selected.
function abcfrggcl_util_cls_name_nc_bldr( $optnValue, $clsBaseName, $pfix, $default='' ){

    if( $optnValue == 'N' || $optnValue == 'C'|| $optnValue == 'D' ){ return ''; }
    if( empty( $optnValue ) ) { $optnValue = $default; }
    if( empty( $optnValue) ) { return ''; }
    return $pfix . $clsBaseName . $optnValue;
}

//Pro  ???????
function abcfrggcl_util_cls_bldr( $cls, $pfix ){

    if( empty( $cls) ) { return ''; }
    return $pfix . $cls;
}

//Returns classes
function abcfrggcl_util_class_bldr( $pfix, $baseCls, $customCls, $vaAidCls ){

    $cntrBaseCls = '';
    if( !empty( $baseCls ) ){ $cntrBaseCls = $pfix . $baseCls; }
    if( !empty( $vaAidCls ) ){ $vaAidCls = ' ' . $pfix . $vaAidCls; }

    return  trim( $cntrBaseCls . ' ' . $customCls . $vaAidCls );
}

function abcfrggcl_util_center_cls( $centerYN, $pfix ){
    $out = '';
    if( $centerYN == 'Y' ) { $out = ' ' . $pfix . 'MLRAuto'; }
    return $out;
}

//== FROM PRO END ==========================================

function abcfrggcl_util_img_alt( $imgID ){

    $imgMeta = '';
    if($imgID > 0){ $imgMeta = get_post_meta($imgID, '_wp_attachment_image_alt', true); }

    return $imgMeta;
}



//== URL START ================================
function abcfrggcl_util_img_lnk_href( $imgLnk ){

    $href['target'] = '';
    $href['hrefUrl'] = $imgLnk;

    $targetNT = substr($imgLnk, 0, 2);

    if( $targetNT == 'NT' ) {
        $imgLnk = trim( substr( $imgLnk, 2 ) );
        $href['target'] = '_blank';
        $href['hrefUrl'] = $imgLnk;
    }

    return $href;
}
//== URL END ===========================================

