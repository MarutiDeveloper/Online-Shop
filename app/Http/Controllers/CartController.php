<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingCharge;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::with('product_images')->find($request->id);

        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found...!'
            ]);
        }

        // Get the first image URL if available
        $productImage = !empty($product->product_images) ? $product->product_images->first() : null;

        // Check if the product is already in the cart
        $cartContent = Cart::content();
        $productAlreadyExists = false;

        foreach ($cartContent as $item) {
            if ($item->id == $product->id) {
                $productAlreadyExists = true;
                break; // Exit the loop once found
            }
        }

        if (!$productAlreadyExists) {
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => $productImage]);
            $status = true;
            $message = '<strong>' . $product->title . ' </strong> added in your cart Successfully ';
            session()->flash('success', $message);
        } else {
            $status = false;
            $message = $product->title . ' is already in your cart.';
            session()->flash('success', $message);
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }

    public function cart()
    {
        $cartContent = Cart::content();
        //dd($cartContent);
        $data['cartContent'] = $cartContent;
        return view('front.cart', $data);
    }
    public function updateCart(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;

        $itemInfo = Cart::get($rowId);

        $product = Product::find($itemInfo->id);
        // If you want to get an item from the cart using its rowId, you can simply call the get() method on the cart and pass it the rowId.
        // Check Qty Avalable in stock.
        if ($product->track_qty == 'Yes') {
            if ($qty <= $product->qty) {
                Cart::update($rowId, $qty); // Will update the quantity
                $message = 'Cart Updated Successfully...!';
                $status = true;
                session()->flash('success', $message);
            } else {
                $message = 'Requested qty (' . $qty . ') not Available in the Stock...!';
                $status = false;
                session()->flash('error', $message);
            }
        } else {
            Cart::update($rowId, $qty); // Will update the quantity
            $message = 'Cart Updated Successfully...!';
            $status = true;
            session()->flash('success', $message);
        }



        //$message = 'Cart Updated Successfully...!';
        session()->flash('success', $message);
        return response()->json([
            'status' => $status,
            'message' => $message
        ]);
    }
    public function deleteItem(Request $request)
    {

        $itemInfo = Cart::get($request->rowId);

        if ($itemInfo == null) {
            $errorMessage = 'Item not found in cart ';
            session()->flash('error', $errorMessage);
            return response()->json([
                'status' => false,
                'message' => $errorMessage
            ]);
        }
        Cart::remove($request->rowId);

        $message = 'Item Removed from Cart Successfully ';
        session()->flash('success', $message);
        return response()->json([
            'status' => true,
            'message' => $message
        ]);

    }
    public function checkout(Request $request)
    {

        // if Cart is empty redirect to cart page
        if (Cart::count() == 0) {
            return redirect()->route('front.cart');
        }

        // If User is not logged in than redirect to login Page.
        if (Auth::check() == false) {
            if (!session()->has(' url.intended ')) {
                session(['url.intended' => url()->current()]);
            }

            return redirect()->route('account.login');
        }


        $customerAddress = CustomerAddress::where('user_id', Auth::user()->id)->first();

        session()->forget(' url.intended ');

        $countries = Country::orderBy('name', 'ASC')->get();

        // Calculate Shipping Here...
        if ($customerAddress != '') {
            $userCountry = $customerAddress->country_id;
            $shippingInfo = ShippingCharge::where('country_id', $userCountry)->first();

            //echo $shippingInfo->amount;

            $totalQty = 0;
            $totalShippingCharge = 0;
            $grandTotal = 0;
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }

            $totalShippingCharge = $totalQty*$shippingInfo->amount;

            $grandTotal = Cart::subtotal(2, '.', '') + $totalShippingCharge;

        }else {
            $grandTotal = Cart::subtotal(2, '.', '');
            $totalShippingCharge = 0;
        }


        return view('front.checkout', [
            'countries' => $countries,
            'customerAddress' => $customerAddress,
            'totalShippingCharge' => $totalShippingCharge,
            'grandTotal' => $grandTotal
        ]);
    }
    public function processCheckout(Request $request)
    {

        // Step-1 Apply Validation

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'country' => 'required',
            'address' => 'required|min:30',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'mobile' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the error...!',
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        // Step-2 Save Customer Address
        //$customerAddress = CustomerAddress::find();

        $user = Auth::user();

        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'country_id' => $request->country,
                'address' => $request->address,
                'apartment' => $request->appartment,
                'city' => $request->city,
                'state' => $request->state,
                'zip' => $request->zip,

            ]
        );

        // Step-3 Save Data in Orders Table.
        if ($request->payment_method == 'cod') {

            $shipping = 0;
            $discount = 0;
            $subTotal = Cart::subtotal(2, '.', '');
            $grandTotal = $subTotal + $shipping;

            // Calculate Shipping
            $shippingInfo = ShippingCharge::where('country_id', $request->country)->first();

            $totalQty = 0;
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }

            if ($shippingInfo != null) {

                $shipping = $totalQty * $shippingInfo->amount;

                $grandTotal = $subTotal + $shipping;



            } else {
                $shippingInfo = ShippingCharge::where('country_id', 'rest_of_world')->first();

                $shipping = $totalQty * $shippingInfo->amount;

                $grandTotal = $subTotal + $shipping;

            }



            $order = new Order;
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->grand_total = $grandTotal;
            $order->user_id = $user->id;

            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->mobile = $request->mobile;
            $order->address = $request->address;
            $order->apartment = $request->apartment;
            $order->state = $request->state;
            $order->city = $request->city;
            $order->zip = $request->zip;
            $order->notes = $request->order_notes;
            $order->country_id = $request->country;
            $order->save();

            // Step-4 Save Data in Order items in Order item Table.
            foreach (Cart::content() as $item) {
                $orderItem = new OrderItem;
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->name = $item->name;
                $orderItem->qty = $item->qty;
                $orderItem->price = $item->price;
                $orderItem->total = $item->price * $item->qty;
                $orderItem->save();
            }

            $message = 'You have a Successfully Order Placed...! ';
            session()->flash('success', $message);

            Cart::destroy();

            return response()->json([
                'status' => true,
                'orderId' => $order->id,
                'message' => $message
            ]);

        } else {
            # Stripe Payment Get-Way
        }

    }
    public function thankyou($id)
    {
        // Find the order by its ID
        $order = Order::find($id);

        // Get the product IDs from the order_items table where the order_id matches
        $orderItems = OrderItem::where('order_id', $id)->get();


        // Get the product names from the products table based on product_id
        $productNames = [];
        foreach ($orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $productNames[] = $product->name; // Assuming 'name' is the column for the product name
            }
        }

        // Return the view with both order ID and product names
        return view('front.thanks', [
            'id' => $order->id,
            'productNames' => $productNames,
        ]);
    }
    public function getOrderSummery(Request $request)
    {
        $subTotal = Cart::subtotal(2, '.', '');
        if ($request->country_id > 0) {

            $subTotal = Cart::subtotal(2, '.', '');

            $shippingInfo = ShippingCharge::where('country_id', $request->country_id)->first();

            $totalQty = 0;
            foreach (Cart::content() as $item) {
                $totalQty += $item->qty;
            }

            if ($shippingInfo != null) {

                $ShippingCharge = $totalQty * $shippingInfo->amount;

                $grandTotal = $subTotal + $ShippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2),
                    'ShippingCharge' => number_format($ShippingCharge, 2)
                ]);

            } else {
                $shippingInfo = ShippingCharge::where('country_id', 'rest_of_world')->first();

                $ShippingCharge = $totalQty * $shippingInfo->amount;

                $grandTotal = $subTotal + $ShippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2),
                    'ShippingCharge' => number_format($ShippingCharge, 2)
                ]);
            }

        } else {
            return response()->json([
                'status' => true,
                'grandTotal' => number_format($subTotal, 2),
                'ShippingCharge' => number_format(0, 2)
            ]);
        }
    }
}
