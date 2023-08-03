<?php

use App\Http\Controllers\InquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\JWTAuthController;
use App\Http\Controllers\ServiceController;

Route::middleware('jwt.auth')->group(function () {
    // inquiryRefs Routes
    Route::get('inquiry', [InquiryController::class, 'getInquiries']);
    Route::post('inquiry', [InquiryController::class, 'postInquiry']);
    Route::post('inquiry/{inquiryId}', [InquiryController::class, 'putInquiry']);
    Route::delete('inquiry/{inquiryId}', [InquiryController::class, 'deleteInquiry']);


    // serviceRefs Routes
    Route::get('service', [ServiceController::class, 'getServices']);
    Route::post('service', [ServiceController::class, 'postService']);
    Route::post('service/{serviceId}', [ServiceController::class, 'putService']);
    Route::delete('service/{serviceId}', [ServiceController::class, 'deleteService']);
});

Route::get('generate-token', [JWTAuthController::class, 'generateToken']);







