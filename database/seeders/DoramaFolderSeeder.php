<?php

namespace Database\Seeders;

use App\Models\DoramaFolder;
use Illuminate\Database\Seeder;

class DoramaFolderSeeder extends Seeder
{
    public function run(): void
    {
        DoramaFolder::query()->create([
            'title' => 'Смотрю',
            'user_id' => 0,
            'is_private' => true,
            'number' => 1,
        ]);

        DoramaFolder::query()->create([
            'title' => 'В планах',
            'user_id' => 0,
            'is_private' => true,
            'number' => 2,
        ]);

        DoramaFolder::query()->create([
            'title' => 'Просмотрено',
            'user_id' => 0,
            'is_private' => true,
            'number' => 3,
        ]);

        DoramaFolder::query()->create([
            'title' => 'Любимое',
            'user_id' => 0,
            'is_private' => true,
            'number' => 4,
        ]);

        DoramaFolder::query()->create([
            'title' => 'Брошено',
            'user_id' => 0,
            'is_private' => true,
            'number' => 5,
        ]);
    }
}
