<?php

namespace App\Observers\Dorama;

use App\Enums\CacheEnum;
use App\Enums\StatusEnum;
use App\Models\Dorama;
use Illuminate\Support\Facades\Storage;

class DoramaObserver
{
    public function created(Dorama $dorama): void
    {
        if ($dorama->status === StatusEnum::PUBLISHED->value) {
            $this->forgetCacheMainDorama();
        }
    }

    public function updating(Dorama $dorama): void
    {
        if ($dorama->isDirty('poster') && $dorama->getOriginal('poster')) {
            Storage::disk('dorama_posters')->delete($dorama->getOriginal('poster'));

            $this->forgetCacheDorama($dorama);
            $this->forgetCacheMainDorama();
        }

        if ($dorama->isDirty('cover') && $dorama->getOriginal('cover')) {
            Storage::disk('dorama_covers')->delete($dorama->getOriginal('cover'));

            $this->forgetCacheDorama($dorama);
            $this->forgetCacheMainDorama();
        }

        if ($dorama->isDirty('slug')) {
            cache()->store('redis_doramas')->forget('dorama:'.$dorama->getOriginal('slug'));
        }
    }

    public function updated(Dorama $dorama): void
    {
        if (
            $dorama->getOriginal('status') === StatusEnum::PUBLISHED->value
            && $dorama->status !== StatusEnum::PUBLISHED->value
            || $dorama->status === StatusEnum::PUBLISHED->value
        ) {
            $this->forgetCacheDorama($dorama);
            $this->forgetCacheMainDorama();
        }
    }

    public function saving(Dorama $dorama): void
    {
        //
    }

    public function saved(Dorama $dorama): void
    {
        //
    }

    public function deleted(Dorama $dorama): void
    {
        $this->forgetCacheDorama($dorama);
        $this->forgetCacheMainDorama();
    }

    public function restored(Dorama $dorama): void
    {
        //
    }

    public function forceDeleted(Dorama $dorama): void
    {
        $dorama->ratings()->delete();
        $dorama->favorites()->delete();

        $dorama->episodes()->delete();

        $dorama->genres()->detach();
        $dorama->studios()->detach();

        if ($dorama->getOriginal('poster') !== null) {
            Storage::disk('dorama_posters')->delete($dorama->getOriginal('poster'));
        }

        if ($dorama->getOriginal('cover') !== null) {
            Storage::disk('dorama_covers')->delete($dorama->getOriginal('cover'));
        }

        $this->forgetCacheDorama($dorama);
        $this->forgetCacheMainDorama();
    }

    public function retrieved(Dorama $dorama): void
    {
        //
    }

    public function forgetCacheMainDorama(): void
    {
        cache()->store(CacheEnum::DORAMAS_STORE->value)->forget(CacheEnum::MAIN_DORAMAS->value);
    }

    public function forgetCacheDorama(Dorama $dorama): void
    {
        cache()->store(CacheEnum::DORAMAS_STORE->value)->forget(CacheEnum::DORAMA->value.$dorama->slug);
    }
}
