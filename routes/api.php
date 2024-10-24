<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('child_comments/{id}',[ApiController::class,'get_child_comments']);

Route::get('all_categories',[ApiController::class,'get_all_categories']);
Route::get('all_news',[ApiController::class,'get_all_news']);
Route::get('get_news_by_cate/{slug}',[ApiController::class,'get_news_by_cate']);
Route::get('get_news_detail/{slug}',[ApiController::class,'get_news_detail']);