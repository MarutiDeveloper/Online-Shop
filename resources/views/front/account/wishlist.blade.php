@extends('front.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item">
                    <a class="white-text" href="#">My Account</a>
                </li>
                <li class="breadcrumb-item">
                    <i class="fas fa-heart"></i> My Wishlist
                </li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-11 ">
    <div class="container  mt-5">

        <div class="row">
            
            @include('front.account.common.message')

           
            <div class="col-md-3">
                @include('front.account.common.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2"> My Wishlist</h2>
                    </div>
                    <div class="card-body p-4">
                        @if ($wishlists->isNotEmpty())
                                            @foreach ($wishlists as $wishlist)
                                                                <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                                                    <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                                                        <a class="d-block flex-shrink-0 mx-auto me-sm-4"
                                                                            href="{{ route('front.product', $wishlist->product->slug) }}" style="width: 10rem;">

                                                                            <!-- <img src="images/product-1.jpg" alt="Product"> -->
                                                                            @php
                                                                                $productImage = $wishlist->product->product_images->first();
                                                                                $imagePath = $productImage ? 'uploads/product/large/' . $productImage->image : '';
                                                                            @endphp

                                                                            @if (!empty($productImage) && file_exists(public_path($imagePath)))
                                                                                <img class="rounded mx-auto d-block" src="{{ asset($imagePath) }}?v={{ time() }}"
                                                                                    alt="Product Image" style="height: 175px; object-fit: cover; width: 100%;">
                                                                                <!-- Fixed size and responsive -->
                                                                            @else
                                                                                <img class="rounded mx-auto d-block"
                                                                                    src="{{ asset('admin-assets/img/default-150x150.png') }}" alt="Default Image"
                                                                                    style="height: 200px; object-fit: cover; width: 100%;">
                                                                                <!-- Same styling for default image -->
                                                                            @endif
                                                                        </a>

                                                                        <div class="pt-3">
                                                                            <h3 class="product-title fs-base mb-2">
                                                                                <a
                                                                                    href="{{ route('front.product', $wishlist->product->slug) }}">{{ $wishlist->product->title }}</a>
                                                                            </h3>
                                                                            <!-- Direct Rupee symbol -->
                                                                            <div class="price mt-2">
                                                                                <span class="h5"><strong>₹.{{ $wishlist->product->price }}</strong></span>
                                                                                @if ($wishlist->product->compare_price > 0)
                                                                                    <span
                                                                                        class="h6 text-underline"><del>₹.{{ $wishlist->product->compare_price }}</del></span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                                                        <button onclick="removeProduct({{ $wishlist->product_id }})"
                                                                            class="btn btn-outline-danger btn-sm" type="button"><i
                                                                                class="fas fa-trash-alt me-2"></i>Remove</button>
                                                                    </div>
                                                                </div>
                                            @endforeach
                                            @else
                                            <div>
                                                <h3 class="h5">Your Wishlist is empty...!</h3>
                                            </div>

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script type="text/javascript">
    function removeProduct(id) {
        $.ajax({
            url: '{{ route("account.removeProductFromWishList") }}',
            type: 'post',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                if (response.status == true) {
                    window.location.href = "{{ route('account.wishlist') }}";
                }
            }
        });
    }
</script>
@endsection