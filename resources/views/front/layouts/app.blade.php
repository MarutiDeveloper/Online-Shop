<!DOCTYPE html>
<html class="no-js" lang="en_AU">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Online Shop</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="fb:admins" content="" />
    <meta property="fb:app_id" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />

    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icofont/1.0.1/css/icofont.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset(path: 'front-assets/css/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset(path: 'front-assets/slick-theme.css') }}" />
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('front-assets/css/video-js.css') }}" />  -->
    <link rel="stylesheet" type="text/css" href="{{ asset(path: 'front-assets/css/style.css') }}" />
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset(path: 'front-assets/css/ion.rangeSlider.css') }}" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset(path: 'front-assets/css/ion.rangeSlider.min.css') }}" />  -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
</head>

<body data-instant-intensity="mousedown">

    <div class="bg-light top-header">
        <div class="container">
            <div class="row align-items-center py-3 d-none d-lg-flex justify-content-between">
                <div class="col-lg-4 logo">
                    <a href="{{ route('front.home') }}" class="text-decoration-none d-flex align-items-center">
                        <!-- Logo Image -->
                        <img src="{{ asset('front-assets/images/Online-Shopping Logo.jpg') }}"
                            class="rounded-circle bg-light" style="height: 70px; width: 70px; object-fit: contain;">

                        <!-- Logo Text -->
                        <div>
                            <span class="h3 text-uppercase text-primary  px-2"
                                style="font-family: Georgia, 'Times New Roman', Times, serif;">
                                Online
                            </span>
                            <span class="h3 text-uppercase  ml-n2"
                                style="font-family: Georgia, 'Times New Roman', Times, serif;">
                                SHOP
                            </span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">

                    @if (Auth::check())
                        <!-- My Account Dropdown with Icon -->
                        <div class="col-2 d-flex align-items-center">
                            <!-- My Account Icon and Link -->
                            <!-- <a href="{{ route('account.profile') }}" class="d-flex align-items-center"> -->
                            <!-- <i class="fas fa-user mr-2"></i> My Account Icon -->
                            <!-- My Account -->
                            <!-- </a> -->
                            <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="{{ route('account.profile') }}">
                                <img src="{{ asset('front-assets/images/avatar5.png') }}"
                                    class="img-fluid  rounded-circle bg-light  img-circle"
                                    style="display: block; margin: auto;" width="25" height="25" alt=""> My Account
                            </a>

                        </div>
                    @else
                        <!-- Login / Registration with Icon -->

                        <div class="col-3 d-flex align-items-center">
                            <a href="{{ route('account.login') }}" class="nav-link p-0 pr-3">
                                <!-- <i class="fas fa-sign-in-alt ml-2"></i> Login Icon -->
                                <img src="{{ asset('front-assets/images/Registration.png') }}"
                                    class="img-fluid  rounded-circle bg-light  img-circle"
                                    style="display: block; margin: auto;" width="25" height="25" alt="">
                                Login / Sign Up
                            </a>
                        </div>
                    @endif



                    <!-- <div class="nav-item dropdown">
                        <a href="register.php" class="nav-link dropdown-toggle text-dark" id="accountDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="font-family: Georgia, 'Times New Roman', Times, serif;">
                            Register Here</a>

                        <div class="dropdown-menu" aria-labelledby="accountDropdown">
                            <a href="login.php" class="dropdown-item">Login</a>
                            <a href="register.php" class="dropdown-item">Register</a>
                        </div>

                    </div> -->
                    <!-- <div class="nav-item">
                            <a href="login.php" class="nav-link text-dark">Login</a>
                        </div>
                        <div class="nav-item">
                            <a href="register.php" class="nav-link text-dark">Register</a>
                        </div>
                    </div> -->
                    <form action="{{ route('front.shop') }}" method="get">
                        <div class="input-group">
                            <input value="{{ Request::get('search') }}" type="text" placeholder="Search For Products"
                                class="form-control" name="search" id="search">
                            <button class="input-group-text btn btn-outline-light btn-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <header class="bg-dark">
        <div class="container" style="font-family: Georgia, 'Times New Roman', Times, serif;">
            <nav class="navbar navbar-expand-xl" id="navbar">
                <a href="{{ route('front.home') }}" class="text-decoration-none mobile-logo">
                    <span class="h2 text-uppercase text-primary bg-dark">Online</span>
                    <span class="h2 text-uppercase text-white px-2">SHOP</span>
                </a>
                <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <!-- <span class="navbar-toggler-icon icon-menu"></span> -->
                    <i class="navbar-toggler-icon fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- <li class="nav-item">
          				<a class="nav-link active" aria-current="page" href="index.php" title="Products">Home</a>
        			</li> -->
                        @if (getCategories()->isNotEmpty())
                            @foreach (getCategories() as $category)
                                <li class="nav-item dropdown">
                                    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        {{ $category->name }}
                                    </button>
                                    @if ($category->sub_category->isNotEmpty())
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            @foreach ($category->sub_category as $subCategory)
                                                <li><a class="dropdown-item nav-link"
                                                        href="{{ route('front.shop', [$category->slug, $subCategory->slug]) }}">{{ $subCategory->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        @endif

                        <!-- <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Men's Fashion
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#">Shirts</a></li>
                                <li><a class="dropdown-item" href="#">Jeans</a></li>
                                <li><a class="dropdown-item" href="#">Shoes</a></li>
                                <li><a class="dropdown-item" href="#">Watches</a></li>
                                <li><a class="dropdown-item" href="#">Perfumes</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Women's Fashion
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#">T-Shirts</a></li>
                                <li><a class="dropdown-item" href="#">Tops</a></li>
                                <li><a class="dropdown-item" href="#">Jeans</a></li>
                                <li><a class="dropdown-item" href="#">Shoes</a></li>
                                <li><a class="dropdown-item" href="#">Watches</a></li>
                                <li><a class="dropdown-item" href="#">Perfumes</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Appliances
                            </button>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="#">TV</a></li>
                                <li><a class="dropdown-item" href="#">Washing Machines</a></li>
                                <li><a class="dropdown-item" href="#">Air Conditioners</a></li>
                                <li><a class="dropdown-item" href="#">Vacuum Cleaner</a></li>
                                <li><a class="dropdown-item" href="#">Fans</a></li>
                                <li><a class="dropdown-item" href="#">Air Coolers</a></li>
                            </ul>
                        </li> -->


                    </ul>
                    <!-- My Account Dropdown -->
                    <!-- <div class="nav-item dropdown ml-4"> Ensure this has enough left margin
                        <a href="#" class="nav-link dropdown-toggle text-light" id="accountDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            My Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="accountDropdown">
                            <li><a href="{{ route('account.login') }}" class="dropdown-item">Login</a></li>
                            <li><a href="{{ route('account.profile') }}" class="dropdown-item">Profile</a></li>
                        </ul>
                    </div> -->

                    <!-- Cart Icon with additional spacing -->
                    <div class="right-nav py-0 ml-5"> <!-- Added ml-4 for left margin -->
                        <a href="{{ route('front.cart') }}" class="d-flex pt-2">
                            <i class="fas fa-shopping-cart text-primary"></i>
                        </a>
            </nav>
        </div>

    </header>
    <main>
        @yield('content')
    </main>


    <footer class="bg-dark text-light mt-5">
        <div class="container pb-5 pt-3">
            <div class="row">
                <!-- Get In Touch Section (With Visiting Card) -->
                <div class="col-md-4">
                    <div class="footer-card mb-3">
                        <h3 class="footer-title">Get In Touch</h3>

                        <!-- Visiting Card Section -->
                        <div class="visiting-card bg-dark text-light p-3 mt-4"
                            style="width: 100%; border-radius: 10px;">
                            <h4 class="company-name mb-3" style="color: #f8f9fa; font-size: 18px;">
                                <!-- Logo Image -->
                                <!-- <img src="path/to/your-logo.png" 
                                    style="height: 40px; vertical-align: middle;"> -->

                                <!-- Company Name -->
                                <!-- <i class="fas fa-shopping-cart text-primary h5"></i> Optional icon -->
                                <!-- <p class="footer-link d-inline-block" style="margin-left: 10px;">
                                    {{ !empty($allContactInfo) ? $allContactInfo->company_name : '' }}
                                </p> -->
                                <!-- Logo Image -->
                                <img src="{{ asset('front-assets/images/Online-Shopping Logo.jpg') }}"
                                    class="rounded-circle bg-light"
                                    style="height: 50px; width: 50px; object-fit: contain;">
                                <span class="footer-link d-inline-block h5 text-uppercase text-primary bg-dark"
                                    style="margin-left: 3px;">{{ $allContactInfo->company_name ?? 'Online Shop' }}</span><br><hr>
                                    
                                <address class="text-left text-uppercase text-primary"  style="font-size: medium ;"
                                    style="font-family: Arial, sans-serif; font-size: 14px; font-style: normal;">
                                    
                                    <p style="margin: 0;">
                                    <i class="fa fa-map-marker-alt me-1"></i>
                                        {{ $allContactInfo->company_address ?? '123 Street, New York, USA' }}
                                    </p>
                                </address>
                                <p style="font-size: medium ;">
                                     <a href="mailto:{{ $allContactInfo->company_email ?? 'example@example.com' }}"
                                        class="footer-link"> Email:
                                        {{ $allContactInfo->company_email ?? 'example@example.com' }}
                                    </a>
                                   
                                </p>
                                <p style="margin: 0;">
                                   
                                    <a href="tel:{{ $allContactInfo->company_phone_number ?? '000 000 0000' }}"
                                        class="footer-link">  Phone: 
                                        {{ $allContactInfo->company_phone_number ?? '000 000 0000' }}
                                    </a>
                                </p>
                        </div>
                    </div>
                </div>

                <!-- Important Links Section -->
                <div class="col-md-4">
                    <div class="footer-card mb-4">
                        <h3 class="footer-title">Important Links</h3>
                        <ul class="footer-list">
                            <li><a href="about-us.php" title="About" class="footer-link">About</a></li>
                            <li><a href="contact-us.php" title="Contact Us" class="footer-link">Contact Us</a></li>
                            <li><a href="#" class="footer-link">Privacy</a></li>
                            <li><a href="#" class="footer-link">Terms & Conditions</a></li>
                            <li><a href="#" class="footer-link">Refund Policy</a></li>
                        </ul>
                    </div>
                </div>

                <!-- My Account Section -->
                <div class="col-md-4">
                    <div class="footer-card mb-4">
                        <h3 class="footer-title">My Account</h3>
                        <ul class="footer-list">
                            <li><a href="{{ route('account.login') }}" class="footer-link">Login</a></li>
                            <li><a href="#" class="footer-link">My Orders</a></li>
                            <li><a href="{{ route('front.clearCache') }}" class="footer-link">Clear/Re-sett</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright Section -->
        <div class="copyright-area bg-secondary py-3">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="mb-0">© Copyright 2024 Online Shop All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Wishlist Modal -->
    <div class="modal fade" id="wishlistModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="{{ asset('front-assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/instantpages.5.1.0.min.js') }}"></script>

    <script src="{{ asset('front-assets/js/lazyload.17.6.0.min.js') }}"></script>
    <script src="{{ asset('front-assets/js/slick.min.js') }}"></script>
    <!-- <script src="{{ asset('front-assets/js/ion.rangeSlider.min.js') }}"></script>  -->
    <!--jQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!--Plugin JavaScript file-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('front-assets/js/custom.js') }}"></script>

    <script>
        window.onscroll = function () { myFunction() };

        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;

        function myFunction() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function addToCart(id) {
            $.ajax({
                url: '{{ route("front.addToCart") }}',
                type: 'post',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.status == true) {
                        window.location.href = "{{ route('front.cart') }}";
                    } else {
                        alert(response.message);
                    }
                }
            });
        }

        function addToWishList(id) {
            $.ajax({
                url: '{{ route("front.addToWishlist") }}',  // Make sure this route exists
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  // CSRF token for security
                    id: id  // Pass the product ID
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status === true) {
                        $("#wishlistModel .modal-body").html(response.message);
                        $("#wishlistModel").modal('show');
                        // Handle success (e.g., show a message or change heart icon)
                        // alert('Product added to wishlist!');
                    } else {
                        // Redirect to login page if the user is not authenticated
                        window.location.href = "{{ route('account.login') }}";
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                }
            });
        }

        // Function to call the optimize-clear route every 5 minutes
        // function autoClearCache() {
        //     fetch('/optimize-clear')
        //         .then(response => response.json())
        //         .then(data => {
        //             console.log(data.message); // Log success message from the server
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //         });
        // }

        // Call the function every 5 minutes (300000 milliseconds)
        // setInterval(autoClearCache, 300000); // 300000 ms = 5 minutes


    </script>
    @yield('customJs')

</body>

</html>