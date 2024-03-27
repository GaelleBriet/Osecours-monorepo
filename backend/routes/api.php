<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);


Route::middleware([])->group(function () {
   Route::controller(AnimalController::class)->group(function () {
       Route::get('/animals/{id}', 'show');
       Route::post('/animals', 'store');
   });
});
