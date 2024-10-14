<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use App\Models\TempImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function update(Request $request)
    {
        // Retrieve the product using the product_id from the request
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Initialize an array to store saved/updated images for the response
        $savedImages = [];

        if (!empty($request->image_array)) {
            foreach ($request->image_array as $image_id) {
                // Check if the image already exists in the product_images table
                $productImage = ProductImage::find($image_id);

                if (!$productImage) {
                    // Create a new entry if the image ID is not found
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->sort_order = 0; // Default sort_order
                }

                // Retrieve the TempImage model for the current image_id
                $tempImageInfo = TempImage::find($image_id);

                if ($tempImageInfo) {
                    // Generate a unique image name
                    $ext = pathinfo($tempImageInfo->name, PATHINFO_EXTENSION);
                    $imageName = $product->id . '-' . time() . '.' . $ext;

                    // Define the destination path for the image
                    $destPath = 'uploads/product/large/' . $imageName;

                    // Move the image from the temp folder to the final destination
                    $sourcePath = public_path('temp/' . $tempImageInfo->name);
                    $finalPath = public_path($destPath);

                    if (File::exists($sourcePath)) {
                        File::move($sourcePath, $finalPath);

                        // Update or set the image name in the product_images table
                        $productImage->image = $imageName;
                        $productImage->updated_at = now(); // Ensure the updated_at column is refreshed
                        $productImage->save(); // Save the changes to the database

                        // Store the saved/updated image details for the response
                        $savedImages[] = [
                            'image_id' => $productImage->id,
                            'ImagePath' => asset('uploads/product/large/' . $productImage->image),
                        ];
                    }
                }
            }

            // Flash a success message to the session
            $request->session()->flash('success', 'Images Saved/Updated Successfully...!');

            // Return a JSON response with all saved/updated images
            return response()->json([
                'status' => true,
                'image_id' => $productImage->id,
                'ImagePath' => asset('uploads/product/large/' . $productImage->image),
                'message' => 'Image Saved Successfully...!'
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to upload image.']);

        }
    }
    public function destroy(Request $request){
        $productImage = ProductImage::find($request->id);

        if (empty($productImage)) {
            $request->session()->flash('error', 'Image Not Found...!');

            return response()->json([
                'status' => false,
                'message' => 'Image Not Found...!'
            ]);
        }

        //Delete Image From Folder
        File::delete(public_path('uploads/product/large/' . $productImage->image));

        $productImage->delete();
         // Flash a success message to the session
         $request->session()->flash('success', 'Image Deleted Successfully...!');

        return response()->json([
            'status' => true,
            'message' => 'Image Deleted Successfully...!'
        ]);
    }
}
