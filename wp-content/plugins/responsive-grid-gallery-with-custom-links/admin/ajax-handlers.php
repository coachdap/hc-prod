<?php
add_action( 'wp_ajax_update_grid_items_order', 'abcfrggcl_ajax_update_grid_items_order' );

function abcfrggcl_ajax_update_grid_items_order() {

    if(!$_POST){
        $out = array( 'error' => true, 'error_msg' => 'Error: POST is missing.');
        wp_send_json( $out );
        die();
    }

    $ajaxNonce = isset($_POST['abcfajaxnonce']) ? $_POST['abcfajaxnonce'] : '';
    if ( ! wp_verify_nonce( $ajaxNonce, 'abcfnonce' ) ){
        $out = array( 'error' => true, 'msg' => 'Error: Permissions check failed');
        //echo $out;
        wp_send_json( $out );
        die();
    }

    $defaults = array( 'order' => array('post_0') );
    $post = wp_parse_args( $_POST, $defaults );
    $order = $post['order'];

    if($order[0] == 'post_0'){
        $out = array( 'error' => true, 'error_msg' => 'Error: Order is missing.');
        wp_send_json( $out );
        die();
    }

    $postID = 0;
    $menuOrder = 0;

    foreach( $order as $post_id ) {
        $postID  = intval( str_ireplace( 'item_', '', $post_id ) );
        $menuOrder ++;
        wp_update_post( array( 'ID' => $postID, 'menu_order' => $menuOrder ) );
    }

    die();
}