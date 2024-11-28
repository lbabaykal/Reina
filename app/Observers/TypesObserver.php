<?php

namespace App\Observers;

class TypesObserver
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
        cache()->forget('types');
    }

    public function deleted(): void
    {
        cache()->forget('types');
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
