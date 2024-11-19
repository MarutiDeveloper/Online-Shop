@extends('front.layouts.app')

@section('content')

<!-- Section----1 -->
<section class="section-5 pt-3 pb-3 mb-3 bg-white"
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile') }}">My Account</a>
                </li>
                <li class="breadcrumb-item">Order - Details</li>
            </ol>
        </div>
    </div>
</section>

<!-- Section----- 2 -->
<section class=" section-11 "
    style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header" style="font-family:'Times New Roman', Times, serif ;">
                        <h4 class="h4 mb-0 pt-2 pb-2">Order No: #01234-{{ $order->id }}</h4>
                    </div>

                    <div class="card-body pb-0">
                        <!-- Info -->
                        <div class="card card-sm">
                            <div class="card-body bg-light mb-3">
                                <div class="row">
                                    <div class="col-6 col-lg-3">
                                        <!-- Heading -->
                                        <h4 class="heading-xxxs text-muted">Order No:</h4>
                                        <!-- Text -->
                                        <h5>
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                #01234-{{ $order->id }}
                                            </p>
                                        </h5>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <!-- Heading -->
                                        <h4 class="heading-xxxs text-muted">Shipped date:</h4>
                                        <!-- Text -->
                                        <h5>
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                <time datetime="2019-10-01">
                                                    <td style="text-align: center;">
                                                            @if (!empty($order->shipped_date))
                                                                {{ \Carbon\Carbon::parse($order->shipped_date)->format('d M, Y') }}
                                                            @else
                                                                <span class="text-muted" style="color: red; font-weight: bold;">N/A</span>
                                                            @endif
                                                    </td>
                                                </time>
                                            </p>
                                        </h5>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <!-- Heading -->
                                        <h4 class="heading-xxxs text-muted">Status:</h4>
                                        <!-- Text -->
                                        <h6>
                                            <p class="mb-0 fs-sm fw-bold"
                                                style="font-family:'Times New Roman', Times, serif ;">
                                                @if ($order->status == 'pending')
                                                    <h5><span class="badge bg-danger">Pending</span></h5>
                                                @elseif ($order->status == 'shipped')
                                                    <h5><span class="badge bg-info">Shipped</span></h5>
                                                @elseif($order->status == 'delivered')
                                                    <h5><span class="badge bg-success">Delivered</span></h5>
                                                    @else
                                                    <h5><span class="badge bg-danger">Cancelled</span></h5>
                                                @endif
                                            </p>
                                        </h6>
                                    </div>
                                    <div class="col-6 col-lg-3">
                                        <!-- Heading -->
                                        <h4 class="heading-xxxs text-muted">Order Amount:</h4>
                                        <!-- Text -->
                                        <h5>
                                            <p class="mb-0 fs-sm fw-bold">
                                                <strong style="color: #28a745; font-size: 18px;"><span>₹. </span>
                                                </strong>{{ number_format($order->grand_total, 2)}}/-
                                            </p>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer p-3">

                        <!-- Heading -->
                        <h6 class="mb-7 h5 mt-4">Order Items : ({{ $orderItemsCount }}) </h6>

                        <!-- Divider -->
                        <hr class="my-3">

                        <!-- List group -->
                        <ul style="font-family: 'Times New Roman', Times, serif;">
                            @foreach ($orderItems as $item)
                                                            <li class="list-group-item">
                                                                <div class="row align-items-center">
                                                                    <div class="col-4 col-md-3 col-xl-2">
                                                                        <!-- Image -->
                                                                        <!-- <a href="product.html"><img src="images/product-1.jpg" alt="..."
                                                                                class="img-fluid"></a> -->
                                                                                @php
                                                                                    $productImage = getProductImage($item->product_id);
                                                                                    $imagePath = $productImage ? 'uploads/product/large/' . $productImage->image : '';
                                                                                @endphp

                                                                                   @if (!empty($productImage) && file_exists(public_path($imagePath)))
                                                                                    <img class="img-fluid" src="{{ asset($imagePath) }}?v={{ time() }}"
                                                                                        alt="Product Image" 
                                                                                        style="height: 200px; object-fit: cover; width: 100%;"> <!-- Fixed size and responsive --><br>
                                                                                @else
                                                                                    <img class="img-fluid" src="{{ asset('admin-assets/img/default-150x150.png') }}"
                                                                                        alt="Default Image" 
                                                                                        style="height: 200px; object-fit: cover; width: 100%;"> <!-- Same styling for default image --><br>
                                                                                @endif
                                                                                    <!-- <br>    <button style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;" onclick="showVideo()">
                                                                                                            Watch Video
                                                                                                </button> -->


                                                                    </div>
                                                                    <!-- Video Player (initially hidden) -->
                                                                        <!-- <div id="videoContainer" style="display: none; margin-top: 20px;">
                                                                            <video id="productVideo" width="600" controls>
                                                                                <source src="https://www.youtube.com/watch?v=ePdbj2bZ-Ro" type="video/mp4">
                                                                                Your browser does not support the video tag.
                                                                            </video>

                                                                        </div> -->
                                                                        <!-- YouTube Video Embed (initially hidden) -->
                                                                        <div id="videoContainer" style="display: none; margin-top: 20px;">
                                                                            <iframe id="youtubeVideo" width="600" height="400" src="https://www.youtube.com/embed/ePdbj2bZ-Ro" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                                        </div>

                                                                    <div class="col">
                                                                        <!-- Title -->
                                                                        <p class="mb-4 fs-sm fw-bold">
                                                                            <a class="text-body" href="product.html">{{  $item->name }} x {{  $item->qty }}</a>
                                                                            <br>
                                                                            @foreach($orderItems as $item)
                                                                                                                             <!-- Brand Logo -->
                                                                                <!-- <img src="{{ asset(path: 'front-assets/images/Samsung.png') }}"  style="width: 40px; height: 40px; margin-right: 10px;"> -->
                                                                                                                            Brand: <a style="color: #28a745; font-size: 18px;"> {{ $item->product->brand ? $item->product->brand->name : 'N/A' }}</a><br>
                                                                            @endforeach

                                                                          <span class="text-muted"> <strong style="color: #28a745; font-size: 18px;"><span>₹. </span>
                                                                            </strong>{{  $item->total }}</span>
                                                                        </p>
                                                                    </div>

                                                                    <div class="col">
                                                                        <!-- Title -->
                                                                        <p class="mb-4 fs-sm fw-bold">

                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>

                <div class="card card-lg mb-5 mt-3">
                    <div class="card-body">
                        <!-- Heading -->
                        <h6 class="mt-0 mb-3 h5">Order Total</h6>

                        <!-- List group -->
                        <ul>
                            <li class="list-group-item d-flex">
                                <span>Subtotal</span>
                                <span class="ms-auto"> <strong>₹.
                                    </strong>{{ number_format($order->subtotal, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif ;">
                                <span>Discount {{ (!empty($order->coupon_code)) ? '(' . $order->coupon_code . ')' : '' }}</span>
                                <span class="ms-auto"><strong>₹.
                                    </strong>{{ number_format($order->discount, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif ;">
                                <span>Shipping</span>
                                <span class="ms-auto"> <strong>₹.
                                    </strong>{{ number_format($order->shipping, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex fs-lg fw-bold" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif ;">
                                <span>Grand Total</span>
                                <span class="ms-auto"> <strong>₹.
                                    </strong>{{ number_format($order->grand_total, 2) }}/-</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
// function playProductVideo() {
//     // Show the video container
//     document.getElementById('videoContainer').style.display = 'block';
    
//     // Automatically play the video
//     var video = document.getElementById('productVideo');
//     video.play();
// }
// function showVideo() {
//     // Show the video container
//     document.getElementById('videoContainer').style.display = 'block';
// }
</script>
@endsection