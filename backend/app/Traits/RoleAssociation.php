<?php

namespace App\Traits;

trait RoleAssociation
{
    public function verifyRoleInSpecificAssociation($roleId, $associationId): bool
    {
        return $this->roles()->where('role_id', $roleId)->where('association_id', $associationId)->exists();
    }

    public function attachRoleIntoSpecificAssociation($roleId, $associationId): void
    {
        // Assurez-vous que le rôle n'est pas déjà attaché à l'utilisateur dans cette association
        if (! $this->verifyUserRole($roleId, $associationId)) {
            $this->roles()->attach($roleId, ['association_id' => $associationId]);
        }
    }

    public function verifyUserRole($roleId, $associationId): bool
    {
        return $this->roles()->where('role_id', $roleId)->where('association_id', $associationId)->exists();
    }
}
