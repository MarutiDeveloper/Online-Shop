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
                                                    01 Oct, 2019
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
                                                @else
                                                    <h5><span class="badge bg-success">Delivered</span></h5>
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
                        <h6 class="mb-7 h5 mt-4">Order Items (3)</h6>

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
                                                                        style="height: 200px; object-fit: cover; width: 100%;"> <!-- Fixed size and responsive -->
                                                                @else
                                                                    <img class="img-fluid" src="{{ asset('admin-assets/img/default-150x150.png') }}"
                                                                        alt="Default Image" 
                                                                        style="height: 200px; object-fit: cover; width: 100%;"> <!-- Same styling for default image -->
                                                        @endif
                                                    
                                        </div>
                                        <div class="col">
                                            <!-- Title -->
                                            <p class="mb-4 fs-sm fw-bold">
                                                <a class="text-body" href="product.html">{{  $item->name }} x {{  $item->qty }}</a>
                                                <br>
                                                @foreach($orderItems as $item)
                                                Brand: <a style="color: #28a745; font-size: 18px;"> {{ $item->product->brand ? $item->product->brand->name : 'N/A' }}</a>
                                                @endforeach
                                                <br>
                                                <h5><span class="text-muted"> <strong style="color: #28a745; font-size: 18px;"><span>₹. </span>
                                                </strong>{{  $item->total }}</span></h5>
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
                                    </strong>{{ number_format($order->subtotal,2) }}</span>
                            </li>
                            <li class="list-group-item d-flex" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif ;">
                                <span>Discount {{ (!empty($order->coupon_code)) ? '('.$order->coupon_code.')' : '' }}</span>
                                <span class="ms-auto"><strong>₹.
                                    </strong>{{ number_format($order->discount,2) }}</span>
                            </li>
                            <li class="list-group-item d-flex" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif ;">
                                <span>Shipping</span>
                                <span class="ms-auto"> <strong>₹.
                                    </strong>{{ number_format($order->shipping,2) }}</span>
                            </li>
                            <li class="list-group-item d-flex fs-lg fw-bold" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif ;">
                                <span>Grand Total</span>
                                <span class="ms-auto"> <strong>₹.
                                    </strong>{{ number_format($order->grand_total,2) }}/-</span>
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

</script>
@endsection