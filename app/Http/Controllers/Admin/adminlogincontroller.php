<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class adminlogincontroller extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required |email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

                $admin = Auth::guard('admin')->user();
                if ($admin->role == 2) {
                    return redirect()->route('admin.dashboard');
                } else {

                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', 'You are not authorize to access Admin Panel');
                }

            } else {
                return redirect()->route('admin.login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {
            return redirect()->route('admin.login')
                ->withErrors($validator)->withInput($request->only('email'));
        }

    }
    public function registration()
    {
        return view('admin.registration');
    }

    public function registerUsers(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12',
            'role' => 'required|in:1,2',  // Ensure role is either 1 or 2
        ]);
        // Create a new user instance
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);  // Hash the password
        // Save the user to the database
        $res = $user->save();

        // Optional: Check if the user was saved and return a response
        if ($res) {
            return redirect()->back()->with('success', 'User registered successfully');
        } else {
            return redirect()->back()->with('fail', 'Registration failed, try again');
        }

    }

}
