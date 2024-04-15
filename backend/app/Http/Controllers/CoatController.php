<?php

namespace App\Http\Controllers;

use App\Models\Coat;
use Illuminate\Http\Request;

class CoatController extends Controller
{
    //
    public function getAll()
    {
        return Coat::all();
    }

    public function show(Coat $coat)
    {
        return $coat;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return Coat::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, Coat $coat)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);
        return $coat->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function delete(Request $request, Coat $coat)
    {
        return $coat->delete();
    }
}
