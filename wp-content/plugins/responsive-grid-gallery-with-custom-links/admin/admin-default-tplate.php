<?php

//echo"<pre>", print_r($_POST), "</pre>"; die;
function abcfrggcl_admin_default_tplate() {

    $obj = ABCFRGGCL_Main();
    $slug = $obj->pluginSlug;

    $optnName = 'rggcl_default_tplate_id';
    $tplateID = get_option( $optnName, 0 );

    //========================================
    if ( isset($_POST['btnSaveDefaultTplate']) ){
        check_admin_referer( $slug . '_nonce' );

        $defaultTplateID = ( isset( $_POST['tplateID'] ) ?$_POST['tplateID'] : 0);
        abcfrggcl_admin_default_tplate_save( $optnName, $defaultTplateID );
        $tplateID = get_option( $optnName, 0 );
        abcfl_autil_msg_ok();
    }

    //========================================
    $cboTplates = abcfrggcl_dba_cbo_templates( ' - - - ' );

    $lbl = abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(86), abcfrggcl_aurl(0), 'abcflFontWP abcflFontS12 abcflFontW400' );
    //--Form Start ------------------------
    echo abcfl_html_form( 'frm_default_tplate', '');
    wp_nonce_field($slug . '_nonce');
    //-- Main Cntr DIV Start --------------
    echo abcfl_html_tag_cls('div', 'abcflMTop20 abcflMLeft30');

        echo abcfl_input_cbo('tplateID', '', $cboTplates, $tplateID, $lbl, '', '30%', true, '', '', 'abcflFldCntr abcflMTop40', 'abcflFldLbl');

        echo abcfl_input_hline('2', '30', '50P');
        //-- Button DIV Start --------------------------
        echo abcfl_html_tag('div','', 'submit' );
        echo abcfl_input_btn( 'btnConvert', 'btnSaveDefaultTplate', 'submit', abcfrggcl_txta(116), 'button-primary abcficBtnWide' );

    //-- ENDs: Button, Main Cntr, Form,  ------------------------------------------------
    echo abcfl_html_tag_ends('div,div,form');
}

function abcfrggcl_admin_default_tplate_save(  $optnName, $tplateID ) {

    if( $tplateID == 0 ){
        delete_option( $optnName );
        return;
    }
    update_option( $optnName, $tplateID );
}


