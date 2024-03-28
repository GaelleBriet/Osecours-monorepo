<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


###GENERAL ACCESS ROUTE###
Route::post('/token/create', [AuthController::class, 'getToken']);
Route::post('/login', [AuthController::class,'login']);

###ADMIN ROUTES###
Route::middleware(["auth:sanctum","abilities:global_access_scope"])->group(function () {

   Route::controller(AnimalController::class)->group(function () {
       Route::get('/animals/{id}', 'show');
       Route::post('/animals', 'store');
   });

   Route::controller(UserController::class)->group(function () {
        Route::get('/users','getAll');
   });

   Route::controller(RoleController::class)->group(function(){
        Route::post("/roles/add", "addRoleOnUser");
   });

});

###VISITOR ROUTES###

###USER ROUTES###



