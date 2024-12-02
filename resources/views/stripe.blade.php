<!DOCTYPE html>
<html>

<head>
    <title>Stripe Payment</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Payment Gateway Using Stripe</h1>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading">
                        <h3 class="panel-title">Payment Details</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('stripe.post') }}" method="post" class="require-validation"
                            data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                            @csrf
                            <input type="hidden" name="order_id" value="">
                            <div class="form-row row">
                                <div class="col-xs-12 form-group required">
                                    <label class="control-label">Name on Card</label>
                                    <input class="form-control" size="4" type="text">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-xs-12 form-group card required">
                                    <label class="control-label">Card Number</label>
                                    <input autocomplete="off" class="form-control card-number" size="20" type="text">
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="col-xs-4 form-group cvc required">
                                    <label class="control-label">CVC</label>
                                    <input autocomplete="off" class="form-control card-cvc" placeholder="ex. 311"
                                        size="4" type="text">
                                </div>
                                <div class="col-xs-4 form-group expiration required">
                                    <label class="control-label">Expiration Month</label>
                                    <input class="form-control card-expiry-month" placeholder="MM" size="2" type="text">
                                </div>
                                <div class="col-xs-4 form-group expiration required">
                                    <label class="control-label">Expiration Year</label>
                                    <input class="form-control card-expiry-year" placeholder="YYYY" size="4"
                                        type="text">
                                </div>
                            </div>
                            <form action="{{ route('stripe.post') }}" method="POST">
                                @csrf
                                <input type="hidden" name="grandTotal" value="{{ $grandTotal }}"> <!-- Use the passed $grandTotal -->
                                <!-- Pass the grand total -->
                                <input type="hidden" name="address" value="{{ $customerAddress->address }}"> <!-- Pass the address -->
                                <input type="hidden" name="stripeToken" id="stripeToken"> <!-- Stripe Token -->

                                <!-- Add Stripe's credit card fields here -->

                               
                            </form>
                            <button type="submit" id="grandTotal" class="btn btn-primary text-center">Pay Now (₹.{{ number_format($grandTotal, 2) }})</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v2/"></script>
    <script>
        $(function () {
            var $form = $(".require-validation");
            $form.on('submit', function (e) {
                var $inputs = $form.find('.required').find('input[type=text]'),
                    $errorMessage = $form.find('div.error'),
                    valid = true;

                $errorMessage.addClass('hide');
                $('.has-error').removeClass('has-error');

                $inputs.each(function (i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.parent().addClass('has-error');
                        $errorMessage.removeClass('hide');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                }
            });

            function stripeResponseHandler(status, response) {
                if (response.status == true) {
                    // If successful, update the UI with the new grand total and discount amount
               
                    $("#grandTotal").html( + response.grandTotal);  // Assuming you have an element to show the grand total
                   

                }
                if (response.error) {
                    $('.error').removeClass('hide').find('.alert').text(response.error.message);
                } else {
                    var token = response['id'];
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        });
    </script>
</body>

</html>