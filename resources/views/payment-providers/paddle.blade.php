
@push('head')

    <script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>

    <script>
        let customerEmail = '{{ $user->email ?? '' }}';
        let paddlePriceId = '{{ $data['paddlePriceId'] }}';
        @if (isset($data['paddleDiscountId']))
            let paddleDiscountId = '{{ $data['paddleDiscountId'] }}';
        @else
            let paddleDiscountId = null;
        @endif
        @if(config('services.paddle.is_sandbox'))
            Paddle.Environment.set("sandbox");
        @endif

        document.addEventListener("DOMContentLoaded", (event) => {
            Paddle.Setup({
                token: '{{ config('services.paddle.client_side_token') }}',
                checkout: {
                    settings: {
                        displayMode: "overlay",
                        theme: "light",
                    }
                },
                eventCallback: function(data) {
                    switch (data.name) {
                        case "checkout.completed":

                            setTimeout(function() {
                                window.location.href = successUrl;
                            }, 2000);

                            break;
                    }
                }
            });
        });

    </script>
@endpush




