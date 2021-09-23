<?php
function abcfrggcl_mbox_gallery_shortcode() {

    echo  abcfl_html_tag('div','GO3','inside  hidden abcflFadeIn');

        //echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(3), abcfrggcl_aurl(0) );

        echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(3), abcfrggcl_aurl(10) );

        $scode = abcfrggcl_scode_build_scode();
        echo abcfl_input_txt_readonly('scode', '', $scode, '','', '50%', 'regular-text code abcflFontW700', '', 'abcflFldCntr abcflShortcode');

        abcfrggcl_mbox_gallery_shortcode_how_to();    

        //echo abcfl_input_hline('2', '30');
        //echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(227), abcfrggcl_aurl(0) );


    echo abcfl_html_tag_end('div');
}

function abcfrggcl_mbox_gallery_shortcode_how_to(){
    echo abcfl_input_hline('2', '30');
    echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(227), abcfrggcl_aurl(9), 'abcflFontWP abcflFontS18 abcflFontW600 abcflMTop20 abcflMBottom20');
    //echo abcfl_input_sec_title_hlp( ABCFRGGCL_ICONS_URL, abcfrggcl_txta(246), abcfrggcl_aurl(11), 'abcflFontWP abcflFontS18 abcflFontW600 abcflMTop20');
}