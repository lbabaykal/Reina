<?php

namespace App\Traits;

trait TranslationEnumTrait
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function all(): array
    {
        return array_combine(self::values(), self::names());
    }

    public function translation(): ?string
    {
        $translations = static::translations();

        return $translations[$this->value] ?? null;
    }
}
