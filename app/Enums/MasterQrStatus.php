<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static AVAILABLE()
 * @method static static TAKEN()
 */
final class MasterQrStatus extends Enum
{
    const AVAILABLE = 0;
    const TAKEN = 1;
}
