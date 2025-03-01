<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Test extends Command
{
    protected $signature = 'test';
    protected $description = 'test command';

    public function handle(): void
    {
        echo "Test - Command complete\n";
    }
}
