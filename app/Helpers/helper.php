<?php

    use App\Mail\OrderEmail;
    use App\Models\category;
    use App\Models\Country;
    use App\Models\Order;
    use App\Models\OrderItem;
    use App\Models\Page;
    use App\Models\Product;
    use App\Models\ProductImage;
    use Gloudemans\Shoppingcart\Facades\Cart;
    use Illuminate\Support\Facades\Mail;

    function getCategories(){
        return category::orderBy('name', 'ASC')
        ->with('sub_category')
        ->orderBy('id', 'DESC')
        ->where('status', 1)
        ->where('showHome', 'Yes')
        ->get();
    }

    function getProductImage ($productId) {
        return ProductImage::where('product_id', $productId)->first();
    }
    function orderEmail($orderId, $userType="customer") {
            $order  =   Order::where('id', $orderId)->with('items')->first();

            if ($userType == 'customer') {
                $subject   =  'Thanks for your Order...!';
                $email  =   $order->email;
            }else {
                $subject   =  'You have Received an Email by Admin - Panel...!';
                $email  =   env('ADMIN_EMAIL');
            }

            $mailData    =   [
                'subject'   => $subject,
                'order' =>  $order,
                'userType'  =>  $userType
            ];

            Mail::to($email)->send(new OrderEmail($mailData));
            //dd($order);
    }
    function getCountryInfo ($id) {
        return Country::where('id', $id)->first();
    }

    function staticPages () {
        $pages = Page::orderBy('name', 'ASC')->get();
        return $pages;
    }

    function processCOD($request, $user, $subTotal, $discount, $shippingCharge, $grandTotal)
{
    $order = new Order;
    $order->subtotal = $subTotal;
    $order->discount = $discount;
    $order->shipping = $shippingCharge;
    $order->grand_total = $grandTotal;
    $order->payment_status = 'not paid';
    $order->status = 'pending';
    $order->user_id = $user->id;
    $order->first_name = $request->first_name;
    $order->last_name = $request->last_name;
    $order->email = $request->email;
    $order->address = $request->address;
    $order->city = $request->city;
    $order->state = $request->state;
    $order->zip = $request->zip;
    $order->country_id = $request->country;
    $order->save();

    foreach (Cart::content() as $item) {
        $orderItem = new OrderItem;
        $orderItem->product_id = $item->id;
        $orderItem->order_id = $order->id;
        $orderItem->name = $item->name;
        $orderItem->qty = $item->qty;
        $orderItem->price = $item->price;
        $orderItem->total = $item->price * $item->qty;
        $orderItem->save();

        $product = Product::find($item->id);
        if ($product->track_qty === 'Yes') {
            $product->qty -= $item->qty;
            $product->save();
        }
    }

    // Clear the cart
    Cart::destroy();
    session()->forget('code');

    return response()->json([
        'status' => true,
        'message' => 'Order placed successfully with Cash on Delivery.',
    ]);
}


?>