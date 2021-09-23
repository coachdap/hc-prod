<?php
function abcfrggcl_mbox_item_order( $tplateID ) {

    echo  abcfl_html_tag('div','GO2','inside hidden abcflFadeIn');

        $dbRows = abcfrggcl_dba_items_for_order($tplateID);
        if ($dbRows) {
            //echo abcfl_input_info_lbl(abcfrggcl_txta(217), 'abcflMTop15', 14, 'SB');
            echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(217), abcfrggcl_aurl(0) );

            abcfrggcl_mbox_item_order_render_cntr($dbRows);
        }
        else{
            echo abcfl_input_info_lbl(abcfrggcl_txta(225), 'abcflMTop15 abcflGreen', 14, 'SB');
        }

    echo abcfl_html_tag_end('div');
}

function abcfrggcl_mbox_item_order_render_cntr($dbRows) {

    echo  abcfl_html_tag('div', '', 'wrap wrapSort');
        echo abcfl_html_tag( 'table', 'sort-items-tbl', 'wp-list-table widefat striped' );
        echo abcfl_html_tag( 'tbody', '' );
            foreach ( $dbRows as $dbRow ) { abcfrggcl_mbox_item_order_get_item($dbRow->ID, $dbRow->post_title, $dbRow->menu_order ); }
        echo abcfl_html_tag_ends( 'tbody,table' );
    echo abcfl_html_tag_end( 'div' );
}

function abcfrggcl_mbox_item_order_get_item($tplateID, $postTitle, $menuOrder){

    $optns = get_post_custom($tplateID);

    $imgUrl = isset( $optns['_imgUrl'] ) ? esc_attr( $optns['_imgUrl'][0] ) : '';
    //if(!empty($imgUrl)){ $imgUrl = ABCFRGGCL_PLUGIN_URL . $imgUrl; }

    echo abcfl_html_tag( 'tr', 'item_' . $tplateID );

    echo abcfl_html_tag( 'td', '', 'column-order', 'width: 60px;' );
    echo abcfl_html_img_tag('', ABCFRGGCL_ICONS_URL . 'move-icon.png', 'Move Icon', '', 24, 24);
    echo abcfl_html_tag_end( 'td' );

    echo abcfl_html_tag( 'td', '', 'column-photo' );
    echo abcfl_html_img_tag('', $imgUrl, '', '', 0, 60);
    echo abcfl_html_tag_end( 'td' );

    echo abcfl_html_tag( 'td', '', 'column-name' );
    echo $postTitle;
    echo abcfl_html_tag_end( 'td' );

    echo abcfl_html_tag( 'td', '', 'menu-order' );
    echo $menuOrder;
    echo abcfl_html_tag_ends( 'td,tr' );

}


