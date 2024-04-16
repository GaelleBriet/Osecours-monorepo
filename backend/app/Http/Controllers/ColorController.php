<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Specie;
use Exception;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    //
    public function getAll(Request $request)
    {
        $query = Color::with(['specie']);
        $colors = Color::all();      

        if ($request->has('type')) {    
            $type = ucfirst($request->type);
            $specieExist = Specie::where('name', $type)->first();      
            if(!$specieExist){
                throw new Exception('Specie #'. $request->type . " not found",404);
            }
            $query->whereHas('specie', function ($query) use ($type) {
                $query->where('name', $type); 
            });

            $colors = $query->get();
        }              

        return $colors;
    }

    public function show(Color $color)
    {
        return $color;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return Color::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return $color->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function delete(Request $request, Color $color)
    {
        return $color->delete();
    }
}
