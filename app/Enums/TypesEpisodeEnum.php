<?php

namespace App\Enums;

use App\Interfaces\TranslationEnumInterface;
use App\Traits\EnumTrait;
use App\Traits\TranslationEnumTrait;
use Illuminate\Support\Facades\Lang;

enum TypesEpisodeEnum: string implements TranslationEnumInterface
{
    use EnumTrait;
    use TranslationEnumTrait;

    case VOICEOVER = 'VOICEOVER';
    case DUBBING = 'DUBBING';
    case SUBTITLES = 'SUBTITLES';

    public static function translations(): array
    {
        return [
            self::VOICEOVER->value => Lang::get('enum_translation.types_episode.voiceover'),
            self::DUBBING->value => Lang::get('enum_translation.types_episode.dubbing'),
            self::SUBTITLES->value => Lang::get('enum_translation.types_episode.subtitles'),
        ];
    }

}
