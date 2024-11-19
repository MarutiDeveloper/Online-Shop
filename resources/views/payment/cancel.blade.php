@extends('front.layouts.app')

@section('content')
<section class="container" style="font-family: 'Times New Roman', Times, serif; font-weight: bold ;">
    <div class="col-md-12 text-center py-5">

        @if (Session::has('error'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif

        <h1  class="alert alert-danger">Please Check Your Order is Not Confirm...! </h1>
        <hr><br>
     
        <!-- <a href="{{route('front.home')}}"  class="btn btn-outline-light btn-primary">Back To home</a> -->
        <a style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight:bolder ;"
            class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('front.home')}}">Back To home</a>
    </div>

</section>
@endsection