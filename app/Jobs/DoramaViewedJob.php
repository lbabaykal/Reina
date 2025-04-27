<?php

namespace App\Jobs;

use App\Models\DoramaView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DoramaViewedJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $doramaId,
        public string $ipAddress,
        public string $userAgent,
    ) {}

    public function handle(): void
    {
        DoramaView::query()
            ->create([
                'dorama_id' => $this->doramaId,
                'ip_address' => $this->ipAddress,
                'user_agent' => $this->userAgent,
            ]);
    }
}
