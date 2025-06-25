<?php

namespace App\Enums;

use App\Interfaces\TranslationEnumInterface;
use App\Traits\EnumTrait;
use App\Traits\TranslationEnumTrait;

enum AgeRatingEnum: string implements TranslationEnumInterface
{
    use EnumTrait;
    use TranslationEnumTrait;

    case ZERO = '0+';
    case SIX = '6+';
    case TWELVE = '12+';
    case SIXTEEN = '16+';
    case EIGHTEEN = '18+';

    public static function translations(): array
    {
        return [
            self::ZERO->value => '0+',
            self::SIX->value => '6+',
            self::TWELVE->value => '12+',
            self::SIXTEEN->value => '16+',
            self::EIGHTEEN->value => '18+',
        ];
    }

}
