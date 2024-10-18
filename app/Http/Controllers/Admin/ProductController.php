<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::latest('id')->with('product_images');

        if ($request->get('keyword') != "") {
            $products = $products->where('title', 'like', '%' . $request->keyword . '%');
        }

        $products = $products->paginate(10);
        //dd($products);
        $data['products'] = $products;
        //dd($products);
        return view('admin.products.list', $data);  // Replace 'products.index' with your Blade view
    }
    public function create()
    {
        $data = [];

        // Fetch only active categories
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();

        // Fetch all brands (if you want to keep this as is)
        $brands = Brand::orderBy('name', 'ASC')->get();
        $brands = Brand::where('status', 1)->orderBy('name', 'ASC')->get(); // Fetch only active brands

        // Pass the filtered categories and brands to the view
        $data['categories'] = $categories;
        $data['brands'] = $brands;


        return view('admin.products.create', $data);
    }
    public function getSubCategories(Request $request)
    {
        $categoryId = $request->input('category_id');

        // Fetch only active sub-categories for the selected category
        $subCategories = SubCategory::where('category_id', $categoryId)
            ->where('status', 1) // Ensure only active sub-categories are fetched
            ->orderBy('name', 'ASC')
            ->get();

        return response()->json(['subCategories' => $subCategories]);
    }
    public function store(Request $request)
    {
        // dd($request->image_array);
        // exit();
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'price' => 'required|numeric',
            'sku' => 'required|unique:products',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'image_array' => 'required|array', // Array of image ids
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $product = new Product;
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->shipping_returns = $request->shipping_returns;
            $product->short_description = $request->short_description;
            $product->save();



            // Handle the images and save them in product_images table
            if (!empty($request->image_array)) {
                foreach ($request->image_array as $image_id) {
                    // Retrieve image from TempImage model
                    $tempImageInfo = TempImage::find($image_id);

                    if ($tempImageInfo) {
                        // Get file extension and generate new image name
                        $extArray = explode('.', $tempImageInfo->name);
                        $ext = last($extArray);
                        $imageName = $product->id . '-' . time() . '.' . $ext;

                        // Define the destination path for the image
                        $destPath = 'uploads/product/large/' . $imageName;

                        // Move the image from temp folder to the final destination
                        $sourcePath = public_path('temp/' . $tempImageInfo->name);
                        $finalPath = public_path($destPath);
                        if (File::exists($sourcePath)) {
                            File::move($sourcePath, $finalPath);

                            // Create a new entry in the product_images table
                            $productImage = new ProductImage();
                            $productImage->product_id = $product->id;
                            $productImage->image = $imageName; // Save the path to the uploaded image
                            $productImage->sort_order = 0; // Add default sort_order if necessary
                            $productImage->save();
                        }
                    }
                }
            }

            // Flash success message and return JSON response
            $request->session()->flash('success', 'Product Added Successfully...!');
            return response()->json([
                'status' => true,
                'message' => 'Product Added Successfully...!'
            ]);
        }

        // If validation fails, return errors
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }
    public function edit($id, Request $request)
    {

        // Fetch the product by ID
        $product = Product::findOrFail($id);

        if (empty($product)) {
            return redirect()->route('product.index')->with('error', 'Product Not found...!');
        }

        // Fetch the product by ID
        $product = Product::findOrFail($id); // Make sure you replace Product with your actual model

        // Fetch categories
        $categories = Category::orderBy('name', 'ASC')->get(); // Ensure the model is correct

        // Fetch brands
        $brands = Brand::orderBy('name', 'ASC')->get(); // Ensure the model is correct

        // Fetch product images
        $productImages = ProductImage::where('product_id', $product->id)->get(); // Adjust as per your DB schema

        
        // Fatch Related Product
        if ($product->related_products != '') {
            $productArray = explode(',',$product->related_products);

            $relatedProducts = Product::whereIn('id',$productArray)->get();
        }


        // Fetch subcategories based on the product's category_id
        $subCategories = SubCategory::where('category_id', $product->category_id)->get();

        // Debugging output
        //dd($subCategories); // Remove this line in production code
        $data['product'] = $product;  // Assign product to the array
        $data['subCategories'] = $subCategories;  // Assign product to the array
        $data['productImages'] = $productImages;  // Assign product to the array
        $data['relatedProducts'] = $relatedProducts;  // Assign Related Product to the array


        // Fetch other required data (e.g., categories, brands, etc.)
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();

        $data['categories'] = $categories;  // Add categories to the array
        $data['brands'] = $brands;  // Add brands to the array
        // Return the view with the product, categories, brands, and subcategories
        return view('admin.products.edit', compact('product', 'productImages', 'categories', 'brands', 'subCategories','relatedProducts'));
    }
    public function update($id, Request $request)
    {
        // Retrieve the product using the product_id from the request
        //$product = Product::find($request->product_id);

        $product = Product::find($id);
        // dd($request->image_array);
        // exit();
        $rules = [
            'title' => 'required',
            'slug' => [
                'required',
                Rule::unique('products')->ignore($product->id)
            ],
            'price' => 'required|numeric',
            'sku' => [
                'required',
                Rule::unique('products')->ignore($product->id)
            ],
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No',
            'image_array' => 'required|array', // Array of image ids
        ];

        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->sku = $request->sku;
            $product->barcode = $request->barcode;
            $product->track_qty = $request->track_qty;
            $product->qty = $request->qty;
            $product->status = $request->status;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->shipping_returns = $request->shipping_returns;
            $product->short_description = $request->short_description;
            $product->related_products = !empty($request->related_products) 
            ? implode(',', $request->related_products) 
            : null;
            $product->save();

            //related_products
            // Flash success message and return JSON response
            $request->session()->flash('success', 'Product Updated Successfully...!');
            return response()->json([
                'status' => true,
                'message' => 'Product Updated Successfully...!'
            ]);
        } else {
            // If validation fails, return errors
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        // Initialize an array to store saved images for the response
        //$savedImages = [];

        if (!empty($request->image_array)) {
            foreach ($request->image_array as $image_id) {
                // Retrieve image from TempImage model
                $tempImageInfo = TempImage::find($image_id);

                if ($tempImageInfo) {
                    // Get file extension and generate new image name
                    $ext = pathinfo($tempImageInfo->name, PATHINFO_EXTENSION);
                    $imageName = $product->id . '-' . time() . '.' . $ext;

                    // Define the destination path for the image
                    $destPath = 'uploads/product/large/' . $imageName;

                    // Move the image from temp folder to the final destination
                    $sourcePath = public_path('temp/' . $tempImageInfo->name);
                    $finalPath = public_path($destPath);

                    if (File::exists($sourcePath)) {
                        // Move the file
                        File::move($sourcePath, $finalPath);

                        // Check if the image already exists in the product_images table
                        $productImage = ProductImage::firstOrNew(['id' => $image_id]);

                        // If it's a new entry, set additional fields
                        if (!$productImage->exists) {
                            $productImage->product_id = $product->id;
                            $productImage->sort_order = 0; // Default sort_order
                        }

                        // Update image name and save
                        $productImage->image = $imageName;
                        $productImage->updated_at = now(); // Refresh updated_at timestamp
                        $productImage->save();

                        // Store the saved image details for the response
                        $savedImages[] = [
                            'image_id' => $productImage->id,
                            'ImagePath' => asset('uploads/product/large/' . $imageName),
                        ];
                    } else {
                        \Log::error("Source image not found: " . $sourcePath);
                    }
                } else {
                    \Log::error("Temp image not found for ID: " . $image_id);
                }
            }

            // Flash a success message to the session
            $request->session()->flash('success', 'Images saved/updated successfully.');

            // Return a JSON response with all saved images
            return response()->json([
                'status' => true,
                'saved_images' => $savedImages,
                'message' => 'Images saved successfully.',
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'No images provided for upload.']);
        }

    }
    public function destroy($id, Request $request)
    {
        // Log the attempt to delete the product
        \Log::info("Attempting to delete product ID: $id");

        // Find the product by ID
        $product = Product::find($id);
        if (!$product) {
            // Log the error if the product is not found
            \Log::error("Product not found: $id");
            return response()->json(['status' => false, 'message' => 'Product not found.'], 404);
        }

        // Handle the deletion of associated product images if necessary
        $productImages = ProductImage::where('product_id', $id)->get();
        foreach ($productImages as $productImage) {
            // Delete the image file from storage
            File::delete(public_path('uploads/product/large/' . $productImage->image));
        }

        // Delete the product images from the database
        ProductImage::where('product_id', $id)->delete();

        // Delete the product
        $product->delete();

        // Log the successful deletion
        \Log::info("Product deleted successfully: $id");

        // Return a JSON response
        $request->session()->flash('success', 'Product Deleted Successfully...!');
        return response()->json(['status' => true, 'message' => 'Product deleted successfully!']);
    }

    public function getProducts(Request $request)
    {

        $tempProduct = []; // Initialize as an empty array

        if (!empty($request->term)) {
            $products = Product::where('title', 'like', '%' . $request->term . '%')->get();

            if ($products->isNotEmpty()) {
                foreach ($products as $product) {
                    $tempProduct[] = [
                        'id' => $product->id,
                        'text' => $product->title
                    ];
                }
            }
        }

        return response()->json([
            'tags' => $tempProduct,
            'status' => true
        ]);
    }
}
