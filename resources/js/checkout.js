
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
    let customData = {};

    // if subscriptionUuid is set, then it's a subscription
    if (typeof subscriptionUuid !== 'undefined') {
        customData.subscriptionUuid = subscriptionUuid;
    }

    // if orderUuid is set, then it's a one-time purchase
    if (typeof orderUuid !== 'undefined') {
        customData.orderUuid = orderUuid;
    }

    let items = [];
    for (let i = 0; i < paddleProductDetails.length; i++) {
        items.push({
            priceId: paddleProductDetails[i].paddlePriceId,
            quantity: paddleProductDetails[i].quantity
        });
    }

    console.log({
        settings: {
            successUrl: successUrl,
        },
        items: items,
        customData: customData,
        customer: {
            email: customerEmail
        },
        discountId: paddleDiscountId,
    });

    Paddle.Checkout.open({
        settings: {
            successUrl: successUrl,
        },
        items: items,
        customData: customData,
        customer: {
            email: customerEmail
        },
        discountId: paddleDiscountId,
    });
}
