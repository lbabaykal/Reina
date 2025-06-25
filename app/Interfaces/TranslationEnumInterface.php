<?php

namespace App\Interfaces;

interface TranslationEnumInterface
{
    public static function translations(): array;

    public function translation(): ?string;
}
