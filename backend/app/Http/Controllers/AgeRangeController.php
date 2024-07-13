<?php

namespace App\Http\Controllers;

use App\Models\AgeRange;
use Illuminate\Http\Request;

class AgeRangeController extends Controller
{
    //
    public function getAll()
    {
        return AgeRange::all();
    }

    public function show(AgeRange $AgeRange)
    {
        return $AgeRange;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);

        return AgeRange::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, AgeRange $AgeRange)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);

        return $AgeRange->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function delete(AgeRange $AgeRange)
    {
        return $AgeRange->delete();
    }
}
