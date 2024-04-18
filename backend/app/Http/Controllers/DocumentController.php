<?php

namespace App\Http\Controllers;

use App\Http\Services\DocumentService;
use App\Models\Animal;
use App\Models\Document;
use App\Models\Healthcare;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

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

    public function show(String $id){
        return $this->documentService->findDocument($id);
    }

    public function findAllAnimalDocuments(Animal $animal)
    {
        return $this->documentService->getAllAnimalDocuments($animal);
    }

    public function findAllHealthcareDocuments(Healthcare $healthcare)
    {
        return $this->documentService->getAllHealthcareDocuments($healthcare);
    }

    public function addDocumentForAnimal(Request $request, Animal $animal)
    {

        $validated = $request->validate([
            'filename' => 'required|max:255',
            'description' => '',
            'file' => 'required|file|mimes:jpg,bmp,png|max:2048'

        ]);
        return $this->documentService->createDocumentForAnimal($request, $animal);
    }

    public function addDocumentForHealthCare(Request $request, Healthcare $healthcare)
    {

        $validated = $request->validate([
            'filename' => 'required|max:255',
            'description' => '',
            'file' => 'required|file|mimes:jpg,bmp,png|max:2048'

        ]);
        if (!$healthcare) {
            return "ok";
           $healthcare = Healthcare::create([
                "date" => Date::now(),
                "report" => "tout va bien",
                "animal_id" => 1
            ]);
        }
        return $this->documentService->createDocumentForHealthCare($request, $healthcare);
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
