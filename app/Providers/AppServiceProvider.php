<?php

namespace App\Providers;

use App\Models\ContactUs;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

         // Fetch the first record from ContactUs table
      $contactInfo = ContactUs::first();

      // Share the contact info globally with all views
      view()->share('allContactInfo', $contactInfo);
    }
     
}
