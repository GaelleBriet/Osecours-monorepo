<?php

namespace App\Contract;

use App\Models\Document;

interface DocumentRepositoryInterface
{
    /**
     * @param array $array
     * @return mixed
     */
    public function createDocument(array $array): mixed;

    /**
     * @param string $id
     * @return mixed
     */
    public function findDocument(string $id): mixed;

    /**
     * @param $id
     * @return mixed
     */
    public function softDeleteDocument($id): mixed;

    /**
     * @param $id
     * @param Document $newDocu
     * @return mixed
     */
    public function updateDocument($id, Document $newDocu): mixed;

    /**
     * @param HasDocumentsInterface $model
     * @return mixed
     */
    public function getAllDocuments(HasDocumentsInterface $model): mixed;
}
