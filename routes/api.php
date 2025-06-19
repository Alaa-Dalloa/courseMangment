<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OwnerRestaurantController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('/login',  [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware("jwtAuth");
Route::get('/user-profile', [AuthController::class, 'getUser'])->middleware("jwtAuth");

Route::post('/createRestaurant', [OwnerRestaurantController::class, 'create'])->middleware("SuperAdminMiddleware");
Route::get('/allRestaurant', [OwnerRestaurantController::class, 'index']);
Route::post('/delete/{id}', [OwnerRestaurantController::class, 'delete']);

Route::get('/search', [OwnerRestaurantController::class, 'search']);  

Route::post('/update/{id}', [OwnerRestaurantController::class, 'update']);
