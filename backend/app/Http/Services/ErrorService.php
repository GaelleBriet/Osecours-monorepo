<?php
namespace App\Http\Services;

use App\Enum\CustomException;
use Exception;
use Throwable;

class ErrorService{

    public function handle(Throwable $e){

        $message = $e->getMessage();
        $statusCode = 500;

        switch($e::class){
            case CustomException::UNAUTHORIZED->value:
                $statusCode = 401;
                break;
            case CustomException::ROLE_ALREADY_EXIST->value: 
                $statusCode = 422;
                case CustomException::ANIMAL_NOT_FOUND->value: 
                    $statusCode = 404;
                    break;
            default: 
                $message = $e->getMessage();
                break;
        }

        return response()->json(["error" => $message], $statusCode);

    }
}