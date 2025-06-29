<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\BookController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\MemberController;
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
// Books route
// Route::get('/books', [BookController::class, 'index']);
// Route::get('/books/{id}', [BookController::class, 'show']);
// Route::post('/books/create', [BookController::class, 'create']);
// Route::put('/books/{id}', [BookController::class, 'update']);
// Route::delete('/books/{id}', [BookController::class, 'destroy']);

Route::prefix('/books')->group(function(){
    Route::get('/',[BookController::class,"index"])->name("/allbooks");
    Route::get("/count",[BookController::class, 'CountBooks']);
    Route::post("/create",[BookController::class, 'store']);
    Route::put("/edit/{id}",[BookController::class, 'edit']);
    Route::delete("/delete/{id}", [BookController::class, 'destroy']);
    Route::get("/show/{id}", [BookController::class, 'show']);
    Route::get('/search', [BookController::class, 'searchByTitle']);
});

// Authors route
Route::get('/authors', [AuthorsController::class, 'index']);
Route::get('/authors/{id}', [AuthorsController::class, 'show']);
Route::get('/authors', [AuthorsController::class, 'search']);
Route::post('/authors/create', [AuthorsController::class, 'create']);
Route::put('/authors/{id}', [AuthorsController::class, 'update']);
Route::delete('/authors/{id}', [AuthorsController::class, 'destroy']);


//users rotue
Route::get('/members', [MemberController::class, 'index']);
Route::get('/members/{id}', [MemberController::class, 'show']);
Route::post('/members', [MemberController::class, 'store']);
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
