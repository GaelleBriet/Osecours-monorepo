<?php

namespace App\Repositories;

use App\Contract\DocumentRepositoryInterface;
use App\Contract\HasDocumentsInterface;
use App\Models\Doctype;
use App\Models\Document;
use App\Models\Mimetype as Mimetype;

class DocumentRepository extends BaseRepository implements DocumentRepositoryInterface
{
    public function __construct(Document $doc)
    {
        parent::__construct($doc);
    }

    public function findDocument($id): mixed
    {
        return Document::findOrFail($id);
    }

    public function getAllDocuments(HasDocumentsInterface $model): mixed
    {
        return $model->getDocuments();
    }

    public function createDocument($array): mixed
    {

        Mimetype::firstOrCreate([
            'name' => $array['mimeType'],
        ]);
        DocType::firstOrCreate([
            'name' => $array['docType'],
            'description' => '',
        ]);

        $newDoc = Document::create([
            'filename' => $array['filename'],
            'description' => $array['description'],
            'size' => $array['size'],
            'url' => $array['url'],
            'date' => $array['date'],
            'mimetype_id' => 1,
            'doctype_id' => $array['docType'],
        ]);

        return $newDoc;

    }

    public function softDeleteDocument($id): mixed
    {
        $document = Document::findOrFail($id);
        $document->delete();

        return $document;
    }

    public function updateDocument($id, $updateDatas): mixed
    {
        $document = Document::find($id);
        if ($document) {
            $document->update($updateDatas);
        }

        return $document;
    }
}
