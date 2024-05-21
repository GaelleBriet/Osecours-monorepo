<?php

namespace App\Enum;

enum UserStatus: string
{
    case CONNECTED = 'connected';
    case DISCONNECTED = 'disconnected';
}