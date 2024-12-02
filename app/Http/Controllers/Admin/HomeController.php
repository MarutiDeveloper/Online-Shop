<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\TempImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Artisan;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function clearCache()
    {
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        //return 'Cache Cleared now , go back';
        return redirect()->back()->with('success', 'You have Successfully Cash Clear !');
    }
    public function index()
    {

        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 1)
            ->where('status', 1)
            ->count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('grand_total');

        // This Month Revenue.
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');

        $revenueThisMonth = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $startOfMonth)
            ->whereDate('created_at', '<=', $currentDate)
            ->sum('grand_total');

        // Last Months Revenue.
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonthName = Carbon::now()->subMonth()->startOfMonth()->format('F');

        $revenueLastMonth = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $lastMonthStartDate)
            ->whereDate('created_at', '<=', $lastMonthEndDate)
            ->sum('grand_total');

        // Last 30 Days Revenue.
        $lastThirthDaySatartDate = Carbon::now()->subDays(30)->format('Y-m-d');
        $revenueLastThirtyDays = Order::where('status', '!=', 'cancelled')
            ->whereDate('created_at', '>=', $lastThirthDaySatartDate)
            ->whereDate('created_at', '<=', $currentDate)
            ->sum('grand_total');

        // Delete Temp Images Here...
        $dayBeforeToday = Carbon::now()->subDays(1)->format('Y-m-d H:i:s');
        // dd($dayBeforeToday); // Uncomment this if you want to debug the date
        $tempImages = TempImage::where('created_at', '<=', $dayBeforeToday)->get();

        foreach ($tempImages as $tempImage) {
            // echo $tempImage->created_at . '====' . $tempImage->id;  // Corrected the typo here
            // echo "<br>";
            $path = public_path('/temp'.$tempImage->name);
            // Delete Main Image....
            if (File::exists($path)) {
               File::delete($path);
            }
            TempImage::where('id', $tempImage->id)->delete();
            
            
        }

        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'totalRevenue' => $totalRevenue,
            'revenueThisMonth' => $revenueThisMonth,
            'revenueLastMonth' => $revenueLastMonth,
            'revenueLastThirtyDays' => $revenueLastThirtyDays,
            'lastMonthName' => $lastMonthName,
        ]);

    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
