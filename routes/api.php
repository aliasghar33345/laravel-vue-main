<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MessageController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'books', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [BookController::class, 'index']);
    Route::post('add', [BookController::class, 'add']);
    Route::get('edit/{id}', [BookController::class, 'edit']);
    Route::post('update/{id}', [BookController::class, 'update']);
    Route::delete('delete/{id}', [BookController::class, 'delete']);
});

Route::group(['prefix' => 'product', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [ProductController::class, 'index2']);
    Route::post('add', [ProductController::class, 'add']);
    Route::get('edit/{id}', [ProductController::class, 'edit']);
    Route::post('update/{id}', [ProductController::class, 'update']);
    Route::delete('delete/{id}', [ProductController::class, 'delete']);
});

Route::group(['prefix' => 'message', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [MessageController::class, 'index']);
    Route::post('add', [MessageController::class, 'add']);
    Route::get('edit/{id}', [MessageController::class, 'edit']);
    Route::post('update/{id}', [MessageController::class, 'update']);
    Route::delete('delete/{id}', [MessageController::class, 'delete']);
});
