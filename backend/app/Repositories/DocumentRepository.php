<?php

namespace App\Repositories;

use App\Contract\DocumentRepositoryInterface;
use App\Models\Doctype;
use App\Models\Document;
use App\Models\Mimetype as Mimetype;

class DocumentRepository extends BaseRepository implements  DocumentRepositoryInterface
{
    public function __construct(Document $doc)
    {
        parent::__construct($doc);
    }

    public function findDocument($path){

    }

    public function createDocument($array){
        //@todo
        Mimetype::firstOrCreate([
            'name' => 'jpeg'
        ]);
        DocType::firstOrCreate([
            'name' => 'image',
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

    public function deleteDocument($path){

    }

    public function updateDocument($path,$newDoc){

    }

 
}
