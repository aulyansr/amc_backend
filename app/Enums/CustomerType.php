<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class CustomerType extends Enum
{
    const PUBLIC = 0;
    const CORPORATE = 1;
    const B2B2C = 2;

    public static function getDescriptionArray()
    {
        return [
            self::PUBLIC => 'Publik',
            self::CORPORATE => 'Korporat',
            self::B2B2C => 'B2B2C',
        ];
    }
}
