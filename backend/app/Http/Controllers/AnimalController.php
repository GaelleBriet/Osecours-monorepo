<?php

namespace App\Http\Controllers;

use App\Http\Services\AnimalService;
use App\Http\Services\ErrorService;
use App\Models\Animal;
use Exception;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    protected AnimalService $animalService;
    protected ErrorService $errorService;

    public function __construct(AnimalService $animalService, ErrorService $eService)
    {
        $this->animalService = $animalService;

        $this->errorService = $eService;
    }
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        try {
            return $this->animalService->getAll();
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate();
            $this->animalService->create($validated);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        try {
            $this->animalService->update($id,$request);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
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
