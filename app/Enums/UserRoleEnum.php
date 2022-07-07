<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRoleEnum extends Enum
{
    const EMPLOYER  =   0;
    const PASSENGER =   1;
    const ADMIN     =   2;
    const EMPLOYEE  =   3;
}
