<?php

namespace App\Observers;

class GenresObserver
{
    public function created(): void
    {
        //
    }

    public function updating(): void
    {
        //
    }

    public function updated(): void
    {
        //
    }

    public function saving(): void
    {
        //
    }

    public function saved(): void
    {
        cache()->forget('genres');
    }

    public function deleted(): void
    {
        cache()->forget('genres');
    }

    public function restored(): void
    {
        //
    }

    public function forceDeleted(): void
    {
        //
    }

    public function retrieved(): void
    {
        //
    }
}
