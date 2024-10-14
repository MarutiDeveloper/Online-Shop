<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\category;
use Intervention\Image\Facades\Image; // Make sure to import the Image facade
use Session;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::latest();

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $categories = $categories->where('name', 'like', '%' . $keyword . '%');
        }

        $categories = $categories->paginate(10);

        // $data['categories'] = $categories;
        return view('admin.category.list', compact('categories'));
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if ($validator->passes()) {
            $category = new Category(); // Ensure class name is properly capitalized
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status; // Ensure this field exists in your request
            $category->save();


            // Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);

                if ($tempImage) { // Check if the temp image was found
                    $extArray = explode('.', $tempImage->name);
                    $ext = end($extArray); // Use end() to get the last element (file extension)

                    $newImageName = $category->id . '.' . $ext;
                    $sPath = public_path('temp/' . $tempImage->name);
                    $dPath = public_path('uploads/category/' . $newImageName); // Fixed the way to concatenate new image name

               
                    // Ensure the temp file exists before copying
                    if (file_exists($sPath)) {
                        File::copy($sPath, $dPath);
                    } else {
                        // Handle the case where the source file doesn't exist
                        // You might want to log an error or return a response
                        \Log::error("Source image not found: " . $sPath);
                    }
                } else {
                    // Handle the case where the temp image was not found
                    \Log::error("Temp image not found for ID: " . $request->image_id);
                }

                $category->image = $newImageName; // Ensure this field exists in your request
                $category->save();
            }

            $request->session()->flash('success', 'Category added Successfully....!');

            return response()->json([
                'status' => true,
                'message' => 'Category added Successfully...!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($categoryId, Request $request)
    {
       
        $category = category::find($categoryId);
        if (empty($category)) {
            return redirect()->route('categories.index');
        }

        return view('admin.category.edit', compact('category'));
    }
    public function update($categoryId, Request $request)
    {

        $category = category::find($categoryId);
        if (empty($category)) {
            $request->session()->flash('error', 'Category not found..!');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found..!'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
           'slug' => 'required|unique:categories,slug,' . $category->id . ',id',
        ]);

        if ($validator->passes()) {
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status; // Ensure this field exists in your request
            $category->save();

            $oldImage = $category->image;


            // Save Image Here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);

                if ($tempImage) { // Check if the temp image was found
                    $extArray = explode('.', $tempImage->name);
                    $ext = end($extArray); // Use end() to get the last element (file extension)

                    $newImageName = $category->id .'-'.time(). '.' . $ext;
                    $sPath = public_path('temp/' . $tempImage->name);
                    $dPath = public_path('uploads/category/' . $newImageName); // Fixed the way to concatenate new image name

                    // Ensure the temp file exists before copying
                    if (file_exists($sPath)) {
                        File::copy($sPath, $dPath);
                        
                    } else {
                        // Handle the case where the source file doesn't exist
                        // You might want to log an error or return a response
                        \Log::error("Source image not found: " . $sPath);
                    }
                } else {
                    // Handle the case where the temp image was not found
                    \Log::error("Temp image not found for ID: " . $request->image_id);
                }

                $category->image = $newImageName; // Ensure this field exists in your request
                $category->save();

                // Delete old Images Here....
                File::delete(public_path().'/uploads/category/'.$oldImage);
            }

            $request->session()->flash('success', 'Category Updated Successfully....!');

            return response()->json([
                'status' => true,
                'message' => 'Category Updated Successfully...!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        if (empty( $category)) {
            $request->session()->flash('error', 'Category Not Found...!');
            return response()->json([
                'status' => true,
                'message' => 'Category Not Found...!'
            ]);
            //return redirect()->route('categories.index');
        }

        File::delete(public_path().'/uploads/category/'.$category->image);

        $category->delete();

        $request->session()->flash('success', 'Category Deleted Successfully...!');

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted Successfully...!'
        ]);
    }

}
