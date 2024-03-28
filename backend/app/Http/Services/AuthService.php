<?

namespace App\Http\Services;

use App\Enum\AccessScopeEnum;
use App\Enum\RoleEnum;
use App\Enum\UserStatus;
use App\Models\Role;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AuthService{

    public static function getTokenForSpecificAssociation($credentials,$currentAssociationId){

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $abilities = [];
            $associations = collect($user->associations);
            $currentAssociations = $associations->where("id",$currentAssociationId);
            if(!$currentAssociations->count() > 0){
                throw new Exception("Association not found");
            }
            $adminRoleId = Role::where("name", RoleEnum::ADMIN->value)->first()->id;
            $currentRoleIdList = $currentAssociations->map(function($association){
                return $association->pivot["role_id"];                
            });

            $allScopes = self::getAllScopes($currentRoleIdList);

            if($currentRoleIdList->contains($adminRoleId)){
                $abilities[] = '*';
                $status = AccessScopeEnum::GLOBAL_ACCESS_SCOPE->value;
            }else{               
                $status = $allScopes->join(",");
                $abilities = $allScopes->toArray();
            }

            $token = $user->createToken(env("APP_NAME"), $abilities)->plainTextToken;

            return response()->json([
                'token' => $token,
                'scopes' => $status
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);

    }

    private static function getAllScopes(Collection $roleList){
        return $roleList->map(function($id){
            $scope = "";
            switch(Role::find($id)->name){
                case "user":
                    $scope = AccessScopeEnum::USER_ACCESS_SCOPE->value;
                    break;
                case "admin":
                    $scope = AccessScopeEnum::GLOBAL_ACCESS_SCOPE->value;
                    break;
                default: 
                    $scope = AccessScopeEnum::OTHER_ACCESS_SCOPE->value;
                    break;
            }
            return $scope;
        });
    }

    public static function getTokenWithoutAssociation($credentials){

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $status = AccessScopeEnum::OTHER_ACCESS_SCOPE->value;
            $abilities = [$status];            

            $token = $user->createToken(env("APP_NAME"), $abilities)->plainTextToken;

            return response()->json([
                'token' => $token,
                'scopes' => $status
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
        
    }

    public static function connectUser($credentials){
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            return response()->json([
                    "status" => UserStatus::CONNECTED->value,
                    "associations" => $user->associations->map(function($association){
                        return [
                            "id" => $association->id,
                            "name" => $association->name
                        ];
                    })->unique("id"),                   
            ]);

        }
        return response()->json(['error','Unauthorized'], 401);
    }
}