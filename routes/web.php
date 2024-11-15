<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\FrontController;

use App\Http\Controllers\Auth\Admin\RegisterController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Auth\Admin\ForgetPasswordController;
use App\Http\Controllers\Auth\Admin\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController as VendorRegisterController; // Import RegisterController for vendor registration
use App\Http\Controllers\Front\VendorController;
use App\Http\Controllers\Admin\{ 
    SiteAdsController, 
    CityadController, 
    PlaceadController, 
    LogoController, 
    CityController, 
    PlaceController, 
    HostelController,
    HostelPriceController,
    HostelGalleryController,
    ServiceController, 
    BookingController,
    SocialMediaController, 
    HostelOwnerController, 
    BlogController,
    MetaKeyController,
    PageController ,
    MobileAppController,
    HomeBackgroundImageController,
    SiteContactController,
    OfferBackgroundImageController,

};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// User route
Route::post('/eze-hostels/update-user', [UserController::class, 'updateUser'])->name('updateuser');

// Vendor routes with middleware
Route::prefix('/easy-hostels/vendor')->middleware(['vendor'])->group(function () {
    Route::post('update-profile', [UserController::class, 'updateVendor'])->name('updatevendor');
    Route::post('hostel-store', [UserController::class, 'vendorHostelStore'])->name('vendorhostelstore');
    Route::post('hostel-gallery-store', [UserController::class, 'vendorHostelGalleryStore'])->name('vendorhostelgallerystore');
    Route::post('hostel-pricing-store', [UserController::class, 'vendorHostelPricingStore'])->name('vendorhostelpricingstore');

    Route::get('{id}/hostels', [UserController::class, 'getAllVendorHostels'])->name('getallvendorhostels');
    Route::get('{id}/hostels-gallery', [UserController::class, 'getAllVendorHostelsGallery'])->name('getallvendorhostelsgallery');
    Route::get('{id}/hostels-pricing', [UserController::class, 'getAllVendorHostelsPricing'])->name('getallvendorhostelspricing');

    Route::get('hostel-edit/{id}', [UserController::class, 'vendorHostelEdit'])->name('vendorhosteledit');
    Route::post('hostel-update/{id}', [UserController::class, 'vendorHostelUpdate'])->name('vendorhostelupdate');
    Route::get('hostel-delete/{id}', [UserController::class, 'vendorHostelDelete'])->name('vendorhosteldelete');

    Route::get('hostel-gallery-edit/{id}', [UserController::class, 'vendorHostelGalleryEdit'])->name('vendorhostelgalleryedit');
    Route::post('hostel-gallery-update/{id}', [UserController::class, 'vendorHostelGalleryUpdate'])->name('vendorhostelgalleryupdate');
    Route::get('hostel-gallery-delete/{id}', [UserController::class, 'vendorHostelGalleryDelete'])->name('vendorhostelgallerydelete');

    Route::get('hostel-pricing-edit/{id}', [UserController::class, 'vendorHostelPricingEdit'])->name('vendorhostelpricingedit');
    Route::post('hostel-pricing-update/{id}', [UserController::class, 'vendorHostelPricingUpdate'])->name('vendorhostelpricingupdate');
    Route::get('hostel-pricing-delete/{id}', [UserController::class, 'vendorHostelPricingDelete'])->name('vendorhostelpricingdelete');
});
Route::get('/home', [HomeController::class, 'index']);
Route::get('/', [HomeController::class, 'index'])->name('home');

// Hostel search from home page
Route::get('/eze-hostels/search', [HomeController::class, 'search']);
Route::get('/eze-hostels/eze-search', [HomeController::class, 'homeSearch']);

// Getting all cities for adding hostel from frontend
Route::get('/getallcities', [CityController::class, 'getAllCities'])->name('city.getallcities');

// Getting all services for adding hostel from frontend
Route::get('/getallservices', [ServiceController::class, 'getAllServices'])->name('service.getallservices');

// Getting places by city ID when city is changed in home page search
Route::get('/getplacebycityid/{id}', [PlaceController::class, 'getPlaceByCityId']);

// Hostel by menu click
Route::get('/eze-hostels/city/{city}', [FrontController::class, 'getHostelByCity']);
Route::get('/eze-hostels/place/{place}', [FrontController::class, 'getHostelByPlace']);

// Services
Route::get('/eze-hostels/services', [FrontController::class, 'getServices'])->name('services');

// Blogs
Route::get('/eze-hostels/blogs', [FrontController::class, 'getBlogs'])->name('blogs');
Route::get('/eze-hostels/blog/{slug}', [FrontController::class, 'getSingleBlog']);

// Booking Hostel
Route::get('/eze-hostels/booking', [FrontController::class, 'getBooking'])->name('booking');
Route::post('/eze-hostels/book', [FrontController::class, 'book'])->name('book');

// Laravel AJAX hostels filter
Route::get('/eze-hostels/hostel-filter', [FrontController::class, 'hostelFilter']);

// Eze pages
Route::get('/eze-hostels/about-us', [FrontController::class, 'getAboutUs'])->name('aboutus');
Route::get('/eze-hostels/privacy-policy', [FrontController::class, 'getPrivacyPolicy'])->name('privacypolicy');
Route::get('/eze-hostels/term-conditions', [FrontController::class, 'getTermConditions'])->name('termconditions');
Route::get('/eze-hostels/guest-policy', [FrontController::class, 'getGuestPolicy'])->name('guestpolicy');

// Single Hostel
Route::get('/eze-hostels/{slug}', [FrontController::class, 'singleHostel']);

// All Hostels
Route::get('/eze-hostels/all-hostel-list', [HomeController::class, 'allHostelsList'])->name('allhostelslist');

// Auth routes
Auth::routes();

// Admin Auth Section
Route::prefix('admin')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('admin.register.post');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.post');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/reset', [ForgetPasswordController::class, 'showLinkRequestForm'])->name('admin.request');
    Route::post('/email', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('admin.email');
    Route::post('/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.update');
    Route::get('/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.reset');
});


Route::prefix('easy-hostel')->middleware('admin')->group(function () {

    // Dashboard Route
    Route::get('/back-end', function () {
        return view('admin.index');
    })->name('dashboard');

    // Site Ads Routes
    Route::prefix('ads')->group(function () {
        Route::get('/', [SiteAdsController::class, 'index'])->name('ads');
        Route::post('/store', [SiteAdsController::class, 'store'])->name('ads.store');
        Route::get('/edit/{id}', [SiteAdsController::class, 'edit'])->name('ads.edit');
        Route::post('/update/{id}', [SiteAdsController::class, 'update'])->name('ads.update');
        Route::get('/delete/{id}', [SiteAdsController::class, 'destroy'])->name('ads.delete');
        Route::get('/show/{id}', [SiteAdsController::class, 'show'])->name('ads.show');
        Route::get('/getads', [SiteAdsController::class, 'getads'])->name('ads.getads');
    });

    // City Ads Routes
    Route::prefix('cityads')->group(function () {
        Route::get('/', [CityadController::class, 'index'])->name('cityads');
        Route::post('/store', [CityadController::class, 'store'])->name('cityads.store');
        Route::get('/edit/{id}', [CityadController::class, 'edit'])->name('cityads.edit');
        Route::post('/update/{id}', [CityadController::class, 'update'])->name('cityads.update');
        Route::get('/delete/{id}', [CityadController::class, 'destroy'])->name('cityads.delete');
        Route::get('/show/{id}', [CityadController::class, 'show'])->name('cityads.show');
        Route::get('/getcityads', [CityadController::class, 'getcityads'])->name('cityads.getcityads');
        Route::get('/getallcityad', [CityadController::class, 'getallcityad'])->name('cityads.getallcityad');
    });

    // Place Ads Routes
    Route::prefix('placeads')->group(function () {
        Route::get('/', [PlaceadController::class, 'index'])->name('placeads');
        Route::post('/store', [PlaceadController::class, 'store'])->name('placeads.store');
        Route::get('/edit/{id}', [PlaceadController::class, 'edit'])->name('placeads.edit');
        Route::post('/update/{id}', [PlaceadController::class, 'update'])->name('placeads.update');
        Route::get('/delete/{id}', [PlaceadController::class, 'destroy'])->name('placeads.delete');
        Route::get('/show/{id}', [PlaceadController::class, 'show'])->name('placeads.show');
        Route::get('/getplaceads', [PlaceadController::class, 'getplaceads'])->name('placeads.getplaceads');
        Route::get('/getAllplaceads', [PlaceadController::class, 'getAllplaceads'])->name('placeads.getAllplaceads');
        Route::get('/getplaceadsbyplaceid', [PlaceadController::class, 'getplaceadsbyplaceid'])->name('placeads.getplaceadsbyplaceid');
    });

    // Site Logo Routes
    Route::prefix('site-logo')->group(function () {
        Route::get('/', [LogoController::class, 'index'])->name('logo');
        Route::post('/store', [LogoController::class, 'store'])->name('logo.store');
        Route::get('/edit/{id}', [LogoController::class, 'edit'])->name('logo.edit');
        Route::post('/update/{id}', [LogoController::class, 'update'])->name('logo.update');
        Route::get('/delete/{id}', [LogoController::class, 'destroy'])->name('logo.delete');
        Route::get('/show/{id}', [LogoController::class, 'show'])->name('logo.show');
        Route::get('/getLogo', [LogoController::class, 'getLogo'])->name('logo.getLogo');
    });

    // City Routes
    Route::prefix('city')->group(function () {
        Route::get('/', [CityController::class, 'index'])->name('city');
        Route::post('/store', [CityController::class, 'store'])->name('city.store');
        Route::get('/edit/{id}', [CityController::class, 'edit'])->name('city.edit');
        Route::post('/update/{id}', [CityController::class, 'update'])->name('city.update');
        Route::get('/delete/{id}', [CityController::class, 'destroy'])->name('city.delete');
        Route::get('/show/{id}', [CityController::class, 'show'])->name('city.show');
        Route::get('/getcity', [CityController::class, 'getcity'])->name('city.getcity');
        Route::get('/getallcity', [CityController::class, 'getallcity'])->name('city.getallcity');
    });

    // Place Routes
    Route::prefix('place')->group(function () {
        Route::get('/', [PlaceController::class, 'index'])->name('place');
        Route::post('/store', [PlaceController::class, 'store'])->name('place.store');
        Route::get('/edit/{id}', [PlaceController::class, 'edit'])->name('place.edit');
        Route::post('/update/{id}', [PlaceController::class, 'update'])->name('place.update');
        Route::get('/delete/{id}', [PlaceController::class, 'destroy'])->name('place.delete');
        Route::get('/show/{id}', [PlaceController::class, 'show'])->name('place.show');
        Route::get('/getplace', [PlaceController::class, 'getplace'])->name('place.getplace');
        Route::get('/getallplace', [PlaceController::class, 'getallplace'])->name('place.getallplace');
    });
    Route::prefix('social')->group(function () {
        Route::get('/', [SocialMediaController::class, 'index'])->name('social');
        Route::post('/store', [SocialMediaController::class, 'store'])->name('social.store');
        Route::get('/edit/{id}', [SocialMediaController::class, 'edit'])->name('social.edit');
        Route::post('/update/{id}', [SocialMediaController::class, 'update'])->name('social.update');
        Route::get('/delete/{id}', [SocialMediaController::class, 'destroy'])->name('social.delete');
        Route::get('/show/{id}', [SocialMediaController::class, 'show'])->name('social.show');
        Route::get('/getsocial', [SocialMediaController::class, 'getsocial'])->name('social.getsocial');
    });
    
    // Service Routes
    Route::prefix('service')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('service');
        Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
        Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
        Route::post('/update/{id}', [ServiceController::class, 'update'])->name('service.update');
        Route::get('/delete/{id}', [ServiceController::class, 'destroy'])->name('service.delete');
        Route::get('/show/{id}', [ServiceController::class, 'show'])->name('service.show');
        Route::get('/getservice', [ServiceController::class, 'getservice'])->name('service.getservice');
        Route::get('/getallservice', [ServiceController::class, 'getallservice'])->name('service.getallservice');
    });

    // Social Media Routes
    Route::prefix('social')->group(function () {
        Route::get('/', [SocialMediaController::class, 'index'])->name('social');
        Route::post('/store', [SocialMediaController::class, 'store'])->name('social.store');
        Route::get('/edit/{id}', [SocialMediaController::class, 'edit'])->name('social.edit');
        Route::post('/update/{id}', [SocialMediaController::class, 'update'])->name('social.update');
        Route::get('/delete/{id}', [SocialMediaController::class, 'destroy'])->name('social.delete');
        Route::get('/show/{id}', [SocialMediaController::class, 'show'])->name('social.show');
    });

    Route::prefix('offer-background-image')->group(function () {
        Route::get('/', [OfferBackgroundImageController::class, 'index'])->name('offerbackgroundimage');
        Route::post('/store', [OfferBackgroundImageController::class, 'store'])->name('offerbackgroundimage.store');
        Route::get('/edit/{id}', [OfferBackgroundImageController::class, 'edit'])->name('offerbackgroundimage.edit');
        Route::post('/update/{id}', [OfferBackgroundImageController::class, 'update'])->name('offerbackgroundimage.update');
        Route::get('/delete/{id}', [OfferBackgroundImageController::class, 'destroy'])->name('offerbackgroundimage.delete');
        Route::get('/show/{id}', [OfferBackgroundImageController::class, 'show'])->name('offerbackgroundimage.show');
        Route::get('/getofferbackgroundimage', [OfferBackgroundImageController::class, 'getofferbackgroundimage'])->name('offerbackgroundimage.getofferbackgroundimage');
    });
    
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('bookings');
        Route::get('/getbooking', [BookingController::class, 'getbooking'])->name('bookings.getbooking');
    });
    // Hostel routes
Route::prefix('hostel')->group(function () {
    Route::get('/', [HostelController::class, 'index'])->name('hostel');
    Route::post('/store', [HostelController::class, 'store'])->name('hostel.store');
    Route::get('/edit/{id}', [HostelController::class, 'edit'])->name('hostel.edit');
    Route::post('/update/{id}', [HostelController::class, 'update'])->name('hostel.update');
    Route::get('/delete/{id}', [HostelController::class, 'destroy'])->name('hostel.delete');
    Route::get('/show/{id}', [HostelController::class, 'show'])->name('hostel.show');
    Route::get('/gethostel', [HostelController::class, 'gethostel'])->name('hostel.gethostel');
    Route::get('/getallhostel', [HostelController::class, 'getallhostel'])->name('hostel.getallhostel');
});
Route::prefix('page')->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('page');
    Route::post('/store', [PageController::class, 'store'])->name('page.store');
    Route::get('/edit/{id}', [PageController::class, 'edit'])->name('page.edit');
    Route::post('/update/{id}', [PageController::class, 'update'])->name('page.update');
    Route::get('/delete/{id}', [PageController::class, 'destroy'])->name('page.delete');
    Route::get('/show/{id}', [PageController::class, 'show'])->name('page.show');
    Route::get('/getpage', [PageController::class, 'getpage'])->name('page.getpage');
});
Route::prefix('home-background-image')->group(function () {
    Route::get('/', [HomeBackgroundImageController::class, 'index'])->name('homebackgroundimage');
    Route::post('/store', [HomeBackgroundImageController::class, 'store'])->name('homebackgroundimage.store');
    Route::get('/edit/{id}', [HomeBackgroundImageController::class, 'edit'])->name('homebackgroundimage.edit');
    Route::post('/update/{id}', [HomeBackgroundImageController::class, 'update'])->name('homebackgroundimage.update');
    Route::get('/delete/{id}', [HomeBackgroundImageController::class, 'destroy'])->name('homebackgroundimage.delete');
    Route::get('/show/{id}', [HomeBackgroundImageController::class, 'show'])->name('homebackgroundimage.show');
    Route::get('/gethomebackgroundimage', [HomeBackgroundImageController::class, 'gethomebackgroundimage'])->name('homebackgroundimage.gethomebackgroundimage');
});
Route::prefix('offer-background-image')->group(function () {
    Route::get('/', [OfferBackgroundImageController::class, 'index'])->name('offerbackgroundimage');
    Route::post('/store', [OfferBackgroundImageController::class, 'store'])->name('offerbackgroundimage.store');
    Route::get('/edit/{id}', [OfferBackgroundImageController::class, 'edit'])->name('offerbackgroundimage.edit');
    Route::post('/update/{id}', [OfferBackgroundImageController::class, 'update'])->name('offerbackgroundimage.update');
    Route::get('/delete/{id}', [OfferBackgroundImageController::class, 'destroy'])->name('offerbackgroundimage.delete');
    Route::get('/show/{id}', [OfferBackgroundImageController::class, 'show'])->name('offerbackgroundimage.show');
    Route::get('/getofferbackgroundimage', [OfferBackgroundImageController::class, 'getofferbackgroundimage'])->name('offerbackgroundimage.getofferbackgroundimage');
});
Route::prefix('site-contact')->group(function () {
    Route::get('/', [SiteContactController::class, 'index'])->name('sitecontact');
    Route::post('/store', [SiteContactController::class, 'store'])->name('sitecontact.store');
    Route::get('/edit/{id}', [SiteContactController::class, 'edit'])->name('sitecontact.edit');
    Route::post('/update/{id}', [SiteContactController::class, 'update'])->name('sitecontact.update');
    Route::get('/delete/{id}', [SiteContactController::class, 'destroy'])->name('sitecontact.delete');
    Route::get('/show/{id}', [SiteContactController::class, 'show'])->name('sitecontact.show');
    Route::get('/getsitecontact', [SiteContactController::class, 'getsitecontact'])->name('sitecontact.getsitecontact');
});

// Hostel Pricing routes
Route::prefix('hostel-price')->group(function () {
    Route::get('/', [HostelPriceController::class, 'index'])->name('hostelprice');
    Route::post('/store', [HostelPriceController::class, 'store'])->name('hostelprice.store');
    Route::get('/edit/{id}', [HostelPriceController::class, 'edit'])->name('hostelprice.edit');
    Route::post('/update/{id}', [HostelPriceController::class, 'update'])->name('hostelprice.update');
    Route::get('/delete/{id}', [HostelPriceController::class, 'destroy'])->name('hostelprice.delete');
    Route::get('/show/{id}', [HostelPriceController::class, 'show'])->name('hostelprice.show');
    Route::get('/gethostelprice', [HostelPriceController::class, 'gethostelprice'])->name('hostelprice.gethostelprice');
});
Route::prefix('mobileapp')->group(function () {
    Route::get('/', [MobileAppController::class, 'index'])->name('mobileapp');
    Route::post('/store', [MobileAppController::class, 'store'])->name('mobileapp.store');
    Route::get('/edit/{id}', [MobileAppController::class, 'edit'])->name('mobileapp.edit');
    Route::post('/update/{id}', [MobileAppController::class, 'update'])->name('mobileapp.update');
    Route::get('/delete/{id}', [MobileAppController::class, 'destroy'])->name('mobileapp.delete');
    Route::get('/show/{id}', [MobileAppController::class, 'show'])->name('mobileapp.show');
    Route::get('/getmobileapp', [MobileAppController::class, 'getmobileapp'])->name('mobileapp.getmobileapp');
});

// Hostel Image Gallery routes
Route::prefix('hostel-gallery')->group(function () {
    Route::get('/', [HostelGalleryController::class, 'index'])->name('hostelgallery');
    Route::post('/store', [HostelGalleryController::class, 'store'])->name('hostelgallery.store');
    Route::get('/edit/{id}', [HostelGalleryController::class, 'edit'])->name('hostelgallery.edit');
    Route::post('/update/{id}', [HostelGalleryController::class, 'update'])->name('hostelgallery.update');
    Route::get('/delete/{id}', [HostelGalleryController::class, 'destroy'])->name('hostelgallery.delete');
    Route::get('/show/{id}', [HostelGalleryController::class, 'show'])->name('hostelgallery.show');
    Route::get('/gethostelgallery', [HostelGalleryController::class, 'gethostelgallery'])->name('hostelgallery.gethostelgallery');
});
Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog');
    Route::post('/store', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
    Route::post('/update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::get('/delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');
    Route::get('/show/{id}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/getblog', [BlogController::class, 'getblog'])->name('blog.getblog');
    Route::get('/getallblog', [BlogController::class, 'getallblog'])->name('blog.getallblog');
});

    // User Routes
    Route::prefix('hostel-owner')->group(function () {
        Route::get('/', [HostelOwnerController::class, 'index'])->name('hostelowner');
        Route::get('/edit/{id}', [HostelOwnerController::class, 'edit'])->name('hostelowner.edit');
        Route::post('/update/{id}', [HostelOwnerController::class, 'update'])->name('hostelowner.update');
        Route::get('/gethostelowner', [HostelOwnerController::class, 'gethostelowner'])->name('hostelowner.gethostelowner');
    });

    // Meta Key Description Routes
    Route::prefix('metakey')->group(function () {
        Route::get('/', [MetaKeyController::class, 'index'])->name('metakey');
        Route::post('/store', [MetaKeyController::class, 'store'])->name('metakey.store');
        Route::get('/edit/{id}', [MetaKeyController::class, 'edit'])->name('metakey.edit');
        Route::post('/update/{id}', [MetaKeyController::class, 'update'])->name('metakey.update');
        Route::get('/delete/{id}', [MetaKeyController::class, 'destroy'])->name('metakey.delete');
        Route::get('/getmetakey', [MetaKeyController::class, 'getmetakey'])->name('metakey.getmetakey');
    });
});

Route::prefix('vendor')->group(function () {
    Route::get('/register-as-vendor', [VendorRegisterController::class, 'showVendorRegistrationForm'])->name('registerasvendor');
    Route::post('/register-as-vendor', [VendorRegisterController::class, 'registervendor'])->name('vendorregister');
    Route::get('/user-dashboard', [VendorController::class, 'dashboard'])->middleware('auth')->name('vendordashboard');
});




Auth::routes();