<?php

function abcfrggcl_img_tag( $tplateOptns, $itemOptns, $pfix ){

    $imgUrl = isset( $itemOptns['_imgUrl'] ) ? esc_attr( $itemOptns['_imgUrl'][0] ) : '';
    $imgID = isset( $itemOptns['_imgID'] ) ? esc_attr( $itemOptns['_imgID'][0] ) : 0;
    //$imgTitle = isset( $itemOptns['_imgTitle'] ) ? esc_attr( $itemOptns['_imgTitle'][0] ) : '';
    $imgAlt = isset( $itemOptns['_imgAlt'] ) ? esc_attr( $itemOptns['_imgAlt'][0] ) : '';

    //----------------------------
    $imgBorderCls = abcfrggcl_util_cls_name_nc_bldr( isset( $tplateOptns['_imgBorder'] ) ? esc_attr( $tplateOptns['_imgBorder'][0] ) : 'D', 'ImgBorder', $pfix );
    $imgCls = isset( $tplateOptns['_imgCls'] ) ? esc_attr( $tplateOptns['_imgCls'][0] ) : $pfix . 'ImgCenter';
    $imgStyle = isset( $tplateOptns['_imgStyle'] ) ? esc_attr( $tplateOptns['_imgStyle'][0] ) : '';

    $imgHover = isset( $tplateOptns['_imgHover'] ) ? $tplateOptns['_imgHover'][0]  : '';
    $imgDS =  abcfrggcl_util_cls_bldr( isset( $tplateOptns['_imgDS'] ) ? $tplateOptns['_imgDS'][0] : '', $pfix );

    //Custom classes and style are added to an image tag not an image container.
    $fluid = '';
    if( $imgHover == 'overlay' ){ $fluid = $pfix . 'ImgFluid '; }
    $imgClasses = trim( $fluid . $imgBorderCls . ' ' . $imgDS. ' ' . $imgCls );
    //-------------------------

    $alt = abcfrggcl_img_alt( $imgID, $imgUrl, $imgAlt );
    //$title = abcfrggcl_img_title( $imgID, $imgUrl, $imgTitle );

    $imgTag = abcfl_html_img_tag_resp( '', $imgUrl, $alt, '', $imgClasses, $imgStyle );
    return $imgTag;
}
//== ALT, TITLE START =======================================
function abcfrggcl_img_alt( $imgID, $imgUrl, $imgAlt ){

    if( !empty( $imgAlt ) ){
        switch ($imgAlt) {
            case 'NONE':
                return '';
            case 'LIB':
                break;
            default:
                return $imgAlt;
        }
    }

    if( $imgID > 0 ){ return get_post_meta( $imgID, '_wp_attachment_image_alt', true ); }

    $imgID = abcfrggcl_img_id_by_url( $imgUrl );
    if( $imgID > 0 ){ return get_post_meta( $imgID, '_wp_attachment_image_alt', true ); }

    return '';
}

//== ALT, TITLE END =======================================

//== IMAGE WxH START =================================
function abcfrggcl_img_wh( $imgID, $imgUrl ){

    $filename = basename($imgUrl);
    $meta = '';
    $imgWH['w'] = 0;
    $imgWH['h'] = 0;
    $imgWH['ok'] = false;

    if($imgID > 0){ $meta = get_post_meta($imgID, '_wp_attachment_metadata'); }
    if(empty( $meta )) { return $imgWH; }

    $metaArray = isset( $meta ) ?  $meta[0] : '';
    if(empty($metaArray)) { return $imgWH; }

    //Check original image (stored in different part of the array than other sizes. return sizes if image is an original
    $imgWH = abcfrggcl_img_large_wh( $metaArray, $filename );
    if($imgWH['ok']){ return $imgWH; }

    //Check if array has 'sizes' array
    if(!array_key_exists('sizes', $metaArray)) { return $imgWH; }

    $sizes = $metaArray['sizes'];

    $defaults = array( 'file' => '', 'width' => '0', 'height' => '0' );
    foreach ( $sizes as $size ) {
        $sizeFixed = shortcode_atts( $defaults, $size );

        $sizeFile = $sizeFixed['file'];
        if($sizeFile == $filename){
            $imgWH['w'] = $sizeFixed['width'];
            $imgWH['h'] = $sizeFixed['height'];
            if($imgWH['w'] > 0 && $imgWH['h'] > 0) { $imgWH['ok'] = true; }
            break;
        }
    }
    return $imgWH;
}

function abcfrggcl_img_large_wh( $metaArray, $filename ){

    $imgWH['w'] = 0;
    $imgWH['h'] = 0;
    $imgWH['ok'] = false;

    $defaults = array( 'file' => '', 'width' => '0', 'height' => '0' );
    $meta = shortcode_atts( $defaults, $metaArray );

    //File can have folders prefixes: 2015/12/image.jpg
    $large =  basename($meta['file']);

    if( $large == $filename){
        $imgWH['w'] = $meta['width'];
        $imgWH['h'] = $meta['height'];
        if($imgWH['w'] > 0 && $imgWH['h'] > 0) { $imgWH['ok'] = true; }
    }
    return $imgWH;
}
//== IMAGE WxH END =================================

//== IMAGE ID START =================================
function abcfrggcl_img_id_by_url( $imgUrl ){

    if( empty( $imgUrl ) ) { return 0; }

    $imageID = abcfrggcl_img_id_by_guid( $imgUrl );
    if( $imageID > 0 ) { return $imageID; }

    $imageID = abcfrggcl_img_attachment_url_to_postid( $imgUrl );
    if( $imageID > 0 ) { return $imageID; }

    $imageID = abcfrggcl_img_relative( $imgUrl );
    if( $imageID > 0 ) { return $imageID; }

    return 0;
}

function abcfrggcl_img_id_by_guid( $imgUrl ){

    if( empty( $imgUrl ) ) { return 0; }

    global $wpdb;
    $imageID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $imgUrl ));
    if( !empty( $imageID ) ) { return $imageID; }

    // If the URL is auto-generated thumbnail, remove the sizes and get the URL of the original image
    $url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $imgUrl );
    $imageID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ));
    if( !empty( $imageID ) ) { return $imageID; }

    return 0;
}

function abcfrggcl_img_attachment_url_to_postid( $imgUrl ) {

    //Return (int). The found post ID, or 0 on failure.
    $imageID = attachment_url_to_postid( $imgUrl );
    if( $imageID > 0 ) { return $imageID; }

    $url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $imgUrl );
    return attachment_url_to_postid( $url );
}

//abcfrggcl_img_relative
function abcfrggcl_img_relative( $imgUrl ) {

    //http://localhost:8080/blog
    $siteURL = get_site_url();

    $url = ltrim( $imgUrl, '/\\' );

    $fullURL = trailingslashit( $siteURL ) . $url;

    $imageID = abcfrggcl_img_attachment_url_to_postid( $fullURL );
    return $imageID;
}

//== IMAGE ID END =================================