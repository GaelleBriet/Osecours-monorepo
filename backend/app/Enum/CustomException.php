<?php

namespace App\Enum;

enum CustomException: string
{
    case UNAUTHORIZED = 'App\Exceptions\UnauthorizedException';
    case ROLE_ALREADY_EXIST = 'App\Exceptions\RoleAlreadyExistException';
    case ANIMAL_NOT_FOUND = 'App\Exceptions\AnimalNotFoundException';
}
