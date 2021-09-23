<?php

function abcfrggcl_mbox_gallery_tabs(){

    $obj = ABCFRGGCL_Main();
    $slug = $obj->pluginSlug;
    $clsPfix = $obj->prefix;

    //abcfrggcl_v_tabs_manager_div_s( '1' ); //---Manager START
    echo abcfl_html_tag( 'div', 'rggclVtGOptnsWrapID', 'abcflVTabsMgr' );
        abcfrggcl_mbox_gallery_tabs_render_nav_tabs();
        abcfrggcl_mbox_gallery_tabs_render_cnt( $clsPfix );
    echo abcfl_html_tag_end( 'div' ); //---Manager END

    wp_nonce_field( $slug, $slug . '_nonce' );
}

function abcfrggcl_mbox_gallery_tabs_render_nav_tabs(){

    echo abcfl_html_tag( 'ul', '', 'abcflVTabsNavCntr' );
        echo abcfrggcl_v_tabs_render_nav_tab( 'GO1', abcfrggcl_txta(13), 'abcflVTabsTabActive' );
        echo abcfrggcl_v_tabs_render_nav_tab( 'GO2', abcfrggcl_txta(45) );
        echo abcfrggcl_v_tabs_render_nav_tab( 'GO3', abcfrggcl_txta(3) );
    echo abcfl_html_tag_end( 'ul' );
}

function abcfrggcl_mbox_gallery_tabs_render_cnt( $clsPfix ){

    global $post;
    $tplateID = $post->ID;
    $tplateOptns = get_post_custom( $tplateID );

    //echo abcfl_html_tag( 'div', 'abcfrggcl_VTabsCntCntr_1', 'abcflVTabsCntCntr' ); //---Content START
    echo abcfl_html_tag( 'div', 'rggclVtGOptnsCntCntrID', 'abcflVTabsCntCntr' ); //---Content START    
        abcfrggcl_mbox_gallery_layout( $tplateOptns );
        abcfrggcl_mbox_item_order( $tplateID );
        abcfrggcl_mbox_gallery_shortcode();
    echo abcfl_html_tag_end( 'div' ); //---Content END

}

// function abcfrggcl_mbox_gallery_tabs_render_nav_tabs( ){

//     echo abcfl_html_tag( 'ul', '', 'abcflVTabsNavCntr' );
//         echo abcfrggcl_v_tabs_render_nav_tab( 'abcflVTabsTabActive', abcfrggcl_txta(13) );
//         echo abcfrggcl_v_tabs_render_nav_tab( '', abcfrggcl_txta(45) );
//         echo abcfrggcl_v_tabs_render_nav_tab( '', abcfrggcl_txta(3) );
//     echo abcfl_html_tag_end( 'ul' );
// }