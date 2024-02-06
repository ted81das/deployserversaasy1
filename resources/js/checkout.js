
document.addEventListener("DOMContentLoaded", function (event) {
    let form = document.getElementById('checkout-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        // get the selected radio button payment-provider value
        let paymentProvider = document.querySelector('input[name="payment-provider"]:checked');

        // if the radio button has a data-is-overlay-provider="true" attribute, then we need to show the overlay
        if (paymentProvider.getAttribute('data-is-overlay-provider') == '1') {
            switch (paymentProvider.value) {
                case 'paddle':
                    paddleCheckout();
                    break;
            }

        } else {
            form.submit();
        }


        return false;
    });


});


function paddleCheckout() {
    Paddle.Checkout.open({
        settings: {
            successUrl: successUrl,
        },
        items: [
            {
                priceId: paddlePriceId,
                quantity: 1
            }
        ],
        customData: {
            subscriptionUuid: subscriptionUuid
        },
        customer: {
            email: customerEmail
        },
        discountId: paddleDiscountId,
    });
}
