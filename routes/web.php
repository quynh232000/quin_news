<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\IsLoginMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// ==================== TESTING TESTING =================
// ==================== TESTING TESTING =================
// ==================== TESTING TESTING =================
Route::get('/test', [HomeController::class, 'test_final'])->name('test_final');


// ==================== TESTING TESTING =================

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, '_login'])->name('_login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, '_register'])->name('_register');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/forgot-password', [AuthController::class, 'forgotpassword'])->name('forgotpassword');
    Route::get('/forgot-password/{token}', [AuthController::class, 'forgotpassword_token'])->name('forgotpassword_token');
    Route::post('/forgot-password/{token}', [AuthController::class, '_forgotpassword_token'])->name('_forgotpassword_token');
    Route::post('/forgot-password', [AuthController::class, '_forgotpassword'])->name('_forgotpassword');
    Route::get('{provider}/redirect', [AuthController::class, 'redirect']);
    Route::get('{provider}/callback', [AuthController::class, 'callback']);

});

Route::get('/following', [HomeController::class, 'following'])->name('following');

Route::get('user/{uuid}', [HomeController::class, 'author'])->name('author');
Route::get('news/{slug_news}', [HomeController::class, 'detail'])->name('detail');
Route::get('search', [HomeController::class, 'collection'])->name('search');
Route::get('collection/{slug_cate}', [HomeController::class, 'collection'])->name('collection');
Route::get('saved', [HomeController::class, 'saved'])->name('saved');

// need login =================================================================
Route::middleware(['isLogin'])->prefix('author')->group(function () {
    Route::get('my-news', [HomeController::class, 'mynews'])->name('mynews');
    Route::get('add-news', [HomeController::class, 'addnews'])->name('addnews');
    Route::get('update-news/{id}', [HomeController::class, 'addnews'])->name('updatenews');
    Route::post('add-news', [HomeController::class, '_addnews'])->name('_addnews');
    Route::post('update-news/{id}', [HomeController::class, '_addnews'])->name('_updatenews');
    Route::get('delete-news/{id}', [HomeController::class, 'deletenews'])->name('deletenews');

    Route::get('follow/{user_id}', [HomeController::class, 'follow_user'])->name('follow_user');
    Route::get('save_news/{id}', [HomeController::class, 'save_news'])->name('save_news');
    Route::get('like/{id}', [HomeController::class, 'like'])->name('like');
    Route::post('comment/{id}', [HomeController::class, 'comment'])->name('comment');
});




// is admin =================================
Route::middleware(['isAdmin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('category/create', [AdminController::class, 'createcategory'])->name('admin.createcategory');
    Route::post('category/edit/{id}', [AdminController::class, '_createcategory'])->name('admin._editcategory');
    Route::post('category/create', [AdminController::class, '_createcategory'])->name('admin._createcategory');
    Route::get('category/create/{id}', [AdminController::class, 'createcategory'])->name('admin.editcategory');
    Route::get('category/delete/{id}', [AdminController::class, 'deletecategory'])->name('admin.deletecategory');
    Route::get('news/status/{id}/{type}', [AdminController::class, 'action_news'])->name('admin.status_news');

    Route::get('/news', [AdminController::class, 'news'])->name('admin.news');
    Route::get('/tags', [AdminController::class, 'tags'])->name('admin.tags');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
});

Route::get('/error', function () {
    return view('error');
})->name('error');








