<?php

namespace App\Enums;

enum Role: string
{

    use EnumValues;

    case ADMIN = 'Admin';
    case EDITOR = 'Employee';

    case NEW = 'New';

}
