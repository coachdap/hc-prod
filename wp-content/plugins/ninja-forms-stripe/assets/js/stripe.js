var nfStripeController = Marionette.Object.extend({
    /**
     * Hook up our render and submit listeners.
     * @since  3.0.0
     * @return void
     */

    initialize: function() {
        this.listenTo( nfRadio.channel( 'forms' ), 'submit:response', this.actionRedirect );
    },

    /**
     * Halt and Redirect to new Stripe Chekcout
     * @param {*} response 
     */
    actionRedirect: function( response ) {

        // Exit early if we're not actually processing a Stripe action.
        if ( 'undefined' == typeof response.data ||
             'undefined' == typeof response.data.halt ||
             ! response.data.halt ||
             'undefined' == typeof response.data.extra ||
             'undefined' == typeof response.data.extra.stripe_checkout ||
             'undefined' == typeof response.data.extra.stripe_checkout.session ||
             'undefined' == typeof response.data.extra.stripe_checkout.session.id ) {
            return false;
        }
        let stripe = Stripe(nfStripe.publishable_key);
        let sessionId = response.data.extra.stripe_checkout.session.id;
        stripe.redirectToCheckout({
            // Make the id field from the Checkout Session creation API response
            // available to this file, so you can provide it as parameter here
            // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
            sessionId: sessionId
        }).then(function (result) {
            if ( 'undefined' !== result.error ) {
                console.error( 'Processing Error: ' + result.error.message );
            }
        // If `redirectToCheckout` fails due to a browser or network
        // error, display the localized error message to your customer
        // using `result.error.message`.
        });
    },

});

jQuery( document ).ready( function( $ ) {
    new nfStripeController();
});