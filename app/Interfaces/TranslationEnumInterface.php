<?php

namespace App\Interfaces;

interface TranslationEnumInterface
{
    public static function names(): array;

    public static function values(): array;

    public static function all(): array;

    public static function translations(): array;

    public function translation(): ?string;
}
