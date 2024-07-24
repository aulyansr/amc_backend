<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TeamStatus extends Enum
{
    const  AVAILABLE = 0;
    const ONDUTY = 1;

    public static function label(): array
    {
        return [
            self::AVAILABLE => [
                'status'=>'Tidak Bekerja',
                'color'=>'bg-success',
            ],
            self::ONDUTY => [
                'status'=>'Sedang Bekerja',
                'color'=>'bg-warning',
            ],
        ];
    }

    public static function getOnlyStatus(): array
    {
        return [
            self::AVAILABLE =>'Tidak Bekerja',
            self::ONDUTY =>'Sedang Bekerja',
        ];
    }
}
