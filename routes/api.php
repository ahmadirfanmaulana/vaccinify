<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1'], function () {

    // Authentication
    Route::post('/auth/login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('/auth/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);

    // Consult
    Route::resource('/consultations', \App\Http\Controllers\API\ConsultationController::class);

    // Vaccination
    Route::resource('/vaccinations', \App\Http\Controllers\API\VaccinationController::class);

    // Spot
    Route::resource('/spots', \App\Http\Controllers\API\SpotsController::class);

});
