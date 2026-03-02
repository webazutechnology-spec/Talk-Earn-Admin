<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ApiUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->namespace('api')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
    Route::post('verify-otp', [AuthController::class, 'verify_otp']);
    Route::post('resend-otp', [AuthController::class, 'resend_otp']);

    Route::middleware('auth:sanctum')->group(function () {
        
        Route::get('user-listing', [ApiUserController::class, 'user_listing']);
        Route::get('user-listing/{id}', [ApiUserController::class, 'user_listing_details']);

        Route::prefix('user')->group(function () {
            Route::get('profile', [ApiUserController::class, 'profile']);
            Route::post('update-profile', [ApiUserController::class, 'update_profile']);
            Route::post('dashboard', [ApiUserController::class, 'dashboard']);
            Route::post('/updateprofessional', [ApiUserController::class, 'update_professional_profile']);
            Route::post('sendAadhaarOtp', [ApiUserController::class, 'sendAadhaarOtp']);
            Route::post('verifyAadhaarOtp', [ApiUserController::class, 'verifyAadhaarOtp']);
            Route::post('sendPanOtp', [ApiUserController::class, 'sendPanOtp']);
            Route::post('verifyPanOtp', [ApiUserController::class, 'verifyPanOtp']);
            Route::prefix('address')->group(function () {
                Route::post('/create', [ApiController::class, 'create']);
                Route::post('/update/{id}', [ApiController::class, 'update']);
                Route::get('/list', [ApiController::class, 'listByUser']);
                Route::get('info/{id}', [ApiController::class, 'getById']);
                Route::delete('delete/{id}', [ApiController::class, 'destroy']);
            });
        });

        // Route::prefix('cart')->group(function () {
        //     Route::post('/add', [ApiController::class, 'addToCart']);
        //     Route::post('/update-qty', [ApiController::class, 'updateCartQty']);
        //     Route::post('/remove', [ApiController::class, 'decreaseQuantity']);
        //     Route::delete('/remove', [ApiController::class, 'removeFromCart']);
        //     Route::delete('/empty', [ApiController::class, 'emptyCart']);
        //     Route::get('/get', [ApiController::class, 'viewCart']);
        // });

        // Route::prefix('wishlist')->group(function () {
        //     Route::post('/add', [ApiController::class, 'addToWishlist']);
        //     Route::delete('/remove', [ApiController::class, 'removeFromWishlist']);
        //     Route::get('/get', [ApiController::class, 'getWishlist']);
        // });

        // Route::prefix('order')->group(function () {
        //     Route::post('place', [ApiController::class, 'placeOrder']);
        //     Route::post('create-razorpay', [ApiController::class, 'createRazorpayOrder']);
        //     Route::get('list', [ApiController::class, 'orderList']);
        //     Route::get('detail/{orderid}', [ApiController::class, 'orderDetail']);
        //     Route::post('cancel', [ApiController::class, 'cancelOrder']);
        //     Route::post('apply-coupon', [ApiController::class, 'applyCoupon']);
        // });
    });

    Route::get('states', [ApiController::class, 'getStates']);
    Route::get('cities/{state}', [ApiController::class, 'getCities']);

    // Route::middleware('apiAuth:not_required')->group(function () {

    //     Route::get('categories', [ApiController::class, 'getCategory']);
    //     Route::get('sub-categories', [ApiController::class, 'getSubCategory']);
    //     Route::get('brand', [ApiController::class, 'getBrand']);
    //     Route::get('home-module', [ApiController::class, 'homeModule']);
    //     Route::get('sliders', [ApiController::class, 'getSlider']);
    //     Route::get('products', [ApiController::class, 'products']);
    //     Route::get('product/{id}', [ApiController::class, 'productDetail']);
    //     Route::get('search', [ApiController::class, 'search']);
    // });

    Route::get('static-content/{type}', [ApiController::class, 'appWebsiteInfo']);
    Route::get('app-config', [ApiController::class, 'websiteSettings']);
});
