<?php

namespace App\Traits;

trait TranslationEnumTrait
{
    public function translation(): ?string
    {
        $translations = static::translations();

        return $translations[$this->value] ?? null;
    }
}
