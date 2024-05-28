<?php

namespace App\Repositories;

use App\Contract\DocumentRepositoryInterface;
use App\Contract\HasDocumentsInterface;
use App\Models\Animal;
use App\Models\Doctype;
use App\Models\Document;
use App\Models\Healthcare;
use App\Models\Mimetype as Mimetype;
use Illuminate\Support\Facades\Storage;

class DocumentRepository extends BaseRepository implements  DocumentRepositoryInterface
{
    public function __construct(Document $doc)
    {
        parent::__construct($doc);
    }

    public function findDocument($id){
        return Document::findOrFail($id);
    }

    public function getAllDocuments(HasDocumentsInterface $model){
        return $model->getDocuments();
    }

    public function createDocument($array){
        
        Mimetype::firstOrCreate([
            'name' =>  $array['mimeType']
        ]);
        DocType::firstOrCreate([
            'name' => $array['docType'],
            'description' => ''
        ]);

        $newDoc = Document::create([
            'filename' => $array['filename'],
            'description' => $array['description'],
            'size' => $array['size'] ,
            'url' => $array['url'],
            'date' => $array['date'],
            'mimetype_id' => 1,
            'doctype_id' => 1
        ]);
        return $newDoc;

    }

    public function softDeleteDocument($id){
        $document = Document::findOrFail($id);
        $document->delete();  
        return $document;
    }

    public function updateDocument($id, $updateDatas){
        $document = Document::find($id);
        if($document){
            $document->update($updateDatas);            
        }
        return $document;
    }

 
}
