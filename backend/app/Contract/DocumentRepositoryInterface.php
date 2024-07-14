<?php

namespace App\Contract;

use App\Models\Document;

interface DocumentRepositoryInterface
{
    public function createDocument(array $array): mixed;

    public function findDocument(string $id): mixed;

    public function softDeleteDocument($id): mixed;

    public function updateDocument($id, Document $newDocu): mixed;

    public function getAllDocuments(HasDocumentsInterface $model): mixed;
}
