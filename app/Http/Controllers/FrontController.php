<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Artisan;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    public function clearCache()
    {
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        return 'Cache Cleared now , go back';
    }
    public function index()
    {

        $products = Product::with('brand')->get(); // Retrieve products with their associated brands

        $products = Product::where('is_featured', 'Yes')->orderBy('id', 'ASC')->take(8)->where('status', 1)->get();
        $data['featuredProducts'] = $products;

        $latestProducts = Product::orderBy('id', 'DESC')->where('status', 1)->take(8)->get();

        $data['latestProducts'] = $latestProducts;

        return view('front.home', $data);
    }
    public function showFooter($id)
    {
        // Fetch all contact records
        $allContactInfo = ContactUs::all();
        dd($allContactInfo); // This will output the data for debugging
        return view('front.home', compact('contactInfo'));
    }
    public function addToWishlist(Request $request)
    {


        if (Auth::check() == false) {
            return response()->json([
                'status' => false,  // User not authenticated
            ]);
        }

        $productId = $request->id;

        $product = Product::where('id', $request->id)->first();

        if ($product == null) {
            return response()->json([
                'status' => true,  // Product successfully added
                'message'   =>  '<div class="alert alert-danger"> Product Not found..!</div>'
            ]);
        }

        wishlist::updateOrCreate(
            [
                'user_id'   =>  Auth::user()->id,  // Corrected field
                'product_id'   => $productId
            ],
            [
                'user_id'   =>  Auth::user()->id,  // Corrected field
                'product_id'   => $productId
            ]
        );


        // Correct typo here: 'uder_id' to 'user_id'
        // $wishlist = new Wishlist();
        // $wishlist->user_id = Auth::user()->id;  // Corrected field
        // $wishlist->product_id = $productId;
        // $wishlist->save();

        return response()->json([
            'status' => true,  // Product successfully added
            'message'   =>  '<div class="alert alert-success"> <strong>"'.$product->title.'"</strong> Added in Your Wish List</div>'
        ]);

      
    }
}
