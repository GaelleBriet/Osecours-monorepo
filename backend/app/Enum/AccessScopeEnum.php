<?php

namespace App\Enum;

enum AccessScopeEnum: string
{
    case GLOBAL_ACCESS_SCOPE = 'global_access_scope';
    case USER_ACCESS_SCOPE = 'user_access_scope';
    case OTHER_ACCESS_SCOPE = 'other_access_scope';

}