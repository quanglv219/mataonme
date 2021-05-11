@extends('layouts.bootstrap')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
<style>
        .navbar {
            display: block !important;
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('content')
    <div class="row justify-content-center" style="margin-top: 10%">
        <div class="col-md-4">
            <div class="d-flex justify-content-center">
                <img class="img-fluid mb-4" style="height: 50px" src="{{ url('assets/images/logo.png') }}">
            </div>
            <div class="card">
                <div class="card-header h4">
                    Enter your credit card information
                </div>
                <div class="card-body">
                    <div id="payment-form">
                        <div class="alert alert-danger" id="alert" style="display: none">
                            <strong id="response"></strong>
                        </div>
                        <!-- Stripe Elements Placeholder -->
                        <div id="card-element"></div>

                        <!-- Stripe Erorrs -->
                        <div id="card-errors" class="text-danger mt-3" role="alert"></div>

                        <button
                            id="card-button"
                            class="btn btn-dark w-100 mt-1"
                            type="submit"
                            onclick="submit()"
                            data-secret="{{ $intent->client_secret }}"
                        > Pay </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}', { locale: 'en' });

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        submit = async (e) => {
            console.log('clicked')
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                    }
                }
            );

            let alert = document.getElementById('alert')
            let response = document.getElementById('response')
            alert.style.display = "none"
            response.innerHTML = ""

            if (error) {
                // Display "error.message" to the user...
                console.log('error occured', error)
                alert.style.display = "block"
                response.innerHTML = error.message
            } else {
                // The card has been verified successfully...
                await fetch('/user/subscribe', {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
                    },
                    body: JSON.stringify({
                        payment_method: setupIntent.payment_method
                    })
                })
                .then(res => {
                    window.location.href = '/user/settings'
                })
                .catch(err => {
                    // 
                })
                
                // Submit the form with the token ID.
                function stripeTokenHandler(paymentMethod) {
                    console.log('reunnig ', +" Submit the form with the token ID.")
                    // Insert the token ID into the form so it gets submitted to the server
                    var form = document.getElementById('payment-form');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'paymentMethod');
                    hiddenInput.setAttribute('value', paymentMethod);
                    form.appendChild(hiddenInput);

                    // Submit the form
                    form.submit();
                }
            }
        };
    </script>
@endsection