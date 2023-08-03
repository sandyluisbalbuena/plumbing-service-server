<?php

use App\Http\Controllers\InquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\JWTAuthController;
use App\Http\Controllers\ServiceController;

Route::middleware('jwt.auth')->group(function () {
    // inquiryRefs Routes
    Route::get('inquiries', [InquiryController::class, 'getInquiries']);
    Route::post('inquiries', [InquiryController::class, 'postInquiry']);
    Route::post('inquiries/{inquiryId}', [InquiryController::class, 'putInquiry']);
    Route::delete('inquiries/{inquiryId}', [InquiryController::class, 'deleteInquiry']);


    // serviceRefs Routes
    Route::get('services', [ServiceController::class, 'getServices']);
    Route::post('services', [ServiceController::class, 'postService']);
    Route::post('services/{serviceId}', [ServiceController::class, 'putService']);
    Route::delete('services/{serviceId}', [ServiceController::class, 'deleteService']);
});

Route::get('generate-token', [JWTAuthController::class, 'generateToken']);







