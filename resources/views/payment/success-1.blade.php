@extends('front.layouts.app')

@section('content')
<section class="container" style="font-family: 'Times New Roman', Times, serif; font-weight: bold ;">
 
    <div class="col-md-12 text-center py-5">

        <!-- @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif -->

        <h1>Thank you ! for Shopping ...! </h1>
        <hr><br>
        @include('front.account.common.message')
        <h1>You have Successfully Payment...! </h1>
   
       
        <!-- <h4>Product Name(s): </h4> Display Product Names  Display the Product Name -->

        <!-- <a href="{{route('front.home')}}"  class="btn btn-outline-light btn-primary">Back To home</a> -->
        <a style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight:bolder ;"
            class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.home')}}">Back To home</a>
    </div>

</section>
@endsection