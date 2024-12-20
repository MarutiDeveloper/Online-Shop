<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $SubCategories = SubCategory::select('sub_categories.*', 'categories.name as categoryName')->
            latest('sub_categories.id')->
            leftJoin('categories', 'categories.id', 'sub_categories.category_id');

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $SubCategories = $SubCategories->where('sub_categories.name', 'like', '%' . $keyword . '%');
            $SubCategories = $SubCategories->orWhere('categories.name', 'like', '%' . $keyword . '%');
        }

        $SubCategories = $SubCategories->paginate(10);

        // $data['categories'] = $categories;
        return view('admin.sub_category.list', compact('SubCategories'));
    }
    public function create()
    {
        // Fetch only active categories
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get(); 
    
        // Pass the active categories to the view
        return view('admin.sub_category.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required'

        ]);

        if ($validator->passes()) {
            $subCategory = new SubCategory();
            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            $request->session()->flash('success', 'Sub-Category Created Successfully..!');
            return response([
                'status' => true,
                'message' => 'Sub-Category Created Successfully..!'
            ]);


        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id, Request $request)
    {

        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Record Not Found...!');
            return redirect()->route('sub-categories.index');
        }

        //echo "<h1>".$id."</h1>";

        $categories = category::orderBy('name', 'ASC')->get();

        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;
        return view('admin.sub_category.edit', $data);
    }
    public function update($id, Request $request)
    {

        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Record Not Found...!');
            return response([
                'status' => false,
                'notFound' => true
            ]);
            //return redirect()->route('sub-categories.index');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            //'slug' => 'required|unique:sub_categories',
            'slug' => 'required|unique:sub_categories,slug,' . $subCategory->id . ',id',
            'category' => 'required',
            'status' => 'required'

        ]);

        if ($validator->passes()) {

            $subCategory->name = $request->name;
            $subCategory->slug = $request->slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            $request->session()->flash('success', 'Sub-Category Updated Successfully..!');
            return response([
                'status' => true,
                'message' => 'Sub-Category Updated Successfully..!'
            ]);


        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy($id, Request $request)
    {

        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            $request->session()->flash('error', 'Record Not Found...!');
            return response([
                'status' => false,
                'notFound' => true
            ]);
        }

        $subCategory->delete();

        $request->session()->flash('success', 'Sub-Category Deleted Successfully..!');
        return response([
            'status' => true,
            'message' => 'Sub-Category Deleted Successfully..!'
        ]);
    }
}
