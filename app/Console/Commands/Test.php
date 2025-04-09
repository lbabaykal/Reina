<?php

namespace App\Console\Commands;

use App\Models\Dorama;
use App\Models\DoramaEpisode;
use App\Models\DoramaFolder;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Test extends Command
{
    protected $signature = 'test';

    protected $description = 'test command';

    public function handle(): void
    {
        echo "Test - Command complete\n";
    }
}
