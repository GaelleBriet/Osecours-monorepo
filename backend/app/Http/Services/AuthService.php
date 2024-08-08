<?php

namespace App\Http\Services;

use App\Enum\AccessScopeEnum;
use App\Enum\RoleEnum;
use App\Enum\UserStatus;
use App\Exceptions\UnauthorizedException;
use App\Models\Role;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @return array
     *
     * @throws UnauthorizedException
     */
    public static function getTokenForSpecificAssociation($credentials, $currentAssociationId)
    {

        $db = app('db');
        // je récupère l'utilisateur en tant qu'instance du modèle user,
        // pour pouvoir appeler createToken définie dans le trait HasApiTokens
        //        $user = $db->table('users')
        //            ->where('email', $credentials['email'])
        //            ->first();
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $associations = $db->table('associations')
                ->join('association_role_user', 'associations.id', '=', 'association_role_user.association_id')
                ->where('association_role_user.user_id', $user->id)
                ->get();
            //            SELECT associations.*
            //                FROM associations
            //                INNER JOIN association_role_user ON associations.id = association_role_user.association_id
            //                WHERE association_role_user.user_id = :user_id;

            $currentAssociation = $associations->where('association_id', $currentAssociationId);
            if (! $currentAssociation->count() > 0) {
                throw new Exception('Association not found');
            }

            $adminRoleId = $db->table('roles')->where('name', RoleEnum::ADMIN->value)->first()->id;
            $presidentRoleId = $db->table('roles')->where('name', RoleEnum::PRESIDENT->value)->first()->id;
            $currentRoleIdList = $currentAssociation->map(function ($association) {
                return $association->role_id;
            });

            $allScopes = self::getAllScopes($currentRoleIdList);

            if ($currentRoleIdList->contains($adminRoleId) || $currentRoleIdList->contains($presidentRoleId)) {
                $abilities[] = '*';
                $status = AccessScopeEnum::GLOBAL_ACCESS_SCOPE->value;
            } else {
                $status = $allScopes->join(',');
                $abilities = $allScopes->toArray();
            }

            $token = $user->createToken(env('APP_NAME'), $abilities)->plainTextToken;

            return [
                'token' => $token,
                'scopes' => $status,
            ];

        } else {
            throw new UnauthorizedException('Unauthorized');
        }

        //        if (Auth::attempt($credentials)) {
        //            $user = Auth::user();
        //            $abilities = [];
        //            $associations = collect($user->associations);
        //            $currentAssociations = $associations->where('id', $currentAssociationId);
        //            if (! $currentAssociations->count() > 0) {
        //                throw new Exception('Association not found');
        //            }
        //            $adminRoleId = Role::where('name', RoleEnum::ADMIN->value)->first()->id;
        //            $presidentRoleId = Role::where('name', RoleEnum::PRESIDENT->value)->first()->id;
        //            $currentRoleIdList = $currentAssociations->map(function ($association) {
        //                return $association->pivot['role_id'];
        //            });
        //
        //            $allScopes = self::getAllScopes($currentRoleIdList);
        //
        //            if ($currentRoleIdList->contains($adminRoleId) || $currentRoleIdList->contains($presidentRoleId)) {
        //                $abilities[] = '*';
        //                $status = AccessScopeEnum::GLOBAL_ACCESS_SCOPE->value;
        //            } else {
        //                $status = $allScopes->join(',');
        //                $abilities = $allScopes->toArray();
        //            }
        //
        //            $token = $user->createToken(env('APP_NAME'), $abilities)->plainTextToken;
        //
        //            return [
        //                'token' => $token,
        //                'scopes' => $status,
        //            ];
        //        } else {
        //            throw new UnauthorizedException('Unauthorized');
        //        }
    }

    /**
     * @return Collection
     */
    private static function getAllScopes(Collection $roleList)
    {
        return $roleList->map(function ($id) {
            $scope = '';
            switch (Role::find($id)->name) {
                case 'user':
                case 'accountant':
                case 'adopt':
                case 'foster':
                    $scope = AccessScopeEnum::USER_ACCESS_SCOPE->value;
                    break;
                case 'admin':
                case 'president':
                    $scope = AccessScopeEnum::GLOBAL_ACCESS_SCOPE->value;
                    break;
                default:
                    $scope = AccessScopeEnum::OTHER_ACCESS_SCOPE->value;
                    break;
            }

            return $scope;
        });
    }

    public static function getTokenWithoutAssociation($credentials)
    {

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $status = AccessScopeEnum::OTHER_ACCESS_SCOPE->value;
            $abilities = [$status];

            $token = $user->createToken(env('APP_NAME'), $abilities)->plainTextToken;

            return [
                'token' => $token,
                'scopes' => $status,
            ];
        } else {
            throw new UnauthorizedException('Unauthorized');
        }
    }

    /**
     * @throws UnauthorizedException
     */
    public static function connectUser($credentials): array
    {
        $db = app('db');

        $user = $db->table('users')
            ->where('email', $credentials['email'])
            ->first();
        // SELECT * FROM users WHERE email = :email;

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $associations = $db->table('associations')
                ->join('association_role_user', 'associations.id', '=', 'association_role_user.association_id')
                ->where('association_role_user.user_id', $user->id)
                ->get();

            // SELECT associations.*
            // FROM associations
            // INNER JOIN association_role_user ON associations.id = association_role_user.association_id
            // WHERE association_role_user.user_id = :user_id;

            // var_dump($associations);
            $mappedAssociations = $associations->map(function ($association) {
                return [
                    'id' => $association->association_id,
                    'name' => $association->name,
                ];
            });

            return [
                'status' => UserStatus::CONNECTED->value,
                'associations' => $mappedAssociations,
            ];

        }
        throw new UnauthorizedException('Invalid credentials');
    }

    //        if (Auth::attempt($credentials)) {
    //            $user = Auth::user();
    //            return [
    //                'status' => UserStatus::CONNECTED->value,
    //                'associations' => $user->associations->map(function ($association) {
    //                    return [
    //                        'id' => $association->id,
    //                        'name' => $association->name,
    //                    ];
    //                })->unique('id'),
    //            ];
    //        }
    //        throw new UnauthorizedException('Invalid credentials');
    //    }
}
