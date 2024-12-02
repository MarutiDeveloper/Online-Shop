<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\category;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
    {

        $categorySelected = '';
        $subCategorySelected = '';
        $brandsArray = [];



        $categories = category::orderBy('name', 'ASC')->with('sub_category')->where('status', 1)->get();
        $brands = Brand::orderBy('name', 'ASC')->where('status', 1)->get();

        $products = Product::where('status', 1);

        //Apply Filters here
        if (!empty($categorySlug)) {
            $category = category::where('slug', $categorySlug)->first();
            $products = $products->where('category_id', $category->id);
            $categorySelected = $category->id;
        }

        if (!empty($subCategorySlug)) {
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = $products->where('sub_category_id', $subCategory->id);
            $subCategorySelected = $subCategory->id;
        }

        if (!empty($request->get('brand'))) {
            $brandsArray = explode(',', $request->get('brand'));
            $products = $products->whereIn('brand_id', $brandsArray);
        }

        if ($request->get('price_max') != '' && $request->get('price_min') != '') {

            if ($request->get('price_max') == 10000) {
                $products = $products->whereBetween('price', [intval($request->get('price_min')), 1000000]);
            } else {
                $products = $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);
            }

        }

        if (!empty($request->get('search'))) {
            $products = $products->where('title', 'like', '%'.$request->get('search').'%');
        }

        //$products = Product::orderBy('id', 'DESC')->where('status', 1)->get();


        if ($request->get('sort') != '') {
            if ($request->get('sort') == 'latest') {
                // $products = $products->orderBy('id', 'DESC');
                $products = $products->orderBy('id', 'DESC');
            } elseif ($request->get('sort') == 'price_asc') {
                $products = $products->orderBy('price', 'ASC');
            } else {
                $products = $products->orderBy('price', 'DESC');
            }
        } else {
            $products = $products->orderBy('id', 'DESC');
        }


        $products = $products->paginate(6);

        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;
        $data['subCategorySelected'] = $subCategorySelected;
        $data['brandsArray'] = $brandsArray;
        $data['priceMax'] = (intval($request->get('price_max')) == 0) ? 10000 : $request->get('price_max');
        $data['priceMin'] = intval($request->get('price_min'));
        $data['sort'] = $request->get('sort');


        return view('front.shop', $data);
    }

    public function product($slug)
    {
        //$slug;
        $product = Product::where('slug', $slug)
                                        ->withCount('product_ratings')
                                        ->withSum('product_ratings', 'rating')
                                        ->with(['product_images', 'product_ratings'])->first();
        //dd($product);
        if ($product == null) {
            abort(404);
        }
        //dd($product);
        // Fetch Related Products
        $relatedProducts = []; // Initialize as an empty array

        if (!empty($product->related_products)) {
            $productArray = explode(',', $product->related_products);
            $relatedProducts = Product::whereIn('id', $productArray)->where('status', 1)->get();
        }

        $avgRating = '0.00';
        $avgRatingPer = 0;
        if ($product->product_ratings_count > 0) {
            $avgRating = number_format(
                ($product->product_ratings_sum_rating / $product->product_ratings_count), 
                2
            );
            $avgRatingPer = ($avgRating*100)/5;
        }
       

        $data = [
            'product' => $product,
            'relatedProducts' => $relatedProducts, // Assign Related Products to the array
            'avgRating' => $avgRating, // Assign Rating Product Average.
            'avgRatingPer' => $avgRatingPer, // Assign Rating Product Average.
        ];

        // Rating Calculation.
        // "product_ratings_count" => 3
        // "product_ratings_sum_rating" => "10.00"

       
        

        return view('front.product', $data);
    }
    public function saveRating ($id,Request $request) {
        $validator = Validator::make($request->all(),[
            'name'  =>  'required|min:5',
            'email' =>  'required|email',
            'comment'   => 'required|min:5',
            'rating'    =>  'required'

        ]);

        if($validator->fails()) {
            return response()->json([
                'status'    =>  false,
                'errors'    =>  $validator->errors()
            ]);
        }

        $count = ProductRating ::where('email', $request->email)->count();

        if ($count > 0) {
            session()->flash('error', 'You have already give your Rating for this Product. !');
            return response()->json([
                'status'    =>  true,
            ]);
        }

        $productRating = new ProductRating;
        $productRating->product_id = $id;
        $productRating->username = $request->name;
        $productRating->email = $request->email;
        $productRating->comment = $request->comment;
        $productRating->rating = $request->rating;
        $productRating->status = 0;
        $productRating->save();

        session()->flash('success', 'Thanks for your Rating !');

        return response()->json([
            'status'    =>  true,
            'message'    =>  'Thanks for your Rating !'
        ]);
    }
}
