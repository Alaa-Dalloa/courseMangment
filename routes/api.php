<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
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


Route::post('/createCategory', [CategoryController::class, 'create'])->middleware("restaurantManger");


//meal
Route::post('/createMeal', [MealController::class, 'createMeal'])->middleware("restaurantManger");


Route::get('/getMealByRestaurant/{id}', [MealController::class, 'getMealByRestaurant']);  


Route::get('/getMealByRestaurantandCategory/{owner_resturant_id}/{category_id}', [MealController::class, 'getMealByRestaurantandCategory']); 

Route::get('/searchMeal/{owner_resturant_id}/{category_id}/{maelName}', [MealController::class, 'searchMeal']); 

//offer


Route::post('/addOffer/{id}', [OfferController::class, 'addOffer'])->middleware("restaurantManger");


Route::get('/getOffers/{owner_resturant_id}', [OfferController::class, 'getOffers']); 


Route::post('/addOrder', [OrderController::class, 'addOrder']);



