<?php

declare(strict_types=1);

namespace App\Enum;

use Elao\Enum\Enum;

final class Flashtypes extends Enum {
    const FLASHTYPE = 'success';

    public static function values(): array {
        return [
            self::FLASHTYPE
        ];
    }
}