<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index () {

    }
    public function create () {
        return view('admin.pages.create');
    }
    public function store (Request $request) {
        $validator = Validator::make($request->all(),[
            'name'  =>  'required',
            'slug'  =>  'required'
        ]);
        if ($validator->fails()) {
          return response()->json([
            'status'    =>  false,
            'errors'    =>  $validator->errors()
          ]);
        }
    }
    public function edit () {

    }
    public function update () {

    }
    public function destroy () {

    }
}
