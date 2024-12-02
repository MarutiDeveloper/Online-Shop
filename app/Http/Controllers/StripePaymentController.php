<?php
namespace App\Http\Controllers;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Stripe;
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $data)
    {
        $grandTotal=$data->input('grandTotal');
        $user = Auth::user();  // Get the authenticated user
    
        // Fetch the most recent order for the user
        $order = Order::where('user_id', $user->id)->latest()->first();
    
        if (!$order) {
            return back()->withErrors(['error' => 'No order found for this user.']);
        }
    
        $grandTotal = $order->grand_total ?? 0; // Fetch the grand total with a fallback
        $customerAddress = $user->address;  // Retrieve the user's address
    
        return view('stripe', compact('customerAddress', 'grandTotal')); // Pass data to the view
    }

    /**
     * Handle Stripe payment and order creation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $user = Auth::user();  // Get the authenticated user

        // Retrieve the user's address or use the one provided in the request
        $customerAddress = $user->address;  // Get the address from the related customer_addresses table
        $address = $customerAddress ? $customerAddress->address_line1 : $request->address;

        // Validate the request
        $request->validate([
            'stripeToken' => 'required|string',
            'grandTotal' => 'required|numeric',  // Ensure grandTotal is passed
        ]);

        try {
            // Set Stripe API key
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Create the Stripe charge
            $charge = \Stripe\Charge::create([
                "amount" => $request->grandTotal * 100, // Amount in cents
                "currency" => "usd",
                "source" => $request->stripeToken, // Token from the frontend
                "description" => "Payment for order from OnlineShop.com",
            ]);

            // Create the order in the database
            $order = Order::create([
                'user_id' => $user->id,  // Using the authenticated user's ID
                'grand_total' => $request->grandTotal,  // Use 'grand_total' for the total amount
                'status' => 'paid',  // Set the status to 'paid' after successful payment
                'address' => $address,  // Save the user's address
            ]);

            // Pass the order and other data to the success view
            return view('checkout', compact('order', 'amount'))->with('success', 'Payment successful!');
        } catch (\Exception $e) {
            // Handle payment errors
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function stripeSuccess()
    {

        return view('checkout'); // Create a success page
    }


}
