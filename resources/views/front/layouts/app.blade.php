<!DOCTYPE html>
<html class="no-js" lang="en_AU">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Online Shop</title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <a href="index.php" class="text-decoration-none">
                        <i class="fas fa-shopping-cart text-primary h3"></i> <!-- Optional icon -->
                        <span class="h3 text-uppercase text-primary bg-dark px-2"
                            style="font-family: Georgia, 'Times New Roman', Times, serif;">Online</span>
                        <span class="h3 text-uppercase text-dark bg-primary px-2 ml-n1"
                            style="font-family: Georgia, 'Times New Roman', Times, serif;">SHOP</span>
                    </a>
                </div>
                <div class="col-lg-6 col-6 text-left  d-flex justify-content-end align-items-center">
                    <div class="nav-item dropdown">
                        <a href="register.php" class="nav-link dropdown-toggle text-dark" id="accountDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="font-family: Georgia, 'Times New Roman', Times, serif;">
                            Register Here</a>

                        <div class="dropdown-menu" aria-labelledby="accountDropdown">
                            <a href="login.php" class="dropdown-item">Login</a>
                            <a href="register.php" class="dropdown-item">Register</a>
                        </div>
                    </div>
                    <!-- <div class="nav-item">
                            <a href="login.php" class="nav-link text-dark">Login</a>
                        </div>
                        <div class="nav-item">
                            <a href="register.php" class="nav-link text-dark">Register</a>
                        </div>
                    </div> -->
                    <form action="">
                        <div class="input-group">
                            <input type="text" placeholder="Search For Products" class="form-control"
                                aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
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
                </div>
                <div class="right-nav py-0">
                    <a href="{{ route('front.cart') }}" class="ml-3 d-flex pt-2">
                        <i class="fas fa-shopping-cart text-primary"></i>
                    </a>
                </div>
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
                                <i class="fas fa-shopping-cart text-primary h3"></i> 
                                <p class="footer-link d-inline-block" style="margin-left: 10px;">Online Shop</p>
                            </h4>
                                <p style="margin: 0;">123 Street, New York, USA</p>
                            <p style="margin: 0;">Email: <a href="mailto:example@example.com"
                                    class="footer-link">example@example.com</a></p>
                            <p style="margin: 0;">Phone: <a href="tel:0000000000" class="footer-link">000 000 0000</a>
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
                            <li><a href="#" class="footer-link">Login</a></li>
                            <li><a href="#" class="footer-link">Register</a></li>
                            <li><a href="#" class="footer-link">My Orders</a></li>
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
    </script>
    @yield('customJs')

</body>

</html>