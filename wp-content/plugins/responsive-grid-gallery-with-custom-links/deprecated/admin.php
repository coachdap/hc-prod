<?php
//Data Entry Options - labels
function abcfrggcl_mbox_gallery_field_data_entry_optns_hdr(){

    echo abcfl_input_hline('2', '20');
    echo abcfl_input_info_lbl(abcfrggcl_txta(226), 'abcflMTop15', '16', 'SB');
    echo abcfl_input_info_lbl(abcfrggcl_txta(240), 'abcflMTop5', '12', 'N');
}

//Data Display Options - labels
function abcfrggcl_mbox_gallery_field_data_display_optns_hdr(){

    //echo abcfl_input_hline('2', '20');
    echo abcfl_input_info_lbl(abcfrggcl_txta(219), 'abcflMTop15', '16', 'SB');
    echo abcfl_input_info_lbl(abcfrggcl_txta(206), 'abcflMTop5', '12', 'N');
}

//Generic class + style
function abcfrggcl_mbox_gallery_field_class_and_style(  $clsInputID, $styleInputID, $F,  $clsLbl, $styleLbl, $clsInputName, $styleInputName ){

        echo abcfl_input_txt($clsInputName . $F, '', $clsInputID, abcfrggcl_txta($clsLbl), abcfrggcl_txta(223), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
        echo abcfl_input_txt($styleInputName . $F, '', $styleInputID, abcfrggcl_txta($styleLbl), abcfrggcl_txta(224), '50%', '', '', 'abcflFldCntr', 'abcflFldLbl');
}

function abcfrggcl_aurl_tab_help( ) {

    $getParams = abcfsl_admin_tabs_defaults( '' );
    $basePg = 'admin.php?page=' . $getParams['page'];
    $hrefHelp =  $basePg . '&amp;tab=' . 'tabHelp';
    return $hrefHelp;
}
