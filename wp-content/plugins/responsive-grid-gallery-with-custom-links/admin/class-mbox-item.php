<?php
if ( ! defined( 'ABSPATH' ) ) {exit;}
class ABCFRGGCL_MBox_Item {

    public function __construct() {
        add_action( 'add_meta_boxes_cpt_rggcl_item', array( $this, 'add_meta_box' ) );
        add_action( 'save_post_cpt_rggcl_item', array( $this, 'save_post' ) );
    }

    public function add_meta_box($post) {

        add_meta_box(
            'abcfrggcl_item',
            abcfrggcl_txta(2),
            array( $this, 'display_gallery_item' ),
            $post->post_type,
            'normal',
            'default'
        );

        add_meta_box(
            'abcfrggcl_item_parent',
            abcfrggcl_txta(54),
            array( $this, 'gallery_templates_cbo' ),
            $post->post_type,
            'side',
            'core'
        );

    }
//------------------------------------------------

    public function display_gallery_item() {
        include_once( 'mbox-item.php' );
        abcfrggcl_mbox_item();
    }

    //Meta box Select Template
    public function gallery_templates_cbo( $post ) {

        $parentID = $post->post_parent;
        if( $parentID == 0 ) { $parentID = get_option( 'rggcl_default_tplate_id', 0 ); }
        $cboLists = abcfrggcl_dba_cbo_templates( abcfrggcl_txta(244) );

        echo abcfl_input_cbo_strings('parent_id', 'parent_id', $cboLists, $parentID, '', abcfrggcl_txta(229), '100%', 'widefat');
    }

    public function save_post( $postID ) {

//echo"<pre>", print_r($_POST), "</pre>";  die;        

        $obj = ABCFRGGCL_Main();
        $slug = $obj->pluginSlug;

        //Exit if user doesn't have permission to save
        if (!$this->user_can_save( $postID, $slug . '_nonce', $slug ) ) {
            return;
        }

        $this->save_img( $postID );

        //Save data.
        abcfl_mbsave_save_txt($postID, 'imgLnk', '_imgLnk');
        abcfl_mbsave_save_txt($postID, 'imgLnkArgs', '_imgLnkArgs');
        // abcfl_mbsave_save_txt($postID, 'imgID', '_imgID');
        // abcfl_mbsave_save_txt($postID, 'imgUrl', '_imgUrl');

        $this->save_item( $postID, 'F1' );
    }


    //== IMAGE START ================================
    private function save_img( $postID ) {

        //error_log( print_r($postID, true) );

        $imgUrl = isset( $_POST['imgUrl']) ? esc_attr( $_POST['imgUrl' ] ) : '';
        $imgAlt = isset( $_POST['imgAlt'] ) ? esc_attr( $_POST['imgAlt'] ) : '';

        $imgID = abcfrggcl_img_id_by_url( $imgUrl );

        abcfl_mbsave_save_txt_value( $postID, '_imgUrl', $imgUrl,  '');
        abcfl_mbsave_save_txt_value( $postID, '_imgID', $imgID,  '');

        $this->save_img_alt( $postID, $imgID, $imgUrl, $imgAlt );
    }

    private function save_img_alt( $postID, $imgID, $imgUrl, $imgAlt ) {

        if( !empty( $imgAlt ) ) {
            abcfl_mbsave_save_txt($postID, 'imgAlt', '_imgAlt');
            return;
        }

        if( $imgID > 0 ){
            $metaImgAlt = get_post_meta( $imgID, '_wp_attachment_image_alt', true );
            abcfl_mbsave_save_txt_value( $postID, '_imgAlt', $metaImgAlt,  '');
            return;
        }

        $imgID = abcfrggcl_img_id_by_url( $imgUrl );
        if( $imgID > 0 ){
            $metaImgAlt = get_post_meta( $imgID, '_wp_attachment_image_alt', true );
            abcfl_mbsave_save_txt_value( $postID, '_imgAlt', $metaImgAlt,  '');
            return;
        }

        abcfl_mbsave_save_txt_value( $postID, '_imgAlt', '',  '');
    }

    //== IMAGE END ================================

    private function save_item( $postID, $F ) {

        abcfl_mbsave_save_txt($postID, 'txt_' . $F, '_txt_' . $F);
    }


    private function user_can_save( $postID, $nonceAction, $nonceID ) {

        $is_autosave = wp_is_post_autosave( $postID );
        $is_revision = wp_is_post_revision( $postID );
        $is_valid_nonce = ( isset( $_POST[ $nonceAction ] ) && wp_verify_nonce( $_POST[ $nonceAction ], $nonceID ) );

        return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;
    }
}
