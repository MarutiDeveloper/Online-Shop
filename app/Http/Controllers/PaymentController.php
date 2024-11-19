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
   
    public function createCheckoutSession(Request $request, $id)
    {
        $orderId = Order::findOrFail($id);
        $request->validate([
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
        ]);
    
        $orderId = $request->input('order_id');
        $productId = $request->input('product_id');
    
        // Fetch product details and grand total
        $orderItem = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('order_items.order_id', $orderId)
            ->where('order_items.product_id', $productId)
            ->select('products.name as product_name', 'order_items.grand_total')
            ->first();
    
        if (!$orderItem) {
            \Log::error("No order found for order_id: $orderId, product_id: $productId");
            return response()->json(['error' => 'Order or Product not found'], 404);
        }
    
        \Log::info('Fetched Order Item:', (array)$orderItem);
    
        // Razorpay API setup
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
        try {
            // Create Razorpay order
            $razorpayOrder = $api->order->create([
                'receipt' => 'order_' . $orderId,
                'amount' => $orderItem->grand_total * 100, // Amount in paise
                'currency' => 'INR',
                'notes' => [
                    'product_title' => $orderItem->product_name,
                    'order_id' => $orderId,
                ],
            ]);
    
            return response()->json([
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $orderItem->grand_total * 100,
                'currency' => 'INR',
                'product_name' => $orderItem->product_name,
            ]);
        } catch (\Exception $e) {
            \Log::error('Razorpay API Error:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
