<?php

namespace App\Jobs;

use App\Models\AnimeView;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AnimeViewedJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $animeId,
        public string $ipAddress,
        public string $userAgent,
    ) {}

    public function handle(): void
    {
        AnimeView::query()
            ->create([
                'anime_id' => $this->animeId,
                'ip_address' => $this->ipAddress,
                'user_agent' => $this->userAgent,
            ]);
    }
}
