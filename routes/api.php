<?php

use App\Http\Controllers\InquiryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\JWTAuthController;
use App\Http\Controllers\ServiceController;

Route::middleware('jwt.auth')->group(function () {
    // inquiryRefs Routes
    Route::get('inquiries', [InquiryController::class, 'getInquiries']);
    Route::post('inquiries', [InquiryController::class, 'postInquiry']);
    Route::post('inquiries/{inquiryId}', [InquiryController::class, 'putInquiry']);
    Route::delete('inquiries/{inquiryId}', [InquiryController::class, 'deleteInquiry']);


    // serviceCategoryRefs Routes
    Route::get('servicecategories', [ServiceController::class, 'getServiceCategories']);
    Route::post('servicecategories', [ServiceController::class, 'postServiceCategory']);
    Route::get('servicecategories/{serviceId}', [ServiceController::class, 'getServiceCategory']);
    Route::post('servicecategories/{serviceId}', [ServiceController::class, 'putServiceCategory']);
    Route::delete('servicecategories/{serviceId}', [ServiceController::class, 'deleteServiceCategory']);

    

});

Route::get('generate-token', [JWTAuthController::class, 'generateToken']);







