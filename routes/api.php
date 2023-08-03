<?php

use App\Http\Controllers\InquiryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::group(['middleware' => 'bearer_auth'], function () {
// });


Route::middleware('jwt.auth')->group(function () {
    // Your protected routes here
    Route::get('inquiry', [InquiryController::class, 'index']);
});

Route::post('generate-token', [JWTAuthController::class, 'generateToken']);

