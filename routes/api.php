<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\AuthController;

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

// Route Admin
Route::post("/admin/login", [AdminAuthController::class, 'login']);


Route::middleware(['auth:admin', 'admin.only'])->group(function(){
    Route::post("/admin/logout", [AdminAuthController::class, 'logout']);
    Route::post("/admin/change-password", [AdminAuthController::class, 'changePassword']);
    Route::get("/dashboard", [DashboardController::class, 'index']);

    Route::apiResource('authors', AuthorController::class); Route::apiResource('categories', CategoryController::class);
    Route::apiResource('publishers', PublisherController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('users', UserBookController::class)->only(['index', 'show', 'destroy']);

    Route::get("/authors/search/{name}", [AuthorController::class, 'search']);
    Route::get("/categories/search/{name}", [CategoryController::class, 'search']);
    Route::get("/publishers/search/{name}", [PublisherController::class, 'search']);
    Route::get("/books/search/{title}", [BookController::class, 'search']);

});


// Route User
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function() {
    Route::get("books/favorites", [UserBookController::class, 'getFavorites']);
    Route::get("books/wishlists", [UserBookController::class, 'getWishlist']);
    Route::post("books/favorite/add", [UserBookController::class, 'addFavorite']);
    Route::post("books/favorite/remove", [UserBookController::class, 'removeFavorite']);
    Route::post("books/wishlist/add", [UserBookController::class, 'addWishlist']);
    Route::post("books/wishlist/remove", [UserBookController::class, 'removeWishlist']);
    Route::post("/logout", [AuthController::class, 'logout']);
});