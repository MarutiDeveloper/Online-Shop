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
        // Validate the request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_array' => 'required|array',
            'image_array.*' => 'exists:temp_images,id',
        ]);

    
        // Retrieve the product using the product_id from the request
        $product = Product::find($request->product_id);

        // Initialize an array to store saved/updated images for the response
        $savedImages = [];

        // Check if the image array is provided
        if (!empty($request->image_array)) {
            foreach ($request->image_array as $image_id) {
                // Retrieve the TempImage model for the current image_id
                $tempImageInfo = TempImage::find($image_id);

                if ($tempImageInfo) {
                    // Check if the image already exists in the product_images table
                    $productImage = ProductImage::firstOrNew(['id' => $image_id]);

                    // If the image is newly created, set the product ID and default sort order
                    if (!$productImage->exists) {
                        $productImage->product_id = $product->id;
                        $productImage->sort_order = 0; // Default sort_order
                    }

                    // Generate a unique image name
                    $ext = pathinfo($tempImageInfo->name, PATHINFO_EXTENSION);
                    $imageName = $product->id . '-' . time() . '.' . $ext;

                    // Define the destination path for the image
                    $destPath = 'uploads/product/large/' . $imageName;

                    // Move the image from the temp folder to the final destination
                    $sourcePath = public_path('temp/' . $tempImageInfo->name);
                    $finalPath = public_path($destPath);

                    if (File::exists($sourcePath)) {
                        // Move the file
                        File::move($sourcePath, $finalPath);

                        // Update or set the image name in the product_images table
                        $productImage->image = $imageName;
                        $productImage->updated_at = now(); // Refresh updated_at timestamp
                        $productImage->save(); // Save the changes to the database

                        // Store the saved/updated image details for the response
                        $savedImages[] = [
                            'image_id' => $productImage->id,
                            'ImagePath' => asset($destPath),
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

            // Return a JSON response with all saved/updated images
            return response()->json([
                'status' => true,
                'saved_images' => $savedImages,
                'message' => 'Images saved successfully.',
            ]);
        } else {
            return response()->json(['status' => false, 'message' => 'No images provided for upload.']);
        }
    }

    public function destroy(Request $request)
    {
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
