<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CaptureTime extends Enum
{
    const BEFORE = 0;
    const AFTER = 1;
    public static function getDescriptionArray()
    {
        return [
            self::BEFORE => 'Before',
            self::AFTER => 'After',
        ];
    }
}
