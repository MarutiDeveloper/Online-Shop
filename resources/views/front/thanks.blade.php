@extends('front.layouts.app')

@section('content')
<section class="container" style="font-family: 'Times New Roman', Times, serif; font-weight: bold ;">
    <div class="col-md-12 text-center py-5">

        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        <h1>Thank you ! for Shopping ...! </h1><hr><br>
        <!-- <h3 id="order-id">Your Order Id Is: {{ $id}}</h3> Placeholder for Order ID -->
        <h3 id="order-id">Your Order Id Is: {{ $id }}</h3> <!-- Display the Order ID -->
        <!-- <h4>Product Name(s): </h4> Display Product Names <!-- Display the Product Name -->
        <ul>
            @foreach ($productNames as $productName)
                <li>{{ $productName }}</li> <!-- Display Product Name -->
            @endforeach
        </ul> 
    </div>

</section>
@endsection
@section('customJs')

@endsection