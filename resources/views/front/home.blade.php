@extends('front.layouts.app')

@section('content')
<section class="section-1">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
        data-bs-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                <picture>
                    <source media="(max-width: 799px)" srcset="{{ asset('front-assets/images/carousel-1-m.jpg') }}" />
                    <source media="(min-width: 800px)" srcset="{{ asset('front-assets/images/carousel-1.jpg') }}" />
                    <img src="{{ asset('front-asset/images/carousel-1.jpg') }}" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Kids Fashion</h1>
                        <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo
                            stet amet amet ndiam elitr ipsum diam</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">

                <picture>
                    <source media="(max-width: 799px)" srcset="{{ asset('front-assets/images/carousel-2-m.jpg') }}" />
                    <source media="(min-width: 800px)" srcset="{{ asset('front-assets/images/carousel-2.jpg') }}" />
                    <img src="{{ asset('front-asset/images/carousel-2.jpg') }}" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Womens Fashion</h1>
                        <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo
                            stet amet amet ndiam elitr ipsum diam</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                <picture>
                    <source media="(max-width: 799px)" srcset="{{ asset('front-assets/images/carousel-3-m.jpg') }}" />
                    <source media="(min-width: 800px)" srcset="{{ asset('front-assets/images/carousel-3.jpg') }}" />
                    <img src="{{ asset('front-asset/images/carousel-2.jpg') }}" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Clothes
                        </h1>
                        <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo
                            stet amet amet ndiam elitr ipsum diam</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<section class="section-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                </div>
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-3">
    <div class="container">
        <div class="section-title">
            <h2>Categories</h2>
        </div>
        <div class="row pb-3">
            @if (getCategories()->isNotEmpty())
                @foreach (getCategories() as $category)
                    <div class="col-md-4 mb-3"> <!-- Adjust column size as needed -->
                        <div class="card" style="width: 100%;"> <!-- Set width to 100% for responsiveness -->
                            @if ($category->image != "")
                                <img src="{{ asset('uploads/category/' . $category->image) }}" class="card-img-top"
                                    alt="Category Image" style="height: 200px; object-fit: cover;">
                                <!-- Adjust height and maintain aspect ratio -->
                            @else
                                <img src="{{ asset('front-assets/images/default-image.jpg') }}" alt="Default Category Image"
                                    class="card-img-top" style="height: 200px; object-fit: cover;">
                                <!-- Adjust height and maintain aspect ratio -->
                            @endif
                            <div class="card-body">
                                <h5 class="fw-bold" style="font-family: 'Times New Roman', Times, serif;">
                                    {{ $category->name }}
                                </h5>
                                <!-- <p>100 Products</p> -->
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Featured Products</h2>
        </div>
        <div class="row pb-3">
            @if ($featuredProducts->isNotEmpty())
                    @foreach ($featuredProducts as $product)
                            @php
                                $productImage = $product->product_images->first();
                                $imagePath = $productImage ? 'uploads/product/large/' . $productImage->image : '';
                            @endphp
                            <div class="col-md-3 mb-3"> <!-- Added mb-3 for consistent spacing between cards -->
                                <div class="card product-card" style="width: 100%;"> <!-- Ensuring card takes full width -->
                                    <div class="product-image position-relative">
                                        <a href="{{ route('front.product', $product->slug) }}" class="product-img">
                                            @if (!empty($productImage) && file_exists(public_path($imagePath)))
                                                <img class="card-img-top" src="{{ asset($imagePath) }}?v={{ time() }}" alt="Product Image"
                                                    style="height: 200px; object-fit: cover; width: 100%;">
                                                <!-- Fixed size and responsive -->
                                            @else
                                                <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}"
                                                    alt="Default Image" style="height: 200px; object-fit: cover; width: 100%;">
                                                <!-- Same styling for default image -->
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
                                        style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                                        <a class="h4 link" href="{{ route('front.home', $product->id) }}"
                                            style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                            {{ $product->title }}
                                        </a>

                                        <div class="brand-name mt-2">
                                            <h4>
                                                <a class="h4 link" href="product.php"
                                                    style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                                    <h5 style="font-family:fantasy ">Brand :-
                                                        {{ $product->brand ? $product->brand->name : 'N/A' }}</h5>
                                                </a>
                                            </h4>
                                        </div>

                                        <div class="price mt-2">
                                            <span class="h5"><strong>₹.{{ $product->price }}</strong></span>
                                            @if ($product->compare_price > 0)
                                                <span class="h6 text-underline"><del>₹.{{ $product->compare_price }}</del></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
            @endif
        </div>
    </div>
</section>

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Latest Produsts</h2>
        </div>
        <div class="row pb-3">
    @if ($latestProducts->isNotEmpty())
        @foreach ($latestProducts as $product)
            @php
                $productImage = $product->product_images->first();
                $imagePath = $productImage ? 'uploads/product/large/' . $productImage->image : '';
            @endphp
            <div class="col-md-3 mb-3"> <!-- Added mb-3 for spacing between cards -->
                <div class="card product-card" style="width: 100%;"> <!-- Ensuring card takes full width -->
                    <div class="product-image position-relative">
                        <a href="{{ route('front.product', $product->slug) }}" class="product-img">
                            @if (!empty($productImage) && file_exists(public_path($imagePath)))
                                <img class="card-img-top" src="{{ asset($imagePath) }}?v={{ time() }}"
                                     alt="Product Image" 
                                     style="height: 200px; object-fit: cover; width: 100%;"> <!-- Fixed size and responsive -->
                            @else
                                <img class="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }}"
                                     alt="Default Image" 
                                     style="height: 200px; object-fit: cover; width: 100%;"> <!-- Same styling for default image -->
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
                         style="font-family: 'Times New Roman', Times, serif; font-weight: bold;">
                        <a class="h4 link" href="{{ route('front.product', $product->slug) }}"
                           style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                            {{ $product->title }}
                        </a>

                        <div class="brand-name mt-2">
                            <h4>
                                <a class="h4 link" href="{{ route('front.product', $product->slug) }}"
                                   style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                                   Brand: {{ $product->brand ? $product->brand->name : 'N/A' }}
                                </a>
                            </h4>
                        </div>

                        <div class="price mt-2">
                            <span class="h5"><strong>₹.{{ $product->price }}</strong></span>
                            @if ($product->compare_price > 0)
                                <span class="h6 text-underline"><del>₹.{{ $product->compare_price }}</del></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
    </div>
</section>
@endsection