
var key = document.getElementById("stripe_key").value;
var stripe = Stripe(key);
var elements = stripe.elements();
var cardElement = elements.create('card');
cardElement.mount('#card-element');

function createToken() {
    document.getElementById("pay-btn").disabled = true;
    stripe.createToken(cardElement).then(function(result) {

        if(typeof result.error != 'undefined') {
            document.getElementById("pay-btn").disabled = false;
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        }
        /* creating token success */
        if(typeof result.token != 'undefined') {
            document.getElementById("stripe-token-id").value = result.token.id;
            document.getElementById('checkout-form').submit();
        }
    });
}