<?php

namespace App\Http\Controllers;

use App\Models\Size_range;
use Illuminate\Http\Request;

class Size_rangeController extends Controller
{
    //
    public function getAll()
    {
        return Size_range::all();
    }

    public function show(Size_range $size_range)
    {
        return $size_range;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return Size_range::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, Size_range $size_range)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return $size_range->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function delete(Size_range $size_range)
    {
        return $size_range->delete();
    }
}
