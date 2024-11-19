<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::latest();

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $users = $users->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%');
            });
        }
        $users = $users->paginate(10);
        return view('admin.users.list', [
            'users' => $users
        ]);

    }
    public function create(Request $request)
    {
        return view('admin.users.create', [

        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'phone' => 'required'
        ]);

        if ($validator->passes()) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->status = $request->status;
            $user->save();

            $message = 'You have Successfully Created New User';
            session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user == null) {

            $message = 'User Not found...!';
            session()->flash('error', $message);
            return redirect()->route('users.index');
        }

        return view('admin.users.edit', [
            'user' => $user
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user == null) {

            $message = 'User Not found...!';
            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required'
        ]);

        if ($validator->passes()) {

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if ($request->password != '') {
                $user->password = Hash::make($request->password);
            }

            $user->status = $request->status;
            $user->save();

            $message = 'You have Successfully Updated User';
            session()->flash('success', $message);
            return response()->json([
                'status' => true,
                'message' => $message
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
