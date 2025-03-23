<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users',[UserController::class,'getUsers']);
Route::get('/fetch-users',[UserController::class,'fetchUsers']);
Route::post('/create-user',[UserController::class,'creatUser']);
Route::get('/edit-user/{id}',[UserController::class,'editUser']);
Route::put('/update-user/{id}',[UserController::class,'updateUser']);
Route::delete('/delete-user/{id}',[UserController::class,'deleteUser']);
Route::post('/search',[UserController::class,'searchResults']);