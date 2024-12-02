<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeCheckoutController extends Controller
{
    /**
     * Display the checkout page and create a Stripe Checkout session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        // Set Stripe API secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve product details from the request (you can dynamically fetch product data here)
        $productName = $request->input('product_name', 'Default Product');  // Fallback to a default value if not provided
        $unitAmount = $request->input('unit_amount', 1000); // Default amount if not provided
        $currency = $request->input('currency', 'usd'); // Default currency as USD
        $quantity = $request->input('quantity', 1); // Default quantity if not provided

        // Create a Stripe Checkout session
        try {
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $currency, // Dynamically set the currency
                            'product_data' => [
                                'name' => $productName, // Dynamically set the product name
                            ],
                            'unit_amount' => $unitAmount, // Price in cents (e.g., $10.00 = 1000)
                        ],
                        'quantity' => $quantity, // Dynamically set the quantity
                    ],
                ],
                'mode' => 'payment', // One-time payment
                'success_url' => route('stripe.success'), // Redirect to success page
                'cancel_url' => route('stripe.cancel'), // Redirect to cancel page
            ]);

            // Return the session ID to the frontend to redirect the user to the Stripe checkout page
            return response()->json(['id' => $checkout_session->id]);

        } catch (\Exception $e) {
            // Handle Stripe errors
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success()
    {
        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }
}
