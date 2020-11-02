<?php

declare(strict_types=1);

namespace App;

use Elao\Enum\Enum;

final class Constants extends Enum {
    const FLASHTYPE = 'success';

    public static function values(): array {
        return [
            self::FLASHTYPE
        ];
    }
}