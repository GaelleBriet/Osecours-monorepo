<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\CoatController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\HealthcareController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\SpecieController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VaccineController;
use Illuminate\Support\Facades\Route;

// header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Origin: https://osecours-front-eu-851bfe93cb8c.herokuapp.com');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers: Accept, Content-Type, X-Auth-Token, Origin, Authorization');

###GENERAL ACCESS ROUTE###
Route::middleware(['preflight', 'cors'])->group(function () {
    Route::post('/token/create', [AuthController::class, 'getToken']);
    Route::post('/login', [AuthController::class, 'login']);
});

###ADMIN + PRESIDENT ROUTES###
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
          Route::get('/users/role', 'getAllUsersByRoleAndAssociation');
          Route::get('/users/{id}/role', 'getUserRole');
          Route::get('/users/{id}', 'show');
          Route::delete('/users/{id}', 'delete');
          Route::post('/users', 'create');
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

     Route::controller(ShelterController::class)->group(function () {
          Route::get("/shelters/all", "getAll");
          Route::post('/shelters', 'create');
          Route::get('/shelters/{id}', 'show');
          Route::put('/shelters/{id}', 'update');
          Route::delete('/shelters/{id}', 'delete');
     });

     Route::controller(AssociationController::class)->group(function () {
          Route::get("/associations/all", "getAll");
          Route::post('/associations', 'create');
          Route::get('/associations/{id}', 'show');
          Route::put('/associations/{id}', 'update');
          Route::delete('/associations/{id}', 'delete');
          Route::get('/associations/{id}/members', 'getMembers');
     });

     Route::controller(HealthcareController::class)->group(function () {
          Route::get("/healthcares/all", "getAll");
          Route::post('/healthcares', 'create');
          Route::get('/healthcares/{healthcare}', 'show');
          Route::put('/healthcares/{healthcare}', 'update');
          Route::delete('/healthcares/{healthcare}', 'delete');
     });

     Route::controller(VaccineController::class)->group(function () {
          Route::get("/vaccines/all", "getAll");
          Route::post('/vaccines', 'create');
          Route::get('/vaccines/{vaccine}', 'show');
          Route::put('/vaccines/{vaccine}', 'update');
          Route::delete('/vaccines/{vaccine}', 'delete');
          Route::post('/vaccines/{vaccine}/animal', 'vaccineAnimal');
     });

     Route::controller(DocumentController::class)->group(function () {
          Route::get("/documents/find/animals/{animal}","findAllAnimalDocuments");
          Route::get("/documents/find/healthcares/{healthcare}","findAllHealthcareDocuments");
          Route::get("/documents/find/shelters/{shelter}","findAllShelterDocuments");
          Route::post("documents/store/healthcares/{healthcare}","addDocumentForHealthCare");
          Route::post("documents/store/animals/{animal}","addDocumentForAnimal");
          Route::post("documents/store/shelters/{shelter}","addDocumentForShelter");
          Route::get("/documents/{id}","show");
          Route::delete("/documents/{id}","delete");
          Route::put("/documents/{id}","update");
     });
//      Route::post('documents/store/animals/{animal}', [DocumentController::class, 'addDocumentForAnimal']);

     Route::get('/test', function () {
        return response()->json(['message' => 'Test route works']);
    });

});

###VISITOR ROUTES###

###USER ROUTES###
Route::middleware(["auth:sanctum", "abilities:user_access_scope"])->group(function () {

     Route::controller(AnimalController::class)->group(function () {
          Route::get('/animals/all', 'getAll');
          Route::get('/animals/{id}', 'show');
          Route::post('/animals', 'store');
          Route::put('/animals/{id}', 'update');
          Route::delete('/animals/{id}', 'destroy');
     });

      Route::controller(UserController::class)->group(function () {
           Route::get('/users', 'getAll');
           Route::get('/users/role', 'getAllUsersByRoleAndAssociation');
           Route::get('/users/{id}/role', 'getUserRole');
           Route::get('/users/{id}', 'show');
           Route::delete('/users/{id}', 'delete');
           Route::post('/users', 'create');
      });

      Route::controller(RoleController::class)->group(function () {
           Route::post("/roles/add", "addRoleOnUser");
      });

       Route::controller(ShelterController::class)->group(function () {
            Route::get("/shelters/all", "getAll");
            Route::post('/shelters', 'create');
            Route::get('/shelters/{id}', 'show');
            Route::put('/shelters/{id}', 'update');
       });

       Route::controller(AssociationController::class)->group(function () {
            Route::get("/associations/all", "getAll");
            Route::post('/associations', 'create');
            Route::get('/associations/{id}', 'show');
            Route::put('/associations/{id}', 'update');
            Route::get('/associations/{id}/members', 'getMembers');
       });

        Route::controller(HealthcareController::class)->group(function () {
             Route::get("/healthcares/all", "getAll");
             Route::post('/healthcares', 'create');
             Route::get('/healthcares/{healthcare}', 'show');
             Route::put('/healthcares/{healthcare}', 'update');
             Route::delete('/healthcares/{healthcare}', 'delete');
        });

        Route::controller(VaccineController::class)->group(function () {
             Route::post('/vaccines/{vaccine}/animal', 'vacinneAnimal');
        });

        Route::controller(DocumentController::class)->group(function () {
             Route::get("/documents/find/animals/{animal}","findAllAnimalDocuments");
             Route::get("/documents/find/healthcares/{healthcare}","findAllHealthcareDocuments");
             Route::get("/documents/find/shelters/{shelter}","findAllShelterDocuments");
             Route::post("documents/store/healthcares/{healthcare}","addDocumentForHealthCare");
             Route::post("documents/store/animals/{animal}","addDocumentForAnimal");
             Route::post("documents/store/shelters/{shelter}","addDocumentForShelter");
             Route::get("/documents/{id}","show");
             Route::delete("/documents/{id}","delete");
             Route::put("/documents/{id}","update");
        });

        Route::controller(GenderController::class)->group(function () {
              Route::get("/genders/all", "getAll");
         });

         Route::controller(SpecieController::class)->group(function () {
              Route::get('/species/all', 'getAll');
         });

         Route::controller(ColorController::class)->group(function () {
              Route::get("/colors/all", "getAll");
         });

         Route::controller(CoatController::class)->group(function () {
              Route::get("/coats/all", "getAll");
         });

         Route::controller(BreedController::class)->group(function () {
              Route::get("/breeds/all", "getAll");
         });

});

// Route::options('/{any}', function() {
//     return response()->json('', 200);
// })->where('any', '.*');
