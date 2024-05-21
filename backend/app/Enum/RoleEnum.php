<?php

namespace App\Enum;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case ACCOUNTANT = 'accountant';
    case PRESIDENT = 'president';
    case ADOPT = 'adopt';
    case OTHER = 'other';
    case FOSTER = 'foster';
}