<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SubscriptionStatus extends Enum
{
    const BELUM_SELESAI = 'BELUM_SELESAI';
    const SELESAI = 'SELESAI';

    public static function getDescriptionArray(): array
    {
        return [
            self::BELUM_SELESAI => ['Belum Selesai','badge bg-danger'],
            self::SELESAI => ['Selesai','badge bg-success'],
        ];
    }
}
