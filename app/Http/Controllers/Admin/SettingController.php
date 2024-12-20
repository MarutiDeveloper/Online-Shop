<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('admin.change-password');
    }

    public function processChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'conf_password' => 'required|same:new_password'
        ]);

        $admin = User::where('id', Auth::guard('admin')->user()->id)->first();

        if ($validator->passes()) {

            if (!Hash::check($request->old_password, $admin->password)) {
                session()->flash('error', 'Your Old Password has been Wrong Please Check...');
                return response()->json([
                    'status' => true,
                ]);
            }

            User::where('id', Auth::guard('admin')->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            session()->flash('success', 'Your  Password has been Updated successfully Please Check.');
            return response()->json([
                'status' => true,
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
