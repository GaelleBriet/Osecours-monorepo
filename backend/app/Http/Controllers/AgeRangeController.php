<?php

namespace App\Http\Controllers;

use App\Models\Age_range;
use Illuminate\Http\Request;

class AgeRangeController extends Controller
{
    //
    public function getAll()
    {
        return Age_range::all();
    }

    public function show(Age_range $age_range)
    {
        return $age_range;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return Age_range::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, Age_range $age_range)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return $age_range->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function delete(Age_range $age_range)
    {
        return $age_range->delete();
    }
}
