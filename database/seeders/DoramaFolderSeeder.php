<?php

namespace Database\Seeders;

use App\Models\DoramaFolder;
use Illuminate\Database\Seeder;

class DoramaFolderSeeder extends Seeder
{
    public function run(): void
    {
        $folders = [
            ['name' => 'Смотрю'],
            ['name' => 'В планах'],
            ['name' => 'Просмотрено'],
            ['name' => 'Любимое'],
            ['name' => 'Отложено'],
            ['name' => 'Брошено'],
        ];

        foreach ($folders as $folder) {
            DoramaFolder::query()->create([
                'name' => $folder['name'],
                'user_id' => 0,
                'is_private' => true,
            ]);

            sleep(1);
        }
    }
}
