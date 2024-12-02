<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use App\Models\ContactUs;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function clearCache()
    {
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        return redirect()->back()->with('success', 'You have Successfully Cashclear !');
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
                'message' => '<div class="alert alert-danger"> Product Not found..!</div>'
            ]);
        }

        wishlist::updateOrCreate(
            [
                'user_id' => Auth::user()->id,  // Corrected field
                'product_id' => $productId
            ],
            [
                'user_id' => Auth::user()->id,  // Corrected field
                'product_id' => $productId
            ]
        );


        // Correct typo here: 'uder_id' to 'user_id'
        // $wishlist = new Wishlist();
        // $wishlist->user_id = Auth::user()->id;  // Corrected field
        // $wishlist->product_id = $productId;
        // $wishlist->save();

        return response()->json([
            'status' => true,  // Product successfully added
            'message' => '<div class="alert alert-success"> <strong>"' . $product->title . '"</strong> Added in Your Wish List</div>'
        ]);
    }
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->first();
        if ($page == null) {
            abort(404);
        }
        //dd($page);
        return view('front.page', [
            'page' => $page
        ]);
    }
    public function sendContactEmail(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required|min:10',
        ]);
       
    
        if ($validator->passes()) {
            // Prepare mail data
            $mailData = [
                'name'         => $request->name,
                'email'        => $request->email,
                'subject'      => $request->subject,
                'message'      => $request->message,
                'mail_subject' => 'You have received an email from the Contact Us page.',
            ];
    
            // Fetch the admin's email
            $admin = User::where('role', '2')->first(); // Assuming admin has ID 1
            if ($admin && $admin->email) {
                try {
                    Mail::to($admin->email)->send(new ContactEmail($mailData));
                    // Redirect to the home page with a success message
                    return redirect()->route('front.home')->with('success', 'Your message has been sent successfully!');
                } catch (\Exception $e) {
                    \Log::error('Mail sending error: ' . $e->getMessage());
                    return redirect()->route('front.home')->with('error', 'Failed to send your message. Please try again.');
                }
            } else {
                \Log::error('Admin user with ID 1 not found or email is missing.');
                return redirect()->route('front.home')->with('error', 'Admin email not found.');
            }
        } else {
            return redirect()->route('front.home')->withErrors($validator)->withInput();
        }
    }
}
