<?php
function abcfrggcl_v_tabs_render_nav_tab( $fieldNo, $fieldLbl, $liCls='' ){

    $out = abcfl_html_tag( 'li', $fieldNo, $liCls );
    $out .= abcfl_html_a_tag( '#', $fieldLbl, '', '' );
    $out .= abcfl_html_tag_end( 'li' );
    
    return $out;
}