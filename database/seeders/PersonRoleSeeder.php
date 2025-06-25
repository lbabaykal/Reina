<?php

namespace Database\Seeders;

use App\Models\PersonRole;
use Illuminate\Database\Seeder;

class PersonRoleSeeder extends Seeder
{
    public function run(): void
    {
        PersonRole::query()->create([
            'name' => 'Актер',
            'slug' => 'actors',
        ]);

        PersonRole::query()->create([
            'name' => 'Режиссер',
            'slug' => 'directors',
        ]);

        PersonRole::query()->create([
            'name' => 'Продюсер',
            'slug' => 'producers',
        ]);

        PersonRole::query()->create([
            'name' => 'Сценарист',
            'slug' => 'writers',
        ]);

        PersonRole::query()->create([
            'name' => 'Оператор',
            'slug' => 'operators',
        ]);

        PersonRole::query()->create([
            'name' => 'Композитор',
            'slug' => 'composers',
        ]);

        PersonRole::query()->create([
            'name' => 'Монтажер',
            'slug' => 'editors',
        ]);
    }
}
