<?php

namespace App\Enums;

use Illuminate\Support\Facades\Lang;

enum StatusEnum: string
{
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case IN_ARCHIVE = 'IN_ARCHIVE';
    case ON_MODERATION = 'ON_MODERATION';

    public static function getName(StatusEnum $status): string
    {
        return match ($status) {
            self::PUBLISHED => Lang::get('enum.status.published'),
            self::DRAFT => Lang::get('enum.status.draft'),
            self::IN_ARCHIVE => Lang::get('enum.status.in_archive'),
            self::ON_MODERATION => Lang::get('enum.status.on_moderation'),
            default => Lang::get('enum.status.not_found'),
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
