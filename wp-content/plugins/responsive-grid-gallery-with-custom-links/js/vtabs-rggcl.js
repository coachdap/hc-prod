(function ($) {
    'use strict';
    $(function () { 
        var timeout = null;
        var vtGOptnsWrapID = '#rggclVtGOptnsWrapID';
        var vtGOptnsCntrID = '#rggclVtGOptnsCntCntrID';
        var storageKey_GOptns = 'rggclStorageKeyGOptns';
        var vtActiveCls = 'abcflVTabsTabActive';
        var vtUlCls = '.abcflVTabsNavCntr';  
        
        // Grab the wrapper for the Navigation Tabs 
        var vtOptnsWrapObj = $(vtGOptnsWrapID).children(vtUlCls), tabIndex1 = null;
        var savedOptnsTab = sessionStorage.getItem(storageKey_GOptns);
        //console.log('savedOptnsTab');
        //console.log(savedOptnsTab);

        if(savedOptnsTab){
            if(savedOptnsTab != 'GO1'){ $(vtGOptnsWrapID + ' ul' + vtUlCls + ' li#GO1').removeClass(vtActiveCls);}
            $(vtGOptnsWrapID + ' ul' + vtUlCls + ' li#' + savedOptnsTab).addClass(vtActiveCls);
            // Hide the old active content
            $(vtGOptnsCntrID).children('div:not( .inside.hidden )').addClass('hidden');
            // Display the new content
            $(vtGOptnsCntrID + ' #' + savedOptnsTab) .removeClass('hidden');
        }

        vtOptnsWrapObj.children().each(function () {
            $(this).on('click', function (evt) {
                evt.preventDefault();

                //console.log('clicked TO');

                // If this tab is not active.
                if (!$(this).hasClass(vtActiveCls)) {

                    // Unmark the current tab and mark the new one as active
                    $('.' + vtActiveCls, vtGOptnsWrapID).removeClass(vtActiveCls);
                    $(this).addClass(vtActiveCls);

                    // Save the index of the tab that's just been marked as active. It will be 0 - 40.
                    tabIndex1 = $(this).index();
                    sessionStorage.setItem(storageKey_GOptns, this.id);                    

                    // Hide the old active content
                    $(vtGOptnsCntrID).children('div:not( .inside.hidden )').addClass('hidden');
                    $(vtGOptnsCntrID).children('div:nth-child(' + (tabIndex1) + ')').addClass('hidden');

                    // And display the new content
                    $(vtGOptnsCntrID).children('div:nth-child( ' + (tabIndex1 + 1) + ')').removeClass('hidden');

                    $('#sort-items-tbl td').each(function () { $(this).css('width', $(this).width() + 'px'); });
                }
            });
        });
    });
    
})(jQuery);