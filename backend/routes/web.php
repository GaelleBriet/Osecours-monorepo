<?php

use Illuminate\Support\Facades\Route;

Route::get('/api/docs', function () {
    return view('swagger.index');
});

//Route::get('/', function () {
//    return 'Hello World!';
//});
