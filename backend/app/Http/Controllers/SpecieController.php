<?php

namespace App\Http\Controllers;

use App\Models\Specie;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

class SpecieController extends Controller
{
    //
    public function getAll()
    {
        return Specie::all();
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return Specie::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, Specie $specie)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return $specie->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function delete(Request $request, Specie $specie)
    {
        return $specie->delete();
    }
}
