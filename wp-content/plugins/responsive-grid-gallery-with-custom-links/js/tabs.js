(function( $ ) {
    'use strict';
    $(function() {
        // Grab the wrapper for the Navigation Tabs abcfrggcl_tabs.cntrID
        var navTabs1 = $( abcfrggcl_tabs.cntrID1).children( '.nav-tab-wrapper' ), tabIndex1 = null;

    navTabs1.children().each(function() {
        $( this ).on( 'click', function( evt ) {

            evt.preventDefault();

            // If this tab is not active...
            if ( ! $( this ).hasClass( 'nav-tab-active' ) ) {

                // Unmark the current tab and mark the new one as active
                $( '.nav-tab-active', abcfrggcl_tabs.cntrID1 ).removeClass( 'nav-tab-active abcfTabactive' );
                $( this ).addClass( 'nav-tab-active abcfTabactive' );

                // Save the index of the tab that's just been marked as active. It will be 0 - 3.
                tabIndex1 = $( this ).index();

                // Hide the old active content
                $( abcfrggcl_tabs.cntrID1 )
                        .children( 'div:not( .inside.hidden )' )
                        .addClass( 'hidden' );

                $( abcfrggcl_tabs.cntrID1 )
                        .children( 'div:nth-child(' + ( tabIndex1 ) + ')' )
                        .addClass( 'hidden' );

                // And display the new content
                $( abcfrggcl_tabs.cntrID1 )
                        .children( 'div:nth-child( ' + ( tabIndex1 + 2 ) + ')' )
                        .removeClass( 'hidden' );

                $('#sort-items-tbl td').each(function(){
                    $(this).css('width', $(this).width() +'px');
                });
            }
        });
    });
	});
})( jQuery );