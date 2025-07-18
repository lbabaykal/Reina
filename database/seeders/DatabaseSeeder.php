<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TypeSeeder::class,
            GenreSeeder::class,
            StudioSeeder::class,
            CountrySeeder::class,
            UserSeeder::class,
            AnimeFolderSeeder::class,
            DoramaFolderSeeder::class,
            CharacterRoleSeeder::class,
            PersonRoleSeeder::class,
            //            Permissions::class,
            //            Roles::class,
        ]);
    }
}
