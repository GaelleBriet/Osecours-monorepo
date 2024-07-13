<?php

namespace App\Contract;

use App\Models\Document;

interface DocumentRepositoryInterface
{
    public function createDocument(array $array);

    public function findDocument(string $id);

    public function softDeleteDocument($id);

    public function updateDocument($id, Document $newDocu);

    public function getAllDocuments(HasDocumentsInterface $model);
}
