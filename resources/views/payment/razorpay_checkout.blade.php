@extends('front.layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Razorpay Checkout</h1>

    <!-- Order Summary -->
    <div class="card mb-4">
        <div class="card-body">
            <h5>Order Details</h5>
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Product Name:</strong> {{ $product->name }}</p>
            <p><strong>Amount:</strong> ₹{{ number_format($order->amount, 2) }}</p>
        </div>
    </div>

    <!-- Hidden Inputs for Razorpay -->
    <input type="hidden" id="order-id" value="{{ $order->id }}">
    <input type="hidden" id="product-id" value="{{ $product->id }}">
    <input type="hidden" id="order-amount" value="{{ $order->grand_total }}">
    <input type="hidden" id="customer-name" value="{{ Auth::user()->name }}">
    <input type="hidden" id="customer-email" value="{{ Auth::user()->email }}">
    <input type="hidden" id="customer-contact" value="{{ Auth::user()->phone }}">

    <!-- Pay Now Button -->
    <!-- <div class="text-center">
        <button id="pay-now" class="btn btn-primary btn-lg">Pay Now</button>
    </div> -->
    <div class="pt-4">
        <a href="https://razorpay.me/@tejaskumarpradipbhaijoshi" type="button" class="btn-dark btn-primary btn btn-block w-100"
            id="pay-now"
            style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; font-size:larger;">
            <i class="fas fa-credit-card"></i> Pay Now By Stripe
        </a>
    </div>
</div>
@endsection

@section('customJs')
<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById("pay-now").addEventListener("click", async function () {
        try {
            // Fetch checkout session from the server
            const response = await fetch("{{ route('createCheckoutSession') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    order_id: document.getElementById("order-id").value,
                    product_id: document.getElementById("product-id").value
                }),
            });

            const data = await response.json();

            if (data.error) {
                alert(data.error);
                return;
            }

            // Razorpay options
            const options = {
                key: "{{ env('RAZORPAY_KEY') }}", // Your Razorpay key
                amount: data.amount, // Amount in paise
                currency: data.currency,
                name: "Online Shop",
                description: data.product_name,
                order_id: data.razorpay_order_id,
                handler: function (response) {
                    // Handle successful payment
                    alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);
                    window.location.href = "{{ route('payment.success') }}";
                },
                prefill: {
                    name: document.getElementById("customer-name").value,
                    email: document.getElementById("customer-email").value,
                    contact: document.getElementById("customer-contact").value,
                },
                theme: {
                    color: "#3399cc",
                },
                modal: {
                    ondismiss: function () {
                        alert("Payment cancelled by user.");
                    },
                },
            };

            const rzp = new Razorpay(options);
            rzp.open();
        } catch (error) {
            console.error("Error initiating payment:", error);
            alert("Failed to initiate payment. Please try again.");
        }
    });
</script>
@endsection