<?php

use App\Http\Controllers\API\AboutController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\GeneralSettingsController;
use App\Http\Controllers\API\ReferenceController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\TeamController;
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

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
     
Route::middleware('auth:sanctum')->group( function () {
   
    Route::resource('blogs', BlogController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('about', AboutController::class);
    Route::resource('team', TeamController::class);
    Route::resource('reference', ReferenceController::class);
    Route::resource('settings', GeneralSettingsController::class);

});