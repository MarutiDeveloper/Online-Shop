@extends('front.layouts.app')

@section('content')

<!-- Section Part -1 -->
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop') }}">Shop</a></li>
                <li class="breadcrumb-item">{{ $product->title }}</li>
            </ol>
        </div>
    </div>
</section>

<!-- Section Part -2 -->
<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row ">
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">

                        @if ($product->product_images)
                            @foreach ($product->product_images as $key => $productImage)
                                <div class="carousel-item {{ ($key == 0) ? 'active' : '' }}">
                                    <img class="w-100 h-100" src="{{ asset('uploads/product/large/' . $productImage->image) }}"
                                        alt="Image">
                                </div>

                            @endforeach

                        @endif

                    </div>
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <!-- Content for the first slide -->
                            </div>
                            <div class="carousel-item">
                                <!-- Content for the second slide -->
                            </div>
                            <!-- Add more slides as needed -->
                        </div>
                        <!-- <a class="carousel-control-prev" href="#product-carousel" role="button" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" role="button" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a> -->
                    </div>

                </div>
            </div>
            <div class="col-md-7">
                <div class="bg-light right">
                    <h1>{{ $product->title }}</h1>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(99 Reviews)</small>
                    </div>

                    @if ($product->compare_price > 0)
                        <h2 class="price text-secondary"><del><strong>₹. </strong>{{ $product->compare_price }}</del></h2>
                    @endif

                    <h2 class="price "><strong>₹. </strong>{{ ($product->price) }}</h2>
                    <p>
                        {!! $product->short_description !!}
                    </p>
                    <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="bg-light">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping"
                                type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping &
                                Returns</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                            aria-labelledby="description-tab">
                            <p>
                                {!! $product->description !!}
                            </p>
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <p>
                                {!! $product->shipping_returns !!}
                            </p>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Part -3 -->
@if (!empty($relatedProducts))
    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Related Product</h2>
            </div>
            <div class="row pb-3">

                @foreach ($relatedProducts as $relProduct)
                        @php
                            $productImage = $relProduct->product_images->first();
                            $imagePath = $productImage ? 'uploads/product/large/' . $productImage->image : '';
                        @endphp

                        <div class="col-md-3">
                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href="{{ route('front.product', $product->slug) }}" class="product-img">

                                        <!-- <img class="card-img-top" src="{{ asset('front-assets/images/product-1.jpg') }}"
                                                                                                                                                                                                                                                                                                                                                                                                    alt=""> -->

                                        @if (!empty($productImage) && file_exists(filename: public_path(path: $imagePath)))
                                            <img class="card-img-top" src="{{ asset(path: $imagePath) }}?v={{ time() }}" width="50"
                                                onerror="this.onerror=null; this.src='{{ asset(path: 'admin-assets/img/default-150x150.png') }}';"
                                                alt="Product Image" />
                                        @else
                                            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}"
                                                width="50" alt="Default Image" />
                                        @endif

                                    </a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body text-center mt-3"
                                    style="font-family: 'Times New Roman', Times, serif; font-weight: bold ;">
                                    <a class="h4 link" href="product.php"
                                        style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif ;">{{ $relProduct->title }}</a>


                                    <div class="brand-name mt-2">
                                        <h4> <span class="h4">
                                                <a class="h4 link" href="product.php"
                                                    style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif ;">Brand:
                                                    {{ $product->brand ? $product->brand->name : 'N/A' }}</a>
                                                <!-- Brand: {{ $product->brand ? $product->brand->name : 'N/A' }} -->
                                            </span></h4>
                                    </div>

                                    <div class="price mt-2">
                                        <span class="h5"><strong>₹ {{ $relProduct->price }}</strong></span>
                                        @if ($relProduct->compare_price > 0)
                                            <span class="h6 text-underline"><del>₹ {{ $relProduct->compare_price }}</del></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach


            </div>
        </div>
    </section>
@endif
@endsection
@section('customJs')
<script type="text/javascript">
    //var myCarousel = document.querySelector('#product-carousel');
    // var carousel = new bootstrap.Carousel(myCarousel);


</script>
@endsection