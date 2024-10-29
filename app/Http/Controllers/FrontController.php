<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(){

        $products = Product::with('brand')->get(); // Retrieve products with their associated brands

        $products = Product::where('is_featured', 'Yes')->orderBy('id', 'ASC')->take(8)->where('status', 1)->get();
        $data['featuredProducts'] =  $products;

        $latestProducts = Product::orderBy('id', 'DESC')->where('status', 1)->take(8)->get();

        $data['latestProducts'] =  $latestProducts;

        return view('front.home', $data);
    }
    public function showFooter($id)
    {
         // Fetch all contact records
         $allContactInfo = ContactUs::all();
        dd($allContactInfo); // This will output the data for debugging
        return view('front.home', compact('contactInfo'));
    }
}
