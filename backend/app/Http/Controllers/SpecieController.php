<?php

namespace App\Http\Controllers;

use App\Models\Specie;
use Illuminate\Http\Request;

class SpecieController extends Controller
{
    //
    public function getAll()
    {
        return Specie::all();
    }
}
