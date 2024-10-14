<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::latest('id');

        if ($request->get('keyword')) {
            $brands = $brands->where('name', 'like', '%' . $request->keyword . '%');
        }

        $brands = $brands->paginate(10);

        return view('admin.brands.list', compact('brands'));
    }
    public function create()
    {
        return view('admin.brands.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands',
        ]);

        if ($validator->passes()) {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            $request->session()->flash('success', 'Brand Addes Successfully...!');
            return response()->json([
                'status' => true,
                'message' => 'Brand Addes Successfully...!'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit($id, Request $request)
    {
        $brand = Brand::find($id);

        if (empty($brand)) {
            $request->session()->flash('error', 'Record Not found...!');
            return redirect()->route('brands.index');
        }

        $data['brand'] = $brand;
        return view('admin.brands.edit', $data);

    }
    public function update($id, Request $request)
    {

        $brand = Brand::find($id);

        if (empty($brand)) {
            $request->session()->flash('error', 'Record Not found...!');
            return response()->json([
                'status' => false,
                'notFound' => true,
            ]);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,' . $brand->id . ',id',
        ]);

        if ($validator->passes()) {
           // $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            $request->session()->flash('success', 'Brand Updated Successfully...!');
            return response()->json([
                'status' => true,
                'message' => 'Brand Updated Successfully...!'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function  destroy($id, Request $request){
        $brand = Brand::find($id);
        if (empty( $brand)) {
            $request->session()->flash('error', 'Brand Not Found...!');
            return response()->json([
                'status' => true,
                'message' => 'Brand Not Found...!'
            ]);
            //return redirect()->route('categories.index');
        }

        $brand->delete();

        $request->session()->flash('success', 'Brand Deleted Successfully...!');

        return response()->json([
            'status' => true,
            'message' => 'Brand Deleted Successfully...!'
        ]);
    }
}
