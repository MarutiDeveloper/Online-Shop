<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
   
    public function showCheckout($orderId)
    {
        $order = Order::findOrFail($orderId); // Fetch the order using the given ID
        $product = $order->product; // Assuming `Order` has a `product` relationship
    
        return view('payment.razorpay_checkout', [
            'orderId' => $order->id,
            'order' => $order,
            'product' => $product,
        ]);
    }

    public function createCheckoutSession(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $razorpayOrder = $api->order->create([
            'amount' => $order->amount * 100, // Amount in paise
            'currency' => 'INR',
            'receipt' => 'order_id' . $order->id,
        ]);

        return response()->json([
            'razorpay_order_id' => $razorpayOrder->id,
            'amount' => $razorpayOrder->amount,
            'currency' => $razorpayOrder->currency,
            'product_name' => $order->product->name,
        ]);
    }
    public function paymentSuccess()
    {

        return view('payment.success'); // Create a success page
    }

    public function paymentCancel()
    {
        return view('payment.cancel'); // Create a cancel page
    }

}
