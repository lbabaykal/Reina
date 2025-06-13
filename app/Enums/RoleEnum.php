<?php

namespace App\Enums;

use App\Interfaces\TranslationEnumInterface;
use App\Traits\TranslationEnumTrait;
use Illuminate\Support\Facades\Lang;

enum RoleEnum: string implements TranslationEnumInterface
{
    use TranslationEnumTrait;

    case MAIN = 'MAIN';
    case SECONDARY = 'SECONDARY';
    case EPISODIC = 'EPISODIC';

    public static function translations(): array
    {
        return [
            self::MAIN->value => Lang::get('reina.role.main'),
            self::SECONDARY->value => Lang::get('reina.role.secondary'),
            self::EPISODIC->value => Lang::get('reina.role.episodic'),
        ];
    }

}
