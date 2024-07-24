<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class AcTypeEnum extends Enum
{
    const SPLITWALL = 'Split Wall';
    const SPLITDUCK = 'Split Duck';
    const SPLITINVERTER = 'Split inverter';
    const PORTABLE = 'Portable';
    const CASSATE = 'Cassate';
    const CASSATEDUCK = 'Cassate Duck';
    const FLOORSTANDING = 'Floor Standing';
    const OTHERS = 'Others';

    public static function getArray()
    {
        return [
            self::SPLITWALL,
            self::SPLITDUCK,
            self::SPLITINVERTER,
            self::PORTABLE,
            self::CASSATE,
            self::CASSATEDUCK,
            self::FLOORSTANDING,
            self::OTHERS,
        ];
    }
}
