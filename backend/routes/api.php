<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

###GENERAL ACCESS ROUTE###
Route::post('/login', [AuthController::class, 'login']);

###ADMIN ROUTES###
Route::middleware(["isAdmin"])->group(function () {

   Route::controller(AnimalController::class)->group(function () {
       Route::get('/animals/{id}', 'show');
       Route::post('/animals', 'store');
   });

});

###VISITOR ROUTES###

###USER ROUTES###



