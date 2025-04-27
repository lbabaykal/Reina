<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DoramaViewedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $doramaId,
        public string $ipAddress,
        public string $userAgent,
    ) {}
}
