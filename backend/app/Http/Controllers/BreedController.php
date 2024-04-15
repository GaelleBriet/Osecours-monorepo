<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    //
    public function getAll()
    {
        return Breed::all();
    }

    public function show(Breed $breed)
    {
        return $breed;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return Breed::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, Breed $breed)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return $breed->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function delete(Request $request, Breed $breed)
    {
        return $breed->delete();
    }
}
