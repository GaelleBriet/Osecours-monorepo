<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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
}
