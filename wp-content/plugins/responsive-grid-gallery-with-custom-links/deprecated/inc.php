<?php
//Set max-width of text container.to width of the image.
function abcfrggcl_grid_item_txt_cntr_max_w_OLD( $imgID, $imgUrl, $addMaxW, $pfix ){

    $maxWCntr['cntrS'] = '';
    $maxWCntr['cntrE'] = '';

    if($addMaxW != 'Y') { return $maxWCntr; }
    if(empty($imgUrl)){ return $maxWCntr; }
    if($imgID == 0){ return $maxWCntr; }

    $imgWH = abcfrggcl_util_img_wh( $imgID, $imgUrl );
    if( !$imgWH['ok'] ){ return $maxWCntr; }

    $cssMaxW = abcfl_css_w($imgWH['w'], true);

    $maxWCntr['cntrS'] = abcfl_html_tag( 'div', '', $pfix . 'MLRAuto', $cssMaxW );
    $maxWCntr['cntrE'] = abcfl_html_tag_end( 'div' );

    return $maxWCntr;
}

//Replaced with image.php
function abcfrggcl_util_img_wh( $imgID, $imgUrl ){

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
    $imgWH = abcfrggcl_util_large_img_wh( $metaArray, $filename );
    if($imgWH['ok']){ return $imgWH; }

    //Check if array has 'sizes' array
    if(!array_key_exists('sizes', $metaArray)) { return $imgWH; }

    $sizes = $metaArray['sizes'];

//echo"<pre>", print_r($large), "</pre>";  die;
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

function abcfrggcl_util_large_img_wh( $metaArray, $filename ){

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
        if($imgWH['w'] > 0 && $imgWH['h'] > 0) { $imgWH['OK'] = true; }
    }
    return $imgWH;
}

