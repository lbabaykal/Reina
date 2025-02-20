<?php

namespace Database\Seeders;

use App\Models\AnimeFolder;
use Illuminate\Database\Seeder;

class AnimeFolderSeeder extends Seeder
{
    public function run(): void
    {
        AnimeFolder::query()->create([
            'title' => 'Смотрю',
            'user_id' => 0,
            'is_private' => true,
            'number' => 1,
        ]);

        AnimeFolder::query()->create([
            'title' => 'В планах',
            'user_id' => 0,
            'is_private' => true,
            'number' => 2,
        ]);

        AnimeFolder::query()->create([
            'title' => 'Просмотрено',
            'user_id' => 0,
            'is_private' => true,
            'number' => 3,
        ]);

        AnimeFolder::query()->create([
            'title' => 'Любимое',
            'user_id' => 0,
            'is_private' => true,
            'number' => 4,
        ]);

        AnimeFolder::query()->create([
            'title' => 'Брошено',
            'user_id' => 0,
            'is_private' => true,
            'number' => 5,
        ]);
    }
}
