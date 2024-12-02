<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
   
</head>
<body>

    <h2>Checkout Page</h2>
    <button id="checkout-button">Checkout</button>

    <script type="text/javascript">
        var stripe = Stripe("{{ env('STRIPE_KEY') }}"); // Your Stripe public key

        var checkoutButton = document.getElementById("checkout-button");

        checkoutButton.addEventListener("click", function () {
            fetch("/checkout", { // This should match the route where you create the session
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    product_name: "Sample Product", // Example dynamic product name
                    unit_amount: 1000, // Example dynamic price in cents
                    currency: "usd", // Example dynamic currency
                    quantity: 1 // Example dynamic quantity
                })
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                return stripe.redirectToCheckout({ sessionId: data.id });
            })
            .then(function (result) {
                if (result.error) {
                    console.log(result.error.message);
                }
            })
            .catch(function (error) {
                console.error("Error:", error);
            });
        });
    </script>
 <script src="https://js.stripe.com/v2/"></script>
</body>
</html>
