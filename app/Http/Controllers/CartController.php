<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CustomerAddress;
use App\Models\DiscountCoupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ShippingCharge;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $discount = 0;


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

        $subTotal = Cart::subtotal(2, '.', '');

        // Apply Discount if the session has the discount code
        if (session()->has('code')) {
            $code = session()->get('code');

            if ($code->type == 'percent') {
                // Calculate percentage discount
                $discount = ($code->discount_amount / 100) * $subTotal;
            } else {
                // Fixed discount amount
                $discount = $code->discount_amount;
            }
        }

        // Calculate Shipping Here...
        if ($customerAddress != '') {
            $userCountry = $customerAddress->country_id;
            $shippingInfo = ShippingCharge::where('country_id', $userCountry)->first();

            if ($shippingInfo !== null) {
                // Only proceed if shippingInfo is found
                $totalQty = 0;
                $totalShippingCharge = 0;
                $grandTotal = 0;

                foreach (Cart::content() as $item) {
                    $totalQty += $item->qty;
                }

                $totalShippingCharge = $totalQty * $shippingInfo->amount;
                $grandTotal = ($subTotal - $discount) + $totalShippingCharge;
            } else {
                // Handle the case where no shipping information is found
                // You might want to set a default shipping charge or an error message
                $totalShippingCharge = 0;
                $grandTotal = ($subTotal - $discount); // No shipping charge if no information is found
                // Optionally, you can log or notify that no shipping info was found for the country
            }
        } else {
            $grandTotal = ($subTotal - $discount);
            $totalShippingCharge = 0;
        }


        return view('front.checkout', [
            'countries' => $countries,
            'customerAddress' => $customerAddress,
            'totalShippingCharge' => $totalShippingCharge,
            'discount' => $discount,
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

            $discountCodeId = NULL;
            $promoCode = '';
            $shipping = 0;
            $discount = 0;
            $subTotal = Cart::subtotal(2, '.', '');
            $grandTotal = $subTotal + $shipping;

            // Apply Discount if the session has the discount code
            if (session()->has('code')) {
                $code = session()->get('code');

                if ($code->type == 'percent') {
                    // Calculate percentage discount (assumes discount_amount is stored as whole number)
                    $discount = ($code->discount_amount / 100) * $subTotal;
                } else {
                    // Fixed discount amount
                    $discount = (float) $code->discount_amount;
                }

                $discountCodeId = $code->id;
                $promoCode = $code->code;

                // Calculate Shipping
                $shippingInfo = ShippingCharge::where('country_id', $request->country)->first();

                $totalQty = 0;
                foreach (Cart::content() as $item) {
                    $totalQty += $item->qty;
                }

                if ($shippingInfo != null) {

                    $shipping = $totalQty * $shippingInfo->amount;

                    $grandTotal = ($subTotal - $discount) + $shipping;



                } else {
                    $shippingInfo = ShippingCharge::where('country_id', 'rest_of_world')->first();

                    $shipping = $totalQty * $shippingInfo->amount;

                    $grandTotal = ($subTotal - $discount) + $shipping;

                }

            }


            $order = new Order;
            $order->subtotal = $subTotal;
            $order->shipping = $shipping;
            $order->grand_total = $grandTotal;
            $order->discount = $discount;
            $order->coupon_code_id = $discountCodeId;
            $order->coupon_code = $promoCode;
            $order->payment_status = 'not paid';
            $order->status = 'pending';
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

                // Update Product Stock.
                $productData = Product::find($item->id);
                if ($productData->track_qty == 'Yes') {
                    $currentQty = $productData->qty;
                    $updatedQty = $currentQty - $item->qty;
                    $productData->qty = $updatedQty;
                    $productData->save();
                }

            }

            // Send Order E-mail
            orderEmail($order->id, 'customer');

            $message = 'You have a Successfully Order Placed...! ';
            session()->flash('success', $message);

            Cart::destroy();
            session()->forget('code');

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
        // Ensure subtotal is treated as a float for calculations
        $subTotal = (float) str_replace(',', '', Cart::subtotal(2, '.', ''));
        $discount = 0;  // Initialize discount
        $discountString = ''; // Initialize discountString

        // Apply Discount if the session has the discount code
        if (session()->has('code')) {
            $code = session()->get('code');

            if ($code->type == 'percent') {
                // Calculate percentage discount (discount_amount should be stored as whole number)
                $discount = ($code->discount_amount / 100) * $subTotal;
            } else {
                // Fixed discount amount
                $discount = (float) $code->discount_amount;
            }

            // Prepare discount string with a remove button
            $discountString = '
                <div class="mt-4 text-center d-flex justify-content-center align-items-center" id="discount-response">
                    <strong class="me-2">' . $code->code . ' </strong>
                    <a class="btn btn-sm btn-danger" id="remove-discount"><i class="fa fa-times"></i></a>
                </div>';
        }

        // Calculate total based on country ID
        if ($request->country_id > 0) {
            $shippingInfo = ShippingCharge::where('country_id', $request->country_id)->first();
            $totalQty = Cart::content()->sum('qty');

            // Calculate shipping charge
            $ShippingCharge = $shippingInfo ? $totalQty * $shippingInfo->amount : 0;

            // If no specific country found, apply default shipping charge
            if (!$shippingInfo) {
                $shippingInfo = ShippingCharge::where('country_id', 'rest_of_world')->first();
                $ShippingCharge = $totalQty * $shippingInfo->amount;
            }

            // Calculate grand total: (Subtotal - Discount) + ShippingCharge
            $grandTotal = ($subTotal - $discount) + $ShippingCharge;

            // Return the JSON response with the calculated values
            return response()->json([
                'status' => true,
                'grandTotal' => number_format($grandTotal, 2),
                'discount' => number_format($discount, 2),
                'discountString' => $discountString,
                'ShippingCharge' => number_format($ShippingCharge, 2)
            ]);
        } else {
            // Calculate total without shipping if no country_id
            return response()->json([
                'status' => true,
                'grandTotal' => number_format(($subTotal - $discount), 2),
                'discount' => number_format($discount, 2),
                'discountString' => $discountString,
                'ShippingCharge' => number_format(0, 2)
            ]);
        }
    }
    public function applyDiscount(Request $request)
    {
        $code = DiscountCoupon::where('code', $request->code)->first();

        if (!$code) {
            $message = 'Invalid Discount Coupon Code...!';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // Check if coupon is valid based on start and end dates
        $now = Carbon::now();

        if ($code->starts_at && $now->lt(Carbon::parse($code->starts_at))) {
            return response()->json([
                'status' => false,
                'message' => 'Discount Coupon has not started yet...!'
            ]);
        }

        if ($code->expires_at && $now->gt(Carbon::parse($code->expires_at))) {
            return response()->json([
                'status' => false,
                'message' => 'Discount Coupon has expired...!'
            ]);
        }

        // Max usage checks
        if ($code->max_uses > 0 && Order::where('coupon_code_id', $code->id)->count() >= $code->max_uses) {
            return response()->json([
                'status' => false,
                'message' => 'Discount Coupon usage limit reached...!'
            ]);
        }

        // Max usage per user check
        if ($code->max_uses_user > 0 && Order::where(['coupon_code_id' => $code->id, 'user_id' => Auth::user()->id])->count() >= $code->max_uses_user) {
            return response()->json([
                'status' => false,
                'message' => 'You have already used this Discount Coupon...!'
            ]);
        }

        // Minimum amount check
        $subTotal = (float) str_replace(',', '', Cart::subtotal(2, '.', ''));
        if ($code->min_amount > 0 && $subTotal < $code->min_amount) {
            return response()->json([
                'status' => false,
                'message' => 'Minimum cart total must be ₹. ' . $code->min_amount . ' to apply this coupon.',
            ]);
        }

        // Store the discount code in the session
        session()->put('code', $code);

        // Return the order summary after applying the discount
        return $this->getOrderSummery($request);
    }
    public function removeCoupon(Request $request)
    {
        session()->forget('code');
        return $this->getOrderSummery($request);
    }
}
