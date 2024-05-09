<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaccineController extends Controller
{
    //
    public function getAll()
    {
        return Vaccine::all();
    }

    public function show(Vaccine $Vaccine)
    {
        return $Vaccine;
    }

    public function create(Request $request)
    {
        $request->validate([            
                "name" => "required",
                "description" => "nullable",
                      
        ]);
        return Vaccine::create($request->all());
    }

    public function update(Request $request, Vaccine $Vaccine)
    {    
        return $Vaccine->update($request->all());
    }

    public function delete(Vaccine $Vaccine)
    {
        return $Vaccine->delete();
    }

    public function vacinneAnimal(Request $request,Vaccine $vaccine){
        $request->validate([
            "animal_id" => "required|integer|exists:animals,id"
        ]);
        
        $vaccine->animals()->syncWithoutDetaching($request->get("animal_id"));
     
        return Animal::find($request->get("animal_id"))->vaccines;
    }

   
}
