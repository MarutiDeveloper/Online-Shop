<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artisan;

class HomeController extends Controller
{
    public function clearCache()
    {        
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        return 'Cache Cleared now , go back';
    }
    public function index(){
        return view('admin.dashboard');
        // $admin = Auth::guard('admin')->user();
        // echo 'Welcome'.$admin->name. ' <a href=" '.route('admin.logout').' " >Logout</a>';
    }
    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
       }
}
