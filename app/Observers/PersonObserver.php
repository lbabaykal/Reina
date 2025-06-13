<?php

namespace App\Observers;

use App\Models\Person;
use App\Services\Image\PhotoService;

class PersonObserver
{
    public function creating(Person $person): void
    {
        $person->slug = str()->slug($person->full_name_ru);
    }

    public function created(Person $person): void
    {
        $person->slug = str()->slug($person->full_name_ru) . '-' . $person->id;
        $person->saveQuietly();
    }

    public function updating(Person $person): void
    {
        if ($person->isDirty('photo') && $person->getOriginal('photo')) {
            new PhotoService()->deletePhoto($person->getOriginal('photo'));
        }

        if ($person->isDirty('full_name_ru')) {
            $person->slug = str()->slug($person->full_name_ru) . '-' . $person->id;
        }
    }

    public function deleted(Person $person): void
    {
        if ($person->photo !== null) {
            new PhotoService()->deletePhoto($person->photo);
        }
    }
}
