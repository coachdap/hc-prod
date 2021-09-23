<?php
/**
 * Process shortcode
*/
if ( ! defined( 'ABSPATH' ) ) {exit;}

//Add a hook for a shortcode tag.
//1.Shortcode tag to be searched in post content.
//2-Functio to run when shortcode is found.
add_shortcode( 'abcf-grid-gallery-custom-links', 'abcfrggcl_scode_grid_gallery' );

//Render page - Grid Gallery.
function abcfrggcl_scode_grid_gallery( $scodeArgs ) {

    $args = shortcode_atts( abcfrggcl_scode_defaults(), $scodeArgs );
    return abcfrggcl_grid( $args );
}

function abcfrggcl_scode_defaults() {

    $obj = ABCFRGGCL_Main();
    $ver = str_replace('.', '' , $obj->pluginVersion);
    $prefix = $obj->prefix;

    return array( 'id' => '0', 'pversion' => $ver, 'prefix' => $prefix );
}

//---------------------------------------------------------------------------------
//Shortcode builder used by shorcode metabox.
function abcfrggcl_scode_build_scode( $esc = true ) {

    global $post;
    $listID = $post->ID;

    $scode = '[abcf-grid-gallery-custom-links' . ' id="' . $listID . '"]';

    if($esc){
        $scode = esc_attr( $scode );
    }
    return $scode;
}