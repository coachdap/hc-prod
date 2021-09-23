jQuery( document ).ready( function ( $ ) {
    // localized variables passed through params object
    // params
    //  .updated
    // .adminSettingsNonce

    // If Hubspot GetCustomFields is clicked
    $( '#nfHubspotUpdateCustomFields' ).click( function ( e ) {

        // Hit AJAX endpoint and opt-in.
        $.post(
                ajaxurl,
                {
                    action: 'nf_hubspot_admin_settings',
                    nfHubspotTrigger: 'updateCustomFields',
                    adminSettingsNonce: params.adminSettingsNonce
                },
                function ( response ) {
                    data = $.parseJSON( response );
                    $( '#nfHubspotUpdateCustomFields' ).html( params.updated );
                    $( '#nfHubspotFeedbackElement' ).html( data.value );
                } );
    } );


    // If API Key is changed
    $( '#ninja_forms\\[hubspotApiKey\\]' )
            .change( function ( e ) {

                value = $( this ).val();

                // Hit AJAX endpoint and opt-in.
                $.post(
                        ajaxurl, {
                            action: 'nf_hubspot_admin_settings',
                            nfHubspotTrigger: 'saveApiKeyonChange',
                            nfHubspotApiKey: value,
                            adminSettingsNonce: params.adminSettingsNonce
                        },
                        function ( response ) {

                        } );
            }
            );
} );





