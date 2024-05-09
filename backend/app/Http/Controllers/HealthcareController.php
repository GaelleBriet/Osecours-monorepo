<?php

namespace App\Http\Controllers;

use App\Models\Healthcare;
use Illuminate\Http\Request;

class HealthcareController extends Controller
{
    //
    public function getAll()
    {
        return Healthcare::all();
    }

    public function show(Healthcare $Healthcare)
    {

        return $Healthcare;
    }

    public function create(Request $request)
    {
        $request->validate([            
                "date" => "required|date",
                "report" => "required",
                "weight" => "nullable",
                "size" => "nullable",
                "animal_id" => "required|integer",
                "document_id" => "nullable|integer"            
        ]);
        return Healthcare::create($request->all());
    }

    public function update(Request $request, Healthcare $Healthcare)
    {    
        return $Healthcare->update($request->except(['animal_id']));
    }

    public function delete(Healthcare $Healthcare)
    {
        return $Healthcare->delete();
    }
}
