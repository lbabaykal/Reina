<?php

namespace App\Listeners;

use App\Events\AnimeViewedEvent;
use App\Jobs\AnimeViewedJob;

class AnimeViewedListener
{
    public function handle(AnimeViewedEvent $event): void
    {
        AnimeViewedJob::dispatch(
            $event->animeId,
            $event->ipAddress,
            $event->userAgent,
        );
    }
}
