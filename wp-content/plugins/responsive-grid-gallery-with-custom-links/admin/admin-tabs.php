<?php
/*
 * Admin tabs: Help.
 */
function abcfrggcl_admin_tabs() {

    $getParams = abcfrggcl_admin_tabs_defaults( $_GET );
    $basePg = 'admin.php?page=' . $getParams['page'];
    $currentTab = $getParams['tab'];


    $tabs = array(
        'tabHelp' => abcfrggcl_txta(1),
        'tabDefaultTplate' => abcfrggcl_txta(86)
        );

    $links = array();


   //Tab links
   foreach( $tabs as $tab => $name ) {

        $href =  $basePg . '&amp;tab=' . $tab;
        if ( $tab == $currentTab ) {
            $links[] = abcfl_html_a_tag($href, $name, '', 'nav-tab abcfkapNavTab nav-tab-active abcfkapNavTabActive');
        }
        else {
            $links[] = abcfl_html_a_tag($href, $name, '', 'nav-tab abcfkapNavTab');
        }
    }

    echo  abcfl_html_tag('div', '', 'wrap' );
    echo abcfl_html_tag( 'h2', '', 'nav-tab-wrapper' );

    foreach ( $links as $link ){ echo $link; }
    echo abcfl_html_tag_ends('h2,div');

    switch ( $currentTab ) {
        case 'tabHelp' :
            abcfrggcl_admin_tab_help();
            break;
        case 'tabDefaultTplate' :
            abcfrggcl_admin_default_tplate();
            break;
        default:
            abcfrggcl_admin_tab_help();
            break;
   }
}
//--------------------------------------------------
function abcfrggcl_admin_tabs_defaults( $get ) {

    if(!$get){ $get = array();}
    $defaults = array(
        'page' => 'abcfrggcl-admin-tabs',
        'tab' => 'tabHelp'
     );

    return wp_parse_args( $get, $defaults );
}


