<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    //
    public function getAll()
    {
        return Color::all();
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
