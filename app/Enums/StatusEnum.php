<?php

namespace App\Enums;

use App\Interfaces\TranslationEnumInterface;
use App\Traits\EnumTrait;
use App\Traits\TranslationEnumTrait;
use Illuminate\Support\Facades\Lang;

enum StatusEnum: string implements TranslationEnumInterface
{
    use EnumTrait;
    use TranslationEnumTrait;

    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case IN_ARCHIVE = 'IN_ARCHIVE';
    case ON_MODERATION = 'ON_MODERATION';

    public static function translations(): array
    {
        return [
            self::PUBLISHED->value => Lang::get('enum_translation.status.published'),
            self::DRAFT->value => Lang::get('enum_translation.status.draft'),
            self::IN_ARCHIVE->value => Lang::get('enum_translation.status.in_archive'),
            self::ON_MODERATION->value => Lang::get('enum_translation.status.on_moderation'),
        ];
    }

}
