<?php

use App\Http\Controllers\Backend\AdminCategoryNewsController;
use App\Http\Controllers\Backend\AdminCategoryService;
use App\Http\Controllers\Backend\AdminCouponController;
use App\Http\Controllers\Backend\AdminLinkController;
use App\Http\Controllers\Backend\AdminNewsController;
use App\Http\Controllers\Backend\AdminOrderController;
use App\Http\Controllers\Backend\AdminServiceController;
use App\Http\Controllers\Backend\AdminSettingController;
use App\Http\Controllers\Backend\AdminSlideshowController;
use App\Http\Controllers\Backend\AdminSloganController;
use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\MomoController;
use App\Http\Controllers\Frontend\NewsController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});



/* Verify Email */

Auth::routes(['verify' => true]);

/* [GET] Route after logout */
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
});

Route::get('/admin', function () {
    return redirect('/login');
});


/*------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/**
 * 
 * GOOGLE LOGIN ROUTING
 * 
 * */
Route::get('/get-info-google-login', [GoogleController::class, 'getInfoGoogleLogin']);
Route::get('/api/callback', [GoogleController::class, 'callbackLoginGoogle']);

/*------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/* FRONTEND ROUTE WEB */

// HOME PAGE
/* [GET] Route Home */
Route::get('/', [IndexController::class, 'index']);
Route::get('/service/load_ajax', [IndexController::class, 'load_ajax']);

// ORDER PAGE
/* [GET] Route Index Order */
Route::get('/order/index', [OrderController::class, 'index']);
/* [GET] Route Create Order */
Route::get('/order/create/{id}', [OrderController::class, 'create'])->name('order.create');
/* [POST] Route Update Order */
Route::post('/order/update', [OrderController::class, 'update']);
/* [POST] Route Update Order AJAX */
Route::POST('/order/update_ajax', [OrderController::class, 'update_ajax']);
/* [DELETE] Route Delete Order AJAX */
Route::delete('/order/delete/{rowId}', [OrderController::class, 'remove'])->name('order.delete');
/* [POST] Route Checkout Order */
Route::post('/order/checkout/store', [OrderController::class, 'store']);
/* [GET] Route Checkout Order */
Route::get('/order/show', [OrderController::class, 'show']);
/* [GET] Route Reset Order */
Route::get('/order/reset', [OrderController::class, 'reset']);
/* [GET] Route Feedback Order */
Route::get('/order/feedback', [OrderController::class, 'feedback']);
/* [GET] Route Feedback Order */
Route::get('/order/feedback', [OrderController::class, 'feedback']);
/* [GET] Route Coupon */
Route::post('/order/coupon', [OrderController::class, 'coupon']);


// VNPAY PAYMENT PAGE
/* [POST] Route Vnpay store */
Route::post('/order/vnpay/store', [PaymentController::class, 'store']);
Route::get('/order/vnpay/checkout', [PaymentController::class, 'checkout']);

// MOMO PAYMENT PAGE
/* [POST] Route Momo store */
Route::post('/order/momo/store', [MomoController::class, 'store']);
Route::get('/order/momo/checkout', [MomoController::class, 'checkout']);


// SERVICE PAGE
/* [GET] Route Service Index */
Route::get('dich-vu', [ServiceController::class, 'index'])->name('service.index');
/* [GET] Route Service Show */
Route::get('dich-vu/{slug}', [ServiceController::class, 'show'])->name('service.show');


// NEWS PAGE
/* [GET] Route News Index */
Route::get('tin-tuc', [NewsController::class, 'index'])->name('news.index');
/* [GET] Route News Show */
Route::get('tin-tuc/{slug}', [NewsController::class, 'show'])->name('news.show');


/*------------------------------------------------------------------------------------------------------------------------------------------------------------------*/


/* BACKEND ROUTE WEB */
Route::middleware(['auth', 'password.confirm', 'CheckUserLogin'])->group(function () {
    /* [GET] Route after login */
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');


    // ROUTE ADMIN USER
    /*[GET] index*/
    Route::get('admin/user/index', [AdminUserController::class, 'index']);
    /* [GET] create */
    Route::get('admin/user/create', [AdminUserController::class, 'create']);
    /* [GET] updatePassword */
    Route::get('admin/user/updatePassword', [AdminUserController::class, 'updatePassword']);
    /* [GET] edit */
    Route::get('admin/user/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
    /* [PUT] store update */
    Route::put('admin/user/store/{id}', [AdminUserController::class, 'store']);
    /* [DELETE] delete */
    Route::delete('admin/user/delete/{id}', [AdminUserController::class, 'delete'])->name('admin.user.delete');
    /* [POST] action */
    Route::post('admin/user/action', [AdminUserController::class, 'action']);
    /* [POST] store */
    Route::post('admin/user/create/store', [AdminUserController::class, 'create_store']);


    // ROUTE ADMIN SERVICE
    /* [GET] index */
    Route::get('admin/service/index', [AdminServiceController::class, 'index'])->name('admin.service.index');
    /* [GET] create */
    Route::get('admin/service/create', [AdminServiceController::class, 'create'])->name('admin.service.create');
    /* [POST] store */
    Route::post('admin/service/store/{id?}', [AdminServiceController::class, 'store'])->name('admin.service.store');
    /* [POST] edit ajax */
    Route::post('admin/service/edit_ajax', [AdminServiceController::class, 'edit_ajax'])->name('admin.service.edit_ajax');
    /* [GET] edit */
    Route::get('admin/service/edit/{id}', [AdminServiceController::class, 'edit'])->name('admin.service.edit');
    /* [POST] action */
    Route::post('admin/service/action', [AdminServiceController::class, 'action']);
    /* [POST] state */
    Route::post('admin/service/state', [AdminServiceController::class, 'state']);
    /* [POST] remove_state */
    Route::post('admin/service/remove_state', [AdminServiceController::class, 'remove_state']);
    /* [DELETE] delete */
    Route::delete('admin/service/delete/{id}', [AdminServiceController::class, 'delete'])->name('admin.service.delete');
    /* [GET] copy */
    Route::get('admin/service/copy/{id}', [AdminServiceController::class, 'copy'])->name('admin.service.copy');


    // CATEGORY SERVICE LEVEL 1
    /* [GET] index */
    Route::get('admin/category_service/index', [AdminCategoryService::class, 'index'])->name('admin.category_service.index');
    /* [GET] edit */
    Route::get('admin/category_service/edit/{id}', [AdminCategoryService::class, 'edit'])->name('admin.category_service.edit');
    /* [GET] create */
    Route::get('admin/category_service/create', [AdminCategoryService::class, 'create'])->name('admin.category_service.create');
    /* [POST] store */
    Route::post('admin/category_service/store/{id?}', [AdminCategoryService::class, 'store'])->name('admin.category_service.store');
    /* [POST] action */
    Route::post('admin/category_service/action', [AdminCategoryService::class, 'action'])->name('admin.category_service.action');
    /* [POST] state */
    Route::post('admin/category_service/state', [AdminCategoryService::class, 'state']);
    /* [POST] remove_state */
    Route::post('admin/category_service/remove_state', [AdminCategoryService::class, 'remove_state']);
    /* [DELETE] delete */
    Route::delete('admin/category_service/delete/{id}', [AdminCategoryService::class, 'delete'])->name('admin.category_service.delete');


    // CATEGORY SERVICE LEVEL 2
    /* [GET] create */
    Route::get('admin/category_service2/create', [AdminCategoryService::class, 'create_level2'])->name('admin.category_service2.create');
    /* [GET] edit */
    Route::get('admin/category_service2/edit/{id}', [AdminCategoryService::class, 'edit_level2'])->name('admin.category_service2.edit');
    /* [POST] store */
    Route::post('admin/category_service2/store/{id?}', [AdminCategoryService::class, 'store_level2'])->name('admin.category_service2.store');


    // ROUTE ADMIN ORDER
    /* [GET] index */
    Route::get('admin/order/index', [AdminOrderController::class, 'index']);
    /* [GET] show */
    Route::get('admin/order/show/{id}', [AdminOrderController::class, 'show'])->name('admin.order.show');
    /* [POST] action */
    Route::post('admin/order/action', [AdminOrderController::class, 'action'])->name('admin.order.action');
    /* [DELETE] delete */
    Route::delete('admin/order/delete/{id}', [AdminOrderController::class, 'delete'])->name('admin.order.delete');


    // ROUTE ADMIN COUPON
    /* [GET] index */
    Route::get('admin/coupon/index', [AdminCouponController::class, 'index']);
    /* [GET] create */
    Route::get('admin/coupon/create', [AdminCouponController::class, 'create']);
    /* [POST] store */
    Route::post('admin/coupon/store', [AdminCouponController::class, 'store']);
    /* [POST] action */
    Route::post('admin/coupon/action', [AdminCouponController::class, 'action']);
    /* [GET] action */
    Route::get('admin/coupon/edit/{id}', [AdminCouponController::class, 'edit'])->name('admin.coupon.edit');
    /* [POST] store */
    Route::post('admin/coupon/store/{id?}', [AdminCouponController::class, 'store'])->name('admin.coupon.store');


    // ROUTE ADMIN SLIDESHOW
    /* [GET] index */
    Route::get('admin/slideshow/index', [AdminSlideshowController::class, 'index']);
    /* [GET] create */
    Route::get('admin/slideshow/create', [AdminSlideshowController::class, 'create']);
    /* [POST] store */
    Route::post('admin/slideshow/store/{id?}', [AdminSlideshowController::class, 'store']);
    /* [GET] edit */
    Route::get('admin/slideshow/edit/{id}', [AdminSlideshowController::class, 'edit'])->name('admin.slideshow.edit');
    /* [GET] copy */
    Route::get('admin/slideshow/copy/{id}', [AdminSlideshowController::class, 'copy'])->name('admin.slideshow.copy');
    /* [POST] action */
    Route::post('admin/slideshow/action', [AdminSlideshowController::class, 'action']);
    /* [DELETE] delete */
    Route::delete('admin/slideshow/delete/{id}', [AdminSlideshowController::class, 'delete'])->name('admin.slideshow.delete');


    // ROUTE ADMIN SLOGAN
    /* [GET] index */
    Route::get('admin/slogan/index', [AdminSloganController::class, 'index']);
    /* [GET] create */
    Route::get('admin/slogan/create', [AdminSloganController::class, 'create']);
    /* [POST] store */
    Route::post('admin/slogan/store/{slug?}', [AdminSloganController::class, 'store']);
    /* [GET] edit */
    Route::get('admin/slogan/edit/{slug}', [AdminSloganController::class, 'edit'])->name('admin.slogan.edit');

    // ROUTE ADMIN LINK
    /* [GET] index */
    Route::get('admin/link/index', [AdminLinkController::class, 'index']);
    /* [GET] create */
    Route::get('admin/link/create', [AdminLinkController::class, 'create']);
    /* [POST] store */
    Route::post('admin/link/store/{id?}', [AdminLinkController::class, 'store']);
    /* [GET] edit */
    Route::get('admin/link/edit/{id}', [AdminLinkController::class, 'edit'])->name('admin.link.edit');
    /* [GET] delete */
    Route::get('admin/link/delete/{id}', [AdminLinkController::class, 'delete'])->name('admin.link.delete');

    // ROUTE ADMIN SETTING
    /* [GET] index */
    Route::get('admin/setting/index', [AdminSettingController::class, 'index']);
    /* [GET] create */
    Route::get('admin/setting/create', [AdminSettingController::class, 'create']);
    /* [POST] create */
    Route::post('admin/setting/store/{id?}', [AdminSettingController::class, 'store']);
    /* [GET] edit */
    Route::get('admin/setting/edit/{id}', [AdminSettingController::class, 'edit'])->name('admin.slogan.edit');


    // ROUTE ADMIN NEWS
    /* [GET] index */
    Route::get('admin/news/index', [AdminNewsController::class, 'index']);
    /* [GET] create */
    Route::get('admin/news/create', [AdminNewsController::class, 'create']);
    /* [POST] store */
    Route::post('admin/news/store/{id?}', [AdminNewsController::class, 'store'])->name('admin.news.store');
    /* [GET] edit */
    Route::get('admin/news/edit/{id}', [AdminNewsController::class, 'edit'])->name('admin.news.edit');
    /* [POST] action */
    Route::post('admin/news/action', [AdminNewsController::class, 'action']);
    /* [POST] edit ajax */
    Route::post('admin/news/edit_ajax', [AdminNewsController::class, 'edit_ajax'])->name('admin.news.edit_ajax');
    /* [POST] state */
    Route::post('admin/news/state', [AdminNewsController::class, 'state']);
    /* [POST] remove_state */
    Route::post('admin/news/remove_state', [AdminNewsController::class, 'remove_state']);
    /* [DELETE] delete */
    Route::delete('admin/news/delete/{id}', [AdminNewsController::class, 'delete'])->name('admin.news.delete');
    /* [GET] copy */
    Route::get('admin/news/copy/{id}', [AdminNewsController::class, 'copy'])->name('admin.news.copy');


    // CATEGORY NEWS LEVEL 1
    /* [GET] index */
    Route::get('admin/category_news/index', [AdminCategoryNewsController::class, 'index'])->name('admin.category_news.index');
    /* [GET] edit */
    Route::get('admin/category_news/edit/{id}', [AdminCategoryNewsController::class, 'edit'])->name('admin.category_news.edit');
    /* [GET] create */
    Route::get('admin/category_news/create', [AdminCategoryNewsController::class, 'create'])->name('admin.category_news.create');
    /* [POST] store */
    Route::post('admin/category_news/store/{id?}', [AdminCategoryNewsController::class, 'store'])->name('admin.category_news.store');
    /* [POST] action */
    Route::post('admin/category_news/action', [AdminCategoryNewsController::class, 'action'])->name('admin.category_news.action');
    /* [POST] state */
    Route::post('admin/category_news/state', [AdminCategoryNewsController::class, 'state']);
    /* [POST] remove_state */
    Route::post('admin/category_news/remove_state', [AdminCategoryNewsController::class, 'remove_state']);
    /* [DELETE] delete */
    Route::delete('admin/category_news/delete/{id}', [AdminCategoryNewsController::class, 'delete'])->name('admin.category_news.delete');


    // CATEGORY NEWS LEVEL 2
    /* [GET] create */
    Route::get('admin/category_news2/create', [AdminCategoryNewsController::class, 'create_level2'])->name('admin.category_news2.create');
    /* [GET] edit */
    Route::get('admin/category_news2/edit/{id}', [AdminCategoryNewsController::class, 'edit_level2'])->name('admin.category_news2.edit');
    /* [POST] store */
    Route::post('admin/category_news2/store/{id?}', [AdminCategoryNewsController::class, 'store_level2'])->name('admin.category_news2.store');
});

/*------------------------------------------------------------------------------------------------------------------------------------------------------------------*/