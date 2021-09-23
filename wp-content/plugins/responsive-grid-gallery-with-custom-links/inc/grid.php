<?php
/*
 * Render GRID container + content.
 * Called from a shortcode
 */
function abcfrggcl_grid( $scodeArgs ){

    $pfix = $scodeArgs['prefix'];
    $pversion = $scodeArgs['pversion'];
    $tplateID = $scodeArgs['id'];
    $tplateOptns = get_post_custom( $tplateID );

    $gCntrW = isset( $tplateOptns['_gCntrW'] ) ? esc_attr( $tplateOptns['_gCntrW'][0] ) : '';
    $gCntrCenter = isset( $tplateOptns['_gCntrCenter'] ) ? esc_attr( $tplateOptns['_gCntrCenter'][0] ) : 'N';
    $gCntrCls = isset( $tplateOptns['_gCntrCls'] ) ? esc_attr( $tplateOptns['_gCntrCls'][0] ) : '';
    $gCntrStyle = isset( $tplateOptns['_gCntrStyle'] ) ? esc_attr( $tplateOptns['_gCntrStyle'][0] ) : '';

    //If no custom class, returns default: ImgCenter
    $imgCls = isset( $tplateOptns['_imgCls'] ) ? esc_attr( $tplateOptns['_imgCls'][0] ) : $pfix . 'ImgCenter';
    $tplateOptns['_imgCls'] = array($imgCls);


    $vAid = isset( $tplateOptns['_vAid'] ) ? esc_attr( $tplateOptns['_vAid'][0] ) : 'N';

    $centerCls = abcfrggcl_util_center_cls( $gCntrCenter, $pfix );
    $cntrStyle = abcfl_css_w_responsive( $gCntrW, $gCntrW ) . $gCntrStyle;

    //GRID CONTAINER classes
    $gCntrCustomCls = $gCntrCls . $centerCls . ' ' . $pfix . 'v_' . $pversion;;
    $div = abcfrggcl_util_generic_div( $pfix, 'GridCntr', $gCntrCustomCls, $cntrStyle, $pfix . 'GridCntr_' . $tplateID );

    //Grid items
    $gridItems = abcfrggcl_grid_items( $tplateID, $tplateOptns, $pfix, $vAid );

    //Return Grid container + all items.
    return $div['cntrS'] . $gridItems . $div['cntrE'];
}

//GRID ITEMS. Items minus grid container.
function abcfrggcl_grid_items( $tplateID, $tplateOptns, $pfix, $vAid ){

    $itemsHTML  = '';
    $colsQty = isset( $tplateOptns['_gridCols'] ) ? esc_attr( $tplateOptns['_gridCols'][0] ) : '2';

    $itemMarginLR = isset( $tplateOptns['_itemPadLR'] ) ? esc_attr( $tplateOptns['_itemPadLR'][0] ) : 'N';
    $itemMarginB = isset( $tplateOptns['_itemMarginB'] ) ? esc_attr( $tplateOptns['_itemMarginB'][0] ) : 'N';

    $itemCls = isset( $tplateOptns['_itemCls'] ) ? esc_attr( $tplateOptns['_itemCls'][0] ) : '';
    $itemStyle = isset( $tplateOptns['_itemStyle'] ) ? esc_attr( $tplateOptns['_itemStyle'][0] ) : '';
    $addMaxW = isset( $tplateOptns['_addMaxW'] ) ? esc_attr( $tplateOptns['_addMaxW'][0] ) : 'N';

    $postIDs = abcfrggcl_db_grid_items_ids( $tplateID );

    //GRID row container
    $rowDivS = abcfl_html_tag( 'div', '', $pfix . 'GridRow ' . 'abcfClrFix', '' );
    $i = 1;
    $rowClosed = false;

    if ( $postIDs ) {
        foreach ( $postIDs as $itemID ) {
            if( $i == 1 ) { $itemsHTML .= $rowDivS; }
            $itemsHTML .= abcfrggcl_grid_item( $itemID, $tplateOptns, $itemMarginLR, $itemMarginB, $itemCls, $itemStyle, $pfix, $addMaxW, $vAid );

            //Row closing tag.
            $rowClosed = false;
            if( $i == $colsQty ) {
                $i = 0;
                $rowClosed = true;
                $itemsHTML .= '</div>';
            }
            $i++;
        }
   }
   if( !$rowClosed ) {  $itemsHTML .= '</div>'; }
   return $itemsHTML;
   
}

//ITEM CONTAINER + CONTENT.
function abcfrggcl_grid_item( $itemID, $tplateOptns, $itemMarginLR, $itemMarginB, $itemCls, $itemStyle, $pfix, $addMaxW, $vAid ){

    $colsQty = isset( $tplateOptns['_gridCols'] ) ? esc_attr( $tplateOptns['_gridCols'][0] ) : '2';

    //DIV - Item container.
    $div = abcfrggcl_grid_item_cntr_div( $colsQty, $itemMarginLR, $itemMarginB, $itemCls, $itemStyle, $pfix, $vAid);
    $itemOptns = get_post_custom( $itemID );

    $imgCntr = abcfrggcl_grid_items_image_cntr( $tplateOptns, $itemOptns, $pfix );
    $txtCntr = abcfrggcl_grid_item_txt_cntr( $itemOptns, $tplateOptns, $pfix, $vAid, $addMaxW );

    return $div['itemCntrS'] . $imgCntr . $txtCntr . $div['itemCntrE'];
}

//ITEM CONTAINER ( empty )
function abcfrggcl_grid_item_cntr_div( $colsQty, $itemMarginLR, $itemMarginB, $itemCls, $itemStyle, $pfix, $vAid ){

    $vAidCls = '';
    $customCls = '';
    if( !empty( $itemCls ) ){ $customCls = ' ' . $itemCls; }
    if( $vAid == 'Y' ) { $vAidCls = ' ' . $pfix . 'VAidBorder'; }

    $columnsCls =  $pfix . 'GridCol ' . $pfix . 'GridCol_' . $colsQty;

    //LR and Bottom margins.
    $marginsCls = rtrim(' ' . abcfrggcl_util_cls_name_nc_bldr( $itemMarginLR, 'PadLR', $pfix, '1' ) . ' ' . abcfrggcl_util_cls_name_nc_bldr( $itemMarginB, 'MB', $pfix, '40' ));

    //Item container DIV
    $div['itemCntrS'] = abcfl_html_tag( 'div', '', $columnsCls . $marginsCls . $customCls . $vAidCls, $itemStyle );
    $div['itemCntrE'] = abcfl_html_tag_end( 'div');

    return $div;
}

//TEXT SECTION CONTAINER + ALL TEXT FIELDS
function abcfrggcl_grid_item_txt_cntr( $itemOptns, $tplateOptns, $pfix, $vAid, $addMaxW ){

    $txtCntrCls = isset( $tplateOptns['_txtCntrCls'] ) ? esc_attr( $tplateOptns['_txtCntrCls'][0] ) : '';
    $txtCntrStyle = isset( $tplateOptns['_txtCntrStyle'] ) ? esc_attr( $tplateOptns['_txtCntrStyle'][0] ) : '';

    $maxWCntr['cntrS'] = '';
    $maxWCntr['cntrE'] = '';
    if( $addMaxW == 'Y' ){
        $imgUrl = isset( $itemOptns['_imgUrl'] ) ? esc_attr( $itemOptns['_imgUrl'][0] ) : '';
        $imgID = isset( $itemOptns['_imgID'] ) ? esc_attr( $itemOptns['_imgID'][0] ) : 0;
        $maxWCntr = abcfrggcl_grid_item_txt_cntr_max_w( $imgID, $imgUrl, $addMaxW, $pfix );
    }

    //print_r($maxWCntr);

    $vaAidCls = '';
    if($vAid == 'Y') { $vaAidCls = 'VAidTxt'; }

    $div = abcfrggcl_util_generic_div( $pfix, 'GridTxtCntr', $txtCntrCls, $txtCntrStyle, '', $vaAidCls );

    $itemLinesHTML = abcfrggcl_grid_items_txt_field ( $itemOptns, $tplateOptns, 'F1', $pfix );

    return $maxWCntr['cntrS'] . $div['cntrS'] . $itemLinesHTML . $div['cntrE'] . $maxWCntr['cntrE'];
}

//Set max-width of text container.to width of the image.
function abcfrggcl_grid_item_txt_cntr_max_w( $imgID, $imgUrl, $addMaxW, $clsPfix ){

    $maxWCntr['cntrS'] = '';
    $maxWCntr['cntrE'] = '';

    if($addMaxW != 'Y') { return $maxWCntr; }
    if(empty($imgUrl)){ return $maxWCntr; }
    if($imgID == 0){ return $maxWCntr; }

    $imgWH = abcfrggcl_img_wh( $imgID, $imgUrl );
    if( !$imgWH['ok'] ){ return $maxWCntr; }
    $cssMaxW = abcfl_css_w($imgWH['w'], true);

    $maxWCntr['cntrS'] = abcfl_html_tag( 'div', '', $clsPfix . 'MLRAuto', $cssMaxW );
    $maxWCntr['cntrE'] = abcfl_html_tag_end( 'div' );

    return $maxWCntr;
}

