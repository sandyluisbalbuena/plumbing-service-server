<?php

use App\Http\Controllers\InquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\JWTAuthController;



Route::middleware('jwt.auth')->group(function () {
    // inquiryRefs Routes
    Route::get('inquiry', [InquiryController::class, 'getInquiries']);
    Route::post('inquiry', [InquiryController::class, 'postInquiry']);
    Route::put('inquiry', [InquiryController::class, 'putInquiry']);
    Route::delete('inquiry', [InquiryController::class, 'deleteInquiry']);
});

Route::post('generate-token', [JWTAuthController::class, 'generateToken']);







