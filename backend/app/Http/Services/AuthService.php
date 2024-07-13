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

class AuthService
{
    public static function getTokenForSpecificAssociation($credentials, $currentAssociationId)
    {

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $abilities = [];
            $associations = collect($user->associations);
            $currentAssociations = $associations->where('id', $currentAssociationId);
            if (! $currentAssociations->count() > 0) {
                throw new Exception('Association not found');
            }
            $adminRoleId = Role::where('name', RoleEnum::ADMIN->value)->first()->id;
            $presidentRoleId = Role::where('name', RoleEnum::PRESIDENT->value)->first()->id;
            $currentRoleIdList = $currentAssociations->map(function ($association) {
                return $association->pivot['role_id'];
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
    }

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

    public static function connectUser($credentials)
    {

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            return [
                'status' => UserStatus::CONNECTED->value,
                'associations' => $user->associations->map(function ($association) {
                    return [
                        'id' => $association->id,
                        'name' => $association->name,
                    ];
                })->unique('id'),
            ];
        } else {
            throw new UnauthorizedException('Unauthorized');
        }
    }
}
