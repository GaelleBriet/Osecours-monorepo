<?php

namespace App\Contract;

use App\Models\Association;
use App\Models\Document;
use App\Models\User;
use App\Models\Role;

interface DocumentRepositoryInterface
{

   public function createDocument(array $array);
   public function findDocument(String $path);
   public function deleteDocument(String $path);
   public function updateDocument(String $path, Document $newDocu);

}
