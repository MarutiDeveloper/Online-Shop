<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Illuminate\view\View;

class StripePaymentController extends Controller
{
   public function stripe () : View{
        return view('');
   }

}
