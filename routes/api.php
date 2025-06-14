<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\BookController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\UsersController;
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
//Books route
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books/create', [BookController::class, 'create']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);

//Authors route
Route::get('/authors', [AuthorsController::class, 'index']);
Route::get('/authors/{id}', [AuthorsController::class, 'show']);
Route::post('/authors/create', [AuthorsController::class, 'create']);
Route::put('/authors/{id}', [AuthorsController::class, 'update']);
Route::delete('/authors/{id}', [AuthorsController::class, 'destroy']);

//users rotue
Route::get('/users', [UsersController::class, 'index']);
Route::get('/users/{id}', [UsersController::class, 'show']);
Route::post('/users/create', [UsersController::class, 'create']);
Route::put('/users/{id}', [UsersController::class, 'update']);
Route::delete('/users/{id}', [UsersController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
