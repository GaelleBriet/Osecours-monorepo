<?php

namespace App\Enum;

enum CustomException: string
{
    case UNAUTHORIZED = 'App\Exceptions\UnauthorizedException';
}