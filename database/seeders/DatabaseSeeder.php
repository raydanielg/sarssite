<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RegionsTableSeeder::class,
            DistrictsTableSeeder::class,
            LevelsTableSeeder::class,
            YearsTableSeeder::class,
            ResultTypeSeeder::class,
            AdminUserSeeder::class,
            SampleDataSeeder::class,
        ]);
    }
}
