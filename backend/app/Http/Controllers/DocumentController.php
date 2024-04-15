<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    //  'filename',
    //  'description',
    //  'size',
    //  'url',
    //  'date',
    public function getAll()
    {
        return Document::all();
    }

    public function show(Document $document)
    {
        return $document;
    }

    public function create(Request $request)
    {
        $request->validate([
            'filename' => 'required|max:255',
            'description' => '',
            'size' => '',
            'url' => '',
            'date' => '',
        ]);
        return Document::create([
            'name' => $request->name,
            'description' => $request->description,
            'size' => $request->size,
            'url' => $request->url,
            'date' => $request->date,
        ]);
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
            'size' => '',
            'url' => '',
            'date' => '',
        ]);
        return $document->update([
            'name' => $request->name,
            'description' => $request->description,
            'size' => $request->size,
            'url' => $request->url,
            'date' => $request->date,
        ]);
    }

    public function delete(Request $request, Document $document)
    {
        return $document->delete();
    }
}
