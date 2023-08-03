<?php

use App\Http\Controllers\InquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\JWTAuthController;



Route::middleware('jwt.auth')->group(function () {
    // inquiryRefs Routes
    Route::get('inquiry', [InquiryController::class, 'getInquiries']);
    Route::post('inquiry', [InquiryController::class, 'postInquiry']);
    Route::post('inquiry/{inquiryId}', [InquiryController::class, 'putInquiry']);
    Route::delete('inquiry/{inquiryId}', [InquiryController::class, 'deleteInquiry']);
});

Route::post('generate-token', [JWTAuthController::class, 'generateToken']);







