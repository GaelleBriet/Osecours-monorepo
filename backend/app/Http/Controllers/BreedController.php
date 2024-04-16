<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use App\Models\Specie;
use Exception;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    //
    public function getAll(Request $request)
    {
        $query = Breed::with(['specie']);
        $breeds = Breed::all();      

        if ($request->has('species')) {    
            $species = ucfirst($request->species);
            $specieExist = Specie::where('name', $species)->first();      
            if(!$specieExist){
                throw new Exception('Specie #'. $request->species . " not found",404);
            }
            $query->whereHas('specie', function ($query) use ($species) {
                $query->where('name', $species); 
            });

            $breeds = $query->get();
        }              

        return $breeds;
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
