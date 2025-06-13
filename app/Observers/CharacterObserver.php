<?php

namespace App\Observers;

use App\Models\Character;
use App\Services\Image\PhotoService;

class CharacterObserver
{
    public function creating(Character $character): void
    {
        $character->slug = str()->slug($character->full_name_ru);
    }

    public function created(Character $character): void
    {
        $character->slug = str()->slug($character->full_name_ru).'-'.$character->id;
        $character->saveQuietly();
    }

    public function updating(Character $character): void
    {
        if ($character->isDirty('photo') && $character->getOriginal('photo')) {
            new PhotoService()->deletePhoto($character->getOriginal('photo'));
        }

        if ($character->isDirty('full_name_ru')) {
            $character->slug = str()->slug($character->full_name_ru).'-'.$character->id;
        }
    }

    public function deleted(Character $character): void
    {
        if ($character->photo !== null) {
            new PhotoService()->deletePhoto($character->photo);
        }
    }
}
