<?php

use App\Http\Controllers\Admin\adminlogincontroller;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DiscountCodeController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\StripeCheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/test', function () {
//     orderEmail(14);
// });

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return response()->json(['message' => 'Optimization cache cleared successfully.']);
});

// Generate Invoice Route
Route::get('invoice/{id}/download', [InvoiceController::class, 'downloadInvoice'])->name('front.invoice');

Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/shop/{categorySlug?}/{subCategorySlug?}', [ShopController::class, 'index'])->name('front.shop');
Route::get('/product/{slug}', [ShopController::class, 'product'])->name('front.product');
Route::get('/cart', [CartController::class, 'cart'])->name('front.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('front.addToCart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('front.checkout');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('front.updateCart');
Route::post('/delete-items', [CartController::class, 'deleteItem'])->name('front.deleteItem.cart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('front.checkout');
Route::post('/page/contact-us-online-shop', [FrontController::class, 'sendContactEmail'])->name('contact_us.send');
//Route for creating the Payment Session
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('/stripe', 'stripe')->name('stripe');
    Route::post('/stripe', 'stripePost')->name('stripe.post');
    Route::get('/stripe-success',  'stripeSuccess')->name('stripe.success');
});



//Route for creating the Checkout Payment Session.
Route::get('/checkout/payment', [StripeCheckoutController::class, 'checkout'])->name('checkout');
Route::get('/payment/success', [StripeCheckoutController::class, 'success'])->name('stripe.success');
Route::get('/payment/cancel', [StripeCheckoutController::class, 'cancel'])->name('stripe.cancel');

//Route for Razor Pay.
Route::get('/razorpay-checkout/{orderId}', [PaymentController::class, 'showCheckout'])->name('razorpay.checkout');
Route::post('/razorpay-session', [PaymentController::class, 'createCheckoutSession'])->name('createCheckoutSession');
Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment-failed', function () {
    return "Payment Failed! Please try again.";
})->name('payment.cancel');
//Route for creating the checkout session
Route::post('/process-checkout', [CartController::class, 'processCheckout'])->name('front.processCheckout');
Route::get('/thanks/{orderId}', [CartController::class, 'thankyou'])->name('front.thankyou');
// Route::get('/', [FrontController::class, 'showFooter'])->name('front.home'); // Adjust as needed
Route::post('/get-order-summery', [CartController::class, 'getOrderSummery'])->name('front.getOrderSummery');
Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('front.applyDiscount');
Route::post('/remove-discount', [CartController::class, 'removeCoupon'])->name('front.removeCoupon');
Route::post('/add-to-wishlist', [FrontController::class, 'addToWishlist'])->name('front.addToWishlist');
Route::get('/page/{slug}', [FrontController::class, 'page'])->name('front.page');
//Routes for Forgot-Password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('front.forgotPassword');
Route::post('/process-forgot-password', [AuthController::class, 'processForgotPassword'])->name('front.processForgotPassword');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('front.resetPassword');
Route::post('/process-reset-password', [AuthController::class, 'processResetPassword'])->name('front.processResetPassword');
Route::post('/savr-rating/{productId}', [ShopController::class, 'saveRating'])->name('front.saveRating');



// Route for clearing cache
Route::get('/clear-cache', [FrontController::class, 'clearCache'])->name('front.clearCache');



// Socialite Login Url
// Route to redirect to Google for authentication
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');

// Route to handle the callback from Google
Route::get('auth/google/call-back', [GoogleController::class, 'handleGoogleCallback'])->name('google.call-back');


// Frontend route
Route::get('/show-Footer', [FrontController::class, 'showFooter'])->name('homepage');

//Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');

Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
        // Socialite Login Url

        Route::get('/register', [AuthController::class, 'register'])->name('account.register');
        Route::post('/process-register', [AuthController::class, 'processRegister'])->name('account.processRegister');

    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('account.updateProfile');
        Route::post('/update-address', [AuthController::class, 'updateAddress'])->name('account.updateAddress');
        Route::get('/my-orders', [AuthController::class, 'orders'])->name('account.orders');
        Route::get('/my-wishlist', [AuthController::class, 'wishlist'])->name('account.wishlist');
        Route::post('/remove-product-from-wishlist', [AuthController::class, 'removeProductFromWishList'])->name('account.removeProductFromWishList');
        Route::get('/order-detail/{orderId}', [AuthController::class, 'orderDetail'])->name('account.orderDetail');
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
        Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('account.changePassword');
        Route::post('/process-change-password', [AuthController::class, 'changePassword'])->name('account.processChangePassword');
    });

});


Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'admin.guest'], function () {

        Route::get('/Registration', [adminlogincontroller::class, 'registration'])->name('admin.registration');
        Route::post('/register-users', [adminlogincontroller::class, 'registerUsers'])->name('admin.registerUsers');
        Route::get('/login', [adminlogincontroller::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [adminlogincontroller::class, 'authenticate'])->name('admin.authenticate');

        //

    });

    // Route::get('/optimize-clear', function () {
    //     Artisan::call('optimize:clear');
    //     return response()->json(['message' => 'Optimization cache cleared successfully.']);
    // });
    Route::group(['middleware' => 'admin.auth'], function () {

        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        // Route for clearing cache
        Route::get('/clear-cache', [HomeController::class, 'clearCache'])->name('admin.clearCache');


        //Category Route
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.delete');

        // Sub Category Route
        Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('sub-categories.index');
        Route::get('/sub-categories/create', [SubCategoryController::class, 'create'])->name('sub-categories.create');
        Route::post('/sub-categories', [SubCategoryController::class, 'store'])->name('sub-categories.store');
        Route::get('/sub-categories/{subCategory}/edit', [SubCategoryController::class, 'edit'])->name('sub-categories.edit');
        Route::put('/sub-categories/{subCategory}', [SubCategoryController::class, 'update'])->name('sub-categories.update');
        Route::delete('/sub-categories/{subCategory}', [SubCategoryController::class, 'destroy'])->name('sub-categories.delete');


        // Brands Route
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brands}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brands}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brands}', [BrandController::class, 'destroy'])->name('brands.delete');

        // Contact Us Route
        // Route to list contact information
        Route::get('/admin/contact_us', [ContactUsController::class, 'index'])->name('admin.contact_us.index');

        // Route to Create contact information
        Route::get('/admin/contact_us/create', [ContactUsController::class, 'create'])->name('admin.contact_us.create'); // Show form for creating

        // Route to Store contact information
        Route::post('/admin/contact_us', [ContactUsController::class, 'store'])->name('admin.contact_us.store');        // Store new entry

        // Route to edit contact information
        Route::get('/admin/contact_us/edit/{id}', [ContactUsController::class, 'edit'])->name('admin.contact_us.edit');

        // Route to update contact information
        Route::post('/admin/contact_us/update/{id}', [ContactUsController::class, 'update'])->name('admin.contact_us.update');

        // Route to delete contact information
        Route::delete('/admin/contact_us/destroy/{id}', [ContactUsController::class, 'destroy'])->name('admin.contact_us.destroy');


        // Product Route
        Route::get('/products', [ProductController::class, 'index'])->name('product.index');
        // Add this line to define the route for fetching sub-categories
        //Route::get('/sub-categories', [ProductController::class, 'getSubCategories'])->name('sub-categories.getSubCategories');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{product}', [ProductController::class, 'update'])->name('product.update');
        //Route::delete('/product', [ProductController::class, 'destroy'])->name('product.delete');
        //Route::delete('/admin/product-images/{id}', [ProductController::class, 'destroy'])->name('product-images.destroy');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('product.getProducts');

        Route::get('/product-subcategories', [ProductSubCategoryController::class, 'index'])->name('product-subcategories.index');

        Route::post('/product-images/update', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::delete('/admin/product-images/', [ProductImageController::class, 'destroy'])->name('product-images.destroy');
        Route::get('/ratings', [ProductController::class, 'productRatings'])->name('product.productRatings');
        Route::get('/change-rating-status', [ProductController::class, 'changeRatingStatus'])->name('product.changeRatingStatus');

        // Shipping Routes
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping', [ShippingController::class, 'store'])->name('shipping.store');
        Route::get('/shipping/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::put('/shipping/{id}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::delete('/shipping/{id}', [ShippingController::class, 'destroy'])->name('shipping.destroy');

        // Discount - Coupon Routes.
        Route::get('/coupons', [DiscountCodeController::class, 'index'])->name('coupons.index');
        // // Add this line to define the route for fetching sub-categories
        // //Route::get('/sub-categories', [ProductController::class, 'getSubCategories'])->name('sub-categories.getSubCategories');
        Route::get('/coupons/create', [DiscountCodeController::class, 'create'])->name('coupons.create');
        Route::post('/coupons', [DiscountCodeController::class, 'store'])->name('coupons.store');
        Route::get('/coupons/{coupon}/edit', [DiscountCodeController::class, 'edit'])->name('coupons.edit');
        Route::put('/coupon/{coupon}', [DiscountCodeController::class, 'update'])->name('coupons.update');
        Route::delete('/coupons/{coupon}', [DiscountCodeController::class, 'destroy'])->name('coupons.delete');
        // //Route::delete('/admin/product-images/{id}', [ProductController::class, 'destroy'])->name('product-images.destroy');
        // Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');


        // Order Routes 
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'detail'])->name('orders.detail');
        Route::post('/order/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('orders.changeOrderStatus');
        Route::post('/order/send-email/{id}', [OrderController::class, 'sendInvoiceEmail'])->name('orders.sendInvoiceEmail');

        // Users Route
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{users}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{users}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{users}', [UserController::class, 'destroy'])->name('users.destroy');
        // Route::delete('/brands/{brands}', [BrandController::class, 'destroy'])->name('brands.delete');

          // Pages Route
          Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
          Route::get('/pages/create', [PageController::class, 'create'])->name('pages.create');
          Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
          Route::get('/pages/{pages}/edit', [PageController::class, 'edit'])->name('pages.edit');
          Route::put('/pages/{pages}', [PageController::class, 'update'])->name('pages.update');
          Route::delete('/pages/{pages}', [PageController::class, 'destroy'])->name('pages.destroy');

        //temp-images.create
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

        // Setting Route.
        Route::get('/change-password', [SettingController::class, 'showChangePasswordForm'])->name('admin.showChangePasswordForm');
        // processChangePassword
        Route::post('/process-change-password', [SettingController::class, 'processChangePassword'])->name('admin.processChangePassword');

        Route::get('/getSlug', function (Request $request) {
            $slug = '';
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');
    });


});
