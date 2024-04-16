<?php
namespace App\Http\Services;

use App\Contract\DocumentRepositoryInterface;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Models\Healthcare;
use App\Repositories\DocumentRepository;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;

class DocumentService{

    protected const BASE_STORAGE = "/app";

    protected DocumentRepositoryInterface $documentRepo;

    public function __construct(DocumentRepository $documentRepository )
    {
        $this->documentRepo = $documentRepository;
    }

    public function findDocument(String $path){
        return $this->documentRepo->findDocument($path);

    }

    public function createDocumentForAnimal(Request $request, $idAnimal){

        $documentData = $this->getDocumentData($request);
        $newDoc =  $this->documentRepo->createDocument($documentData);
        $newDoc->animals()->attach($idAnimal);        

        return new DocumentResource($newDoc);
    }

    public function createDocumentForHealthCare(Request $request){
        
        $documentData = $this->getDocumentData($request);
        $newDoc =  $this->documentRepo->createDocument($documentData);       
        $healtcare = Healthcare::find($request->get('healthcare_id'));
        $healtcare->document()->associate($newDoc);
        $healtcare->save();
        
        return new DocumentResource($newDoc);
    }

    public function deleteDocument(String $path){
        return $this->documentRepo->deleteDocument($path);
    }

    public function updateDocument(String $path,Document $newDoc){
        return $this->documentRepo->updateDocument($path, $newDoc);

    }

    public function getDocumentData(Request $request){

        $file = $request->file('file');
        $path = $file->storeAs('public/files',$request->filename);
        $url = Storage::url($path);

        return [
            'date' => Date::now(),
            'mimeType' => $file->getMimeType(),
            'size' => $file->getSize(),
            'url' => self::BASE_STORAGE . $url,
            'filename' => $request->filename,
            'description' => $request->description
        ];
    }
}