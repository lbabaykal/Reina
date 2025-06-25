<?php

namespace Database\Seeders;

use App\Models\CharacterRole;
use Illuminate\Database\Seeder;

class CharacterRoleSeeder extends Seeder
{
    public function run(): void
    {
        CharacterRole::query()->create([
            'name' => 'Главная',
            'slug' => 'mains',
        ]);

        CharacterRole::query()->create([
            'name' => 'Второстепенная',
            'slug' => 'secondaries',
        ]);

        CharacterRole::query()->create([
            'name' => 'Эпизодическая',
            'slug' => 'episodics',
        ]);
    }
}
