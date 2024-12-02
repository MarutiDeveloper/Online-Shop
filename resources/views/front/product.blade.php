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
            @include('front.account.common.message')
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner ">

                        @if ($product->product_images)
                            @foreach ($product->product_images as $key => $productImage)
                                <div class="carousel-item {{ ($key == 0) ? 'active' : '' }}">
                                    <img class=" w-50 p-3  top-header"
                                        src="{{ asset('uploads/product/large/' . $productImage->image) }}" alt="Image">
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
                <div class="right">
                    <h1>{{ $product->title }}</h1>
                    <div class="d-flex mb-3 flex-column">
                        <!-- Star Rating Section -->
                        <div class="star-rating product mt-2" title="">
                            <div class="back-stars"
                                style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;">
                                <!-- Background Stars -->
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>
                                <i class="fa fa-star" aria-hidden="true"></i>

                                <!-- Front Stars (Filled based on rating) -->
                                <div class="front-stars" style="width: {{ $avgRatingPer }}%;">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews Count Below -->
                        <div class="pt-2 ps-2">
                            <small>
                                ({{ ($product->product_ratings_count > 1) ? $product->product_ratings_count . ' Reviews' : $product->product_ratings_count . ' Review' }})
                            </small>
                        </div>
                    </div>





                    @if ($product->compare_price > 0)
                        <h2 class="price text-secondary"><del><strong>₹. </strong>{{ $product->compare_price }}</del></h2>
                    @endif

                    <h2 class="price"><strong>₹. </strong>{{ number_format($product->price, 2) }}/-</h2>
                    <p>
                        {!! $product->short_description !!}
                    </p>
                    <!-- <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-dark"><i
                            class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a> -->
                    @if ($product->track_qty == 'Yes')
                        @if ($product->qty > 0)
                            <a class="btn btn-dark mt-2" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                                <i class="fa fa-shopping-cart"></i>&nbsp; Add To Cart
                            </a>
                        @else
                            <a class="btn btn-dark mt-2" href="javascript:void(0);">
                                &nbsp;Out of Stock
                            </a>
                        @endif
                    @else
                        <a class="btn btn-dark mt-2" href="javascript:void(0);" onclick="addToCart({{ $product->id }});">
                            <i class="fa fa-shopping-cart"></i> &nbsp;Add To Cart
                        </a>
                    @endif
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
                            <!-- Review Form Section -->
                            <div class="col-md-12 mt-5"
                                style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
                                <div class="container">

                                    <form action="" name="productRatingForm" id="productRatingForm" method="post">
                                        @csrf
                                        <div class="container border p-4 rounded"
                                            style="font-family: 'Times New Roman', Times, serif ; ">
                                            <h3 style="font-weight:bolder ;" class="h4 pb-3">Write a Review</h3>
                                            <div class="row g-3">
                                                <!-- Name Field -->
                                                <div class="col-md-6 mb-1">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" class="form-control" name="name" id="name"
                                                            placeholder="Enter your name">
                                                        <p style="font-size: large ;"></p>
                                                    </div>
                                                </div>

                                                <!-- Email Field -->
                                                <div class="col-md-6 mb-1">
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email</label>
                                                        <input type="email" class="form-control" name="email" id="email"
                                                            placeholder="Enter your email">
                                                        <p style="font-size: large ;"></p>
                                                    </div>
                                                </div>

                                                <!-- Rating Field -->
                                                <div class="col-md-12">
                                                    <div class="form-group mb-4">
                                                        <label for="rating">Rating</label>
                                                        <br>
                                                        <div class="rating" style="width: 10rem">
                                                            <input id="rating-5" type="radio" name="rating"
                                                                value="5" /><label for="rating-5"><i
                                                                    class="shadow-lg fas fa-3x fa-star"></i></label>
                                                            <input id="rating-4" type="radio" name="rating"
                                                                value="4" /><label for="rating-4"><i
                                                                    class="shadow-lg fas fa-3x fa-star"></i></label>
                                                            <input id="rating-3" type="radio" name="rating"
                                                                value="3" /><label for="rating-3"><i
                                                                    class="shadow-lg fas fa-3x fa-star"></i></label>
                                                            <input id="rating-2" type="radio" name="rating"
                                                                value="2" /><label for="rating-2"><i
                                                                    class="shadow-lg fas fa-3x fa-star"></i></label>
                                                            <input id="rating-1" type="radio" name="rating"
                                                                value="1" /><label for="rating-1"><i
                                                                    class="shadow-lg fas fa-3x fa-star"></i></label>

                                                        </div>
                                                        <p class="product-rating-error text-danger"
                                                            style="font-size: large ;"></p>
                                                    </div>
                                                </div>

                                                <!-- Review Textarea -->
                                                <div class="mb-1">
                                                    <div class="mb-3">
                                                        <label for="comment">How was your overall experience ?</label>
                                                        <textarea name="comment" id="comment" class="form-control"
                                                            cols="30" rows="10"
                                                            placeholder="How was your overall experience?"></textarea>
                                                        <p style="font-size: large ;"></p>
                                                    </div>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="col-md-12">
                                                    <button type="submit" class="shadow-lg btn btn-dark">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                            </div>

                            <!-- Display Reviews Section -->
                            <div class="col-md-12 mt-5"
                                style="font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-weight: bold ;">
                                <div class="overall-rating mb-4">
                                    <div class="d-flex">
                                        <h1 class="h3 pe-3">{{ $avgRating }}</h1>
                                        <div class="star-rating mt-2" title="">
                                            <div class="back-stars"
                                                style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif ; ">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                <div class="front-stars" style="width: {{ $avgRatingPer }}%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-2 ps-2">
                                            ({{ ($product->product_ratings_count > 1) ? $product->product_ratings_count . ' Reviews' : $product->product_ratings_count . ' Review'}}
                                            )</div>
                                    </div>

                                </div>

                                @if ($product->product_ratings->isNotEmpty())
                                                            @foreach ($product->product_ratings as $rating)
                                                                                        @php
                                                                                            $ratingPer = ($rating->rating * 100) / 5;
                                                                                        @endphp

                                                                                        <div class="rating-group mb-4">
                                                                                            <span> <strong style="font-size: large ;">{{ $rating->username }}</strong></span>
                                                                                            <div class="star-rating mt-2" title="">
                                                                                                <div class="back-stars">
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                                                                    <div class="front-stars" style="width: {{ $ratingPer }}%">
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="my-3">
                                                                                                <p>
                                                                                                    {{ $rating->comment }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                            @endforeach
                                @endif



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
</section>

<!-- Section Part -3 -->
@if (!empty($relatedProducts))
    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Product</h2>
            </div>
            <div class="row" id="related-products">
                @foreach ($relatedProducts as $relProduct)
                        @php
                            $productImage = $relProduct->product_images->first();
                            $imagePath = $productImage ? 'uploads/product/large/' . $productImage->image : '';
                        @endphp

                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="card product-card h-100">
                                <div class="product-image position-relative">
                                    <a href="{{ route('front.product', $relProduct->slug) }}" class="product-img">
                                        @if (!empty($productImage) && file_exists(public_path($imagePath)))
                                            <img class="card-img-top" src="{{ asset($imagePath) }}?v={{ time() }}"
                                                onerror="this.onerror=null; this.src='{{ asset('admin-assets/img/default-150x150.png') }}';"
                                                alt="Product Image" />
                                        @else
                                            <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}"
                                                alt="Default Image" />
                                        @endif
                                    </a>
                                    <div class="product-action">
                                        @if ($relProduct->track_qty == 'Yes')
                                            @if ($relProduct->qty > 0)
                                                <a class="btn btn-dark mt-2" href="javascript:void(0);"
                                                    onclick="addToCart({{ $relProduct->id }});">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>
                                            @else
                                                <a class="btn btn-dark mt-2" href="javascript:void(0);">
                                                    Out of Stock
                                                </a>
                                            @endif
                                        @else
                                            <a class="btn btn-dark mt-2" href="javascript:void(0);"
                                                onclick="addToCart({{ $relProduct->id }});">
                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-body text-center mt-3"
                                    style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                                    <a class="h4 link" href="{{ route('front.product', $relProduct->slug) }}"
                                        style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                        {{ $relProduct->title }}
                                    </a>

                                    <div class="brand-name mt-2">
                                        <h4>
                                            <a class="h4 link" href="{{ route('front.product', $relProduct->slug) }}"
                                                style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                Brand: {{ $relProduct->brand ? $relProduct->brand->name : 'N/A' }}
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="price mt-2">
                                        <span class="h5"><strong>₹ {{ $relProduct->price }}</strong></span>
                                        @if ($relProduct->compare_price > 0)
                                            <span class="h6 text-underline">
                                                <del>₹ {{ $relProduct->compare_price }}</del>
                                            </span>
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
    $("#productRatingForm").submit(function (evevent) {
        event.preventDefault();

        $.ajax({
            url: '{{ route("front.saveRating", $product->id) }}',
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function (response) {
                var errors = response.errors;

                if (response.status == false) {
                    if (errors.name) {
                        $("#name").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.name);
                    } else {
                        $("#name").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    if (errors.email) {
                        $("#email").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.email);
                    } else {
                        $("#email").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    if (errors.comment) {
                        $("#comment").addClass('is-invalid')
                            .siblings("p")
                            .addClass('invalid-feedback')
                            .html(errors.comment);
                    } else {
                        $("#comment").removeClass('is-invalid')
                            .siblings("p")
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                    if (errors.rating) {
                        $(".product-rating-error").html(errors.rating);
                    } else {
                        $(".product-rating-error").html('');
                    }
                } else {
                    window.location.href = "{{ route('front.product', $product->slug) }}";
                }
            }

        });
    });

</script>
@endsection