<?php
namespace App\Http\Services;

use App\Contract\DocumentRepositoryInterface;
use App\Contract\HasDocumentsInterface;
use App\Http\Resources\DocumentResource;
use App\Models\Animal;
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

    public function findDocument(String $id){
        return $this->documentRepo->findDocument($id);

    }

    public function createDocumentForAnimal(Request $request, Animal $animal){

        $documentData = $this->getDocumentData($request);
        $newDoc =  $this->documentRepo->createDocument($documentData);
       // $newDoc->animals()->attach($request->get('animal_id'));
        $newDoc->animals()->attach($animal->id);              

        return new DocumentResource($newDoc);
    }

    public function createDocumentForHealthCare(Request $request,Healthcare $healtcare){
        
        $documentData = $this->getDocumentData($request);
        $newDoc =  $this->documentRepo->createDocument($documentData);       
        //$healtcare = Healthcare::find($request->get('healthcare_id'));
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

    public function getAllAnimalDocuments(HasDocumentsInterface $animal){
        return $this->documentRepo->getAllDocuments($animal);
    }

    public function getAllHealthcareDocuments(HasDocumentsInterface $healtcare){
        return $this->documentRepo->getAllDocuments($healtcare);
    }

    public function getDocumentData(Request $request){

        $file = $request->file('file');
        $path = $file->storeAs('public/files',$request->filename . "." . $file->getClientOriginalExtension());
        $imagesMimeType = ['jpeg,jpg,bmp,png,image.pdf'];
        

        return [
            'date' => Date::now(),
            'mimeType' => $file->getMimeType(),
            'size' => $file->getSize(),
            'url' => Storage::url($path),
            'filename' => $request->filename,
            'description' => $request->description,
            'docType' => in_array($file->getMimeType(),$imagesMimeType) ? 'image' : 'doc'
        ];
    }
}