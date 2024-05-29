<?php

namespace App\Contract;

use App\Models\Association;
use App\Models\Document;
use App\Models\User;
use App\Models\Role;

interface DocumentRepositoryInterface
{

   public function createDocument(array $array);
   public function findDocument(String $id);
   public function softDeleteDocument($id);
   public function updateDocument($id, Document $newDocu);
   public function getAllDocuments(HasDocumentsInterface $model);

}
