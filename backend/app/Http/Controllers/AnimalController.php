<?php

namespace App\Http\Controllers;

use App\Http\Services\AnimalService;
use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    protected AnimalService $animalService;

    public function __construct(AnimalService $animalService)
    {
        $this->animalService = $animalService;
    }
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        return $this->animalService->getAll();
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate();
        $this->animalService->createOrUpdate($validated);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateGender(Request $request) {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'gender_id' => 'required|exists:genders,id',
        ]);
        $animal = Animal::findOrFail($request->animal_id);
        $animal->gender_id = $request->gender_id;
        $animal->save();
        return response()->json([
            'message' => 'Le genre de l\'animal a été mis à jour avec succès.',
            'animal' => $animal
        ]);
    }

    public function updateSpecie(Request $request) {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'specie_id' => 'required|exists:species,id',
        ]);
        $animal = Animal::findOrFail($request->animal_id);
        $animal->specie_id = $request->specie_id;
        $animal->save();
        return response()->json([
            'message' => 'L\'espèce de l\'animal a été mise à jour avec succès.',
            'animal' => $animal
        ]);
    }
}
