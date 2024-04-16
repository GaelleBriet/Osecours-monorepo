<?php

namespace App\Http\Controllers;

use App\Http\Services\DocumentService;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }
    public function getAll()
    {
        return Document::all();
    }

    public function show(Document $document)
    {
        return $document;
    }

    public function addDocumentForAnimal(Request $request)
    {
        
        $validated = $request->validate([
            'filename' => 'required|max:255',
            'description' => '',
            'file' => 'required|file|mimes:jpg,bmp,png|max:2048'

        ]);     
        return $this->documentService->createDocumentForAnimal($request);
    }

    public function addDocumentForHealthCare(Request $request)
    {
        
        $validated = $request->validate([
            'filename' => 'required|max:255',
            'description' => '',
            'file' => 'required|file|mimes:jpg,bmp,png|max:2048'

        ]);     
        return $this->documentService->createDocumentForHealthCare($request);
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
