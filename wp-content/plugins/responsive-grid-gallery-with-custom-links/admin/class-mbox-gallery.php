<?php
if ( ! defined( 'ABSPATH' ) ) {exit;}
class ABCFRGGCL_MBox_Gallery {

    public function __construct() {
        add_action( 'add_meta_boxes_cpt_rggcl_gallery', array( $this, 'add_meta_box' ) );
        add_action( 'save_post_cpt_rggcl_gallery', array( $this, 'save_post' ) );
    }

    public function add_meta_box() {
        add_meta_box(
            'abcfrggcl_mbox_gallery',
            abcfrggcl_txta(19),
            array( $this, 'show_mbox_gallery_optns' ),
            'cpt_rggcl_gallery',
            'normal',
            'high'
        );
        add_meta_box(
            'abcfrggcl_mbox_gallery_f',
            abcfrggcl_txta(63),
            array( $this, 'display_mbox_fields' ),
            'cpt_rggcl_gallery',
            'normal',
            'default'
        );
    }

    public function show_mbox_gallery_optns() {
        abcfrggcl_mbox_gallery_tabs();
    }

    public function display_mbox_fields() {
	abcfrggcl_mbox_gallery_fields();
    }

    public function save_post( $postID ) {

        $obj = ABCFRGGCL_Main();
        $slug = $obj->pluginSlug;

        //Exit if user doesn't have permission to save
        if (!$this->user_can_save( $postID, $slug . '_nonce', $slug ) ) {
            return;
        }

        //Save data.---------------------------------------------
        abcfl_mbsave_save_cbo( $postID, 'gridCols', '_gridCols', '2');
        abcfl_mbsave_save_cbo( $postID, 'vAid', '_vAid', 'N');

        //TODO itemPadLR convert to cbo
        //abcfl_mbsave_save_txt( $postID, 'itemPadLR', '_itemPadLR' , 'D');
        abcfl_mbsave_save_cbo( $postID, 'itemPadLR', '_itemPadLR' , 'N');
        abcfl_mbsave_save_cbo( $postID,'itemMarginB', '_itemMarginB', 'D');
        abcfl_mbsave_save_txt($postID, 'itemCls', '_itemCls');
        abcfl_mbsave_save_txt($postID, 'itemStyle', '_itemStyle');

        abcfl_mbsave_save_txt($postID, 'imgCls', '_imgCls');
        abcfl_mbsave_save_txt($postID, 'imgStyle', '_imgStyle');

        abcfl_mbsave_save_txt($postID, 'txtCntrCls', '_txtCntrCls');
        abcfl_mbsave_save_txt($postID, 'txtCntrStyle', '_txtCntrStyle');
        abcfl_mbsave_save_cbo( $postID, 'addMaxW', '_addMaxW', 'N');

        abcfl_mbsave_save_txt($postID, 'gCntrW', '_gCntrW');
        abcfl_mbsave_save_cbo( $postID, 'gCntrCenter', '_gCntrCenter', 'N');
        abcfl_mbsave_save_txt($postID, 'gCntrCls', '_gCntrCls');
        abcfl_mbsave_save_txt($postID, 'gCntrStyle', '_gCntrStyle');

//echo"<pre>", print_r($_POST), "</pre>";  die;

        $this->save_field_options( $postID, 'F1');
    }

    private function save_field_options( $postID, $F ) {

    abcfl_mbsave_save_field( $postID, '_fieldType_' . $F, 'T');
    abcfl_mbsave_save_field( $postID, '_fieldTypeH_' . $F, 'T');

    abcfrggcl_autil_add_new_field_to_field_order( $postID, $F );
    //-----------------------------------------------------
    abcfl_mbsave_save_cbo( $postID,'tagType_' . $F, '_tagType_' . $F, 'div');
    abcfl_mbsave_save_cbo( $postID,'tagFont_' . $F, '_tagFont_' . $F, 'D');
    abcfl_mbsave_save_cbo( $postID,'tagMarginT_' . $F, '_tagMarginT_' . $F, 'D');

    abcfl_mbsave_save_txt($postID, 'tagCls_' . $F, '_tagCls_' . $F);
    abcfl_mbsave_save_txt($postID, 'tagStyle_' . $F, '_tagStyle_' . $F);

    //-- Input field labels ---------------------------------------------------
    abcfl_mbsave_save_txt($postID, 'inputLbl_' . $F, '_inputLbl_' . $F);
    abcfl_mbsave_save_txt($postID, 'inputHlp_' . $F, '_inputHlp_' . $F);
}

    private function user_can_save( $postID, $nonceAction, $nonceID ) {

        $is_autosave = wp_is_post_autosave( $postID );
        $is_revision = wp_is_post_revision( $postID );
        $is_valid_nonce = ( isset( $_POST[ $nonceAction ] ) && wp_verify_nonce( $_POST[ $nonceAction ], $nonceID ) );

        return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;
    }
}