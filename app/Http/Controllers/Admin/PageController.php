<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
  public function index(Request $request)
  {
    // Fetch pages with optional search keyword and order by created_at in ascending order
    $query = Page::orderBy('created_at', 'ASC');

    if (!empty($request->keyword)) {
      $query->where('name', 'like', '%' . $request->keyword . '%');
    }

    // Paginate the results
    $pages = $query->paginate(10);

    // Return the view with paginated pages
    return view('admin.pages.list', [
      'pages' => $pages,
    ]);
  }
  public function create()
  {
    return view('admin.pages.create');
  }
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'slug' => 'required'
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'errors' => $validator->errors()
      ]);
    }

    $page = new Page;
    $page->name = $request->name;
    $page->slug = $request->slug;
    $page->content = $request->content;
    $page->save();

    $message = 'Pages store Successfully';
    session()->flash('success', $message);
    return response()->json([
      'status' => true,
      'message' => $message
    ]);
  }
  public function edit($id)
  {
    $page = Page::findOrFail($id);
    if ($page == null) {
      session()->flash('error', 'Page Not found.');
      return redirect()->route('pages.index');
    }
    return view('admin.pages.edit', [
      'page' => $page
    ]);
  }
  public function update(Request $request, $id)
  {
    $page = Page::findOrFail($id);

    if ($page == null) {

      $message = 'Page Not found';
      session()->flash('error', $message);
      return response()->json([
        'status' => false,
        'message' => $message
      ]);
    }

    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'slug' => 'required'
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'errors' => $validator->errors()
      ]);
    }


    $page->name = $request->name;
    $page->slug = $request->slug;
    $page->content = $request->content;
    $page->save();

    $message = 'Pages Updated Successfully';
    session()->flash('success', $message);
    return response()->json([
      'status' => true,
      'message' => $message
    ]);
  }
  public function destroy($id)
  {
    $page = Page::findOrFail($id);

    if ($page == null) {

      $message = 'Page Not found';
      session()->flash('error', $message);
      return response()->json([
        'status' => false,
        'message' => $message
      ]);
    }
    $page->delete();
    $message = 'Pages Deleted Successfully';
    session()->flash('success', $message);
    return response()->json([
      'status' => true,
      'message' => $message
    ]);
  }
}
