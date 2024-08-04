<?php

namespace App\Http\Controllers;

use App\Models\Gender;

class GenderController extends Controller
{
    //
    public function getAll()
    {
        return Gender::all();
    }
}
