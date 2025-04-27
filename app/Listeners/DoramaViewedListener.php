<?php

namespace App\Listeners;

use App\Events\DoramaViewedEvent;
use App\Jobs\DoramaViewedJob;

class DoramaViewedListener
{
    public function handle(DoramaViewedEvent $event): void
    {
        DoramaViewedJob::dispatch(
            $event->doramaId,
            $event->ipAddress,
            $event->userAgent,
        );
    }
}
