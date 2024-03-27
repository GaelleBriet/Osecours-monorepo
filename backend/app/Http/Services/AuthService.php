<?

namespace App\Http\Services;

use App\Enum\AccessScopeEnum;
use App\Enum\RoleEnum;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthService{

    public static function getTokenForSpecificAssociation($credentials,$currentAssociation){

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $abilities = [];
            $associations = collect($user->associations);
            $role = $associations->firstWhere("name", $currentAssociation);
            if(!$role){
                throw new Exception("Association not found");
            }

            if($role->pivot["role"] == RoleEnum::ADMIN->value){
                $abilities[] = '*';
                $status = AccessScopeEnum::GLOBAL_ACCESS_SCOPE->value;
            }else{
                $abilities[] = 'user_abilities';
                $status = AccessScopeEnum::USER_ACCESS_SCOPE->value;
            }

            $token = $user->createToken(env("APP_NAME"), $abilities)->plainTextToken;

            return response()->json([
                'token' => $token,
                'scopes' => $status
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);

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
}