<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\CoatController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpecieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


###GENERAL ACCESS ROUTE###
Route::post('/token/create', [AuthController::class, 'getToken']);
Route::post('/login', [AuthController::class, 'login']);

###ADMIN ROUTES###
Route::middleware(["auth:sanctum", "abilities:global_access_scope"])->group(function () {

     Route::controller(AnimalController::class)->group(function () {
          Route::get('/animals/all', 'getAll');
          Route::get('/animals/{id}', 'show');
          Route::post('/animals', 'store');
          Route::put('/animals/{id}', 'update');
          Route::delete('/animals/{id}', 'destroy');
          
     });

     Route::controller(UserController::class)->group(function () {
          Route::get('/users', 'getAll');
     });

     Route::controller(RoleController::class)->group(function () {
          Route::post("/roles/add", "addRoleOnUser");
     });

     Route::controller(GenderController::class)->group(function () {
          Route::get("/genders/all", "getAll");
     });

     Route::controller(SpecieController::class)->group(function () {
          Route::get('/species/all', 'getAll');
          Route::post('/species', 'create');
          Route::get('/species/{id}', 'show');  
          Route::put('/species/{id}', 'update');
          Route::delete('/species/{id}', 'delete');
     });

     Route::controller(ColorController::class)->group(function () {
          Route::get("/colors/all", "getAll");
          Route::post('/colors', 'create');
          Route::get('/colors/{id}', 'show');  
          Route::put('/colors/{id}', 'update');
          Route::delete('/colors/{id}', 'delete');
     });

     Route::controller(CoatController::class)->group(function () {
          Route::get("/coats/all", "getAll");
          Route::post('/coats', 'create');
          Route::get('/coats/{id}', 'show');  
          Route::put('/coats/{id}', 'update');
          Route::delete('/coats/{id}', 'delete');
     });

     Route::controller(BreedController::class)->group(function () {
          Route::get("/breeds/all", "getAll");
          Route::post('/breeds', 'create');
          Route::get('/breeds/{id}', 'show');  
          Route::put('/breeds/{id}', 'update');
          Route::delete('/breeds/{id}', 'delete');
     });

});

###VISITOR ROUTES###

###USER ROUTES###
