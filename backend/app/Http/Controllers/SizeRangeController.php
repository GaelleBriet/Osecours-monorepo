<?php

namespace App\Http\Controllers;

use App\Models\SizeRange;
use Illuminate\Http\Request;

class SizeRangeController extends Controller
{
    //
    public function getAll()
    {
        return SizeRange::all();
    }

    public function show(SizeRange $SizeRange)
    {
        return $SizeRange;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return SizeRange::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, SizeRange $SizeRange)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return $SizeRange->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function delete(SizeRange $SizeRange)
    {
        return $SizeRange->delete();
    }
}
