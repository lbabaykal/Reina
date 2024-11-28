<?php

namespace App\Observers;

class StudiosObserver
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
        cache()->forget('studios');
    }

    public function deleted(): void
    {
        cache()->forget('studios');
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
