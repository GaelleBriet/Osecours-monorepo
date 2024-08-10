<?php

namespace App\Http\Services;

use App\Contract\DocumentRepositoryInterface;
use App\Contract\HasDocumentsInterface;
use App\Http\Resources\DocumentResource;
use App\Models\Animal;
use App\Models\Healthcare;
use App\Models\Shelter;
use App\Repositories\DocumentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentService
{
    protected const BASE_STORAGE = '/app';

    protected DocumentRepositoryInterface $documentRepo;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepo = $documentRepository;
    }

    public function findDocument(string $id)
    {
        return $this->documentRepo->findDocument($id);

    }

    public function createDocumentForAnimal(Request $request, Animal $animal)
    {

        $documentData = $this->getDocumentData($request);
        $newDoc = $this->documentRepo->createDocument($documentData);
        $newDoc->animals()->attach($animal->id);

        return new DocumentResource($newDoc);
    }

    public function createDocumentForHealthCare(Request $request, Healthcare $healtcare)
    {

        $documentData = $this->getDocumentData($request);
        $newDoc = $this->documentRepo->createDocument($documentData);
        $healtcare->document()->associate($newDoc);
        $healtcare->save();

        return new DocumentResource($newDoc);
    }

    public function createDocumentForShelter(Request $request, Shelter $shelter)
    {

        $documentData = $this->getDocumentData($request);
        $newDoc = $this->documentRepo->createDocument($documentData);
        $shelter->documents()->attach($newDoc);
        $shelter->save();

        return new DocumentResource($newDoc);
    }

    public function softDeleteDocument($id)
    {
        return $this->documentRepo->softDeleteDocument($id);
    }

    public function updateDocument($id, $updateData)
    {
        return $this->documentRepo->updateDocument($id, $updateData);

    }

    public function getAllAnimalDocuments(HasDocumentsInterface $animal)
    {
        return $this->documentRepo->getAllDocuments($animal);
    }

    public function getAllHealthcareDocuments(HasDocumentsInterface $healtcare)
    {
        return $this->documentRepo->getAllDocuments($healtcare);
    }

    public function getAllShelterDocuments(HasDocumentsInterface $shelter)
    {
        return $this->documentRepo->getAllDocuments($shelter);
    }

    public function getDocumentData(Request $request){
        $uniqFilename = $request->filename .  uniqid("__");
        $nameSlugged = Str::slug($uniqFilename, '-');

        $file = $request->file('file');
        $path = $file->storeAs('public/files', $nameSlugged . "." . $file->getClientOriginalExtension());
        $imagesMimeType = ['jpeg,jpg,bmp,png,image.pdf'];
        $url = env('APP_DEBUG') ? env('APP_URL') . ":" . env('APP_PORT') . '/storage/files/' . $nameSlugged . "." . $file->getClientOriginalExtension() : env('APP_URL');

        return [
            'date' => Date::now(),
            'mimeType' => $file->getMimeType(),
            'size' => $file->getSize(),
            'url' => $url,
            'filename' => $uniqFilename,
            'description' => $request->description,
            'docType' => $request->doctype,
        ];
    }
}
