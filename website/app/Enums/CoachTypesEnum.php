<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CoachTypesEnum extends Enum
{
    const Shuttle    =   0;
    const Bus        =   1;
    const Limousine  =   2;
}
