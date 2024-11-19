<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::select('orders.*', 'users.name', 'users.email')
            ->leftJoin('users', 'users.id', '=', 'orders.user_id')
            ->orderBy('orders.id', 'DESC');  // Sorting by order ID in descending order

        if ($request->get('keyword') != "") {
            $keyword = $request->keyword;

            // Grouping the search conditions in a closure
            $orders = $orders->where(function ($query) use ($keyword) {
                $query->where('users.name', 'like', '%' . $keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $keyword . '%')
                    ->orWhere('orders.id', 'like', '%' . $keyword . '%');
            });
        }

        $orders = $orders->paginate(10);

        return view('admin.orders.list', [
            'orders' => $orders
        ]);
    }

    public function detail($orderId)
    {
        // Eager load the related user with the order
        $order = Order::select('orders.*', 'countries.name as countryName')
            ->with('user')->where('orders.id', $orderId)
            ->leftJoin('countries', 'countries.id', 'orders.country_id')
            ->first();
        $orderItems = OrderItem::where('order_id', $orderId)->get();

        return view('admin.orders.detail', [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }
    public function changeOrderStatus(Request $request, $orderId) {
        $order = Order::findOrFail($orderId);

        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();

        $message = 'Order Status Updated Successfully...';
        session()->flash('success', $message);

        return response()->json([
            'status'    => true,
            'message' =>  $message
        ]);
    }
    public function sendInvoiceEmail (Request $request, $orderId) {
        // echo "hello";
        orderEmail($orderId, $request->userType);

        $message = 'You have Successfully Send Mail...';
        session()->flash('success', $message);

        return response()->json([
            'status'    => true,
            'message' =>  $message
        ]);
    }
}