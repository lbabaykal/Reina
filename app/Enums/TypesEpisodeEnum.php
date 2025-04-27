<?php

namespace App\Enums;

use Illuminate\Support\Facades\Lang;

enum TypesEpisodeEnum: string
{
    case VOICEOVER = 'VOICEOVER';
    case DUBBING = 'DUBBING';
    case SUBTITLES = 'SUBTITLES';

    public static function getName(TypesEpisodeEnum $episodeEnum): string
    {
        return match ($episodeEnum) {
            self::VOICEOVER => Lang::get('enum.types_episode.voiceover'),
            self::DUBBING => Lang::get('enum.types_episode.dubbing'),
            self::SUBTITLES => Lang::get('enum.types_episode.subtitles'),
            default => Lang::get('enum.types_episode.not_found'),
        };
    }

    public static function getAll(): array
    {
        return array_combine(self::values(), self::names());
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
