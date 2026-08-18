<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Seeder;

class YearsTableSeeder extends Seeder
{
    public function run()
    {
        $years = [2024, 2025, 2026];

        foreach ($years as $year) {
            Year::updateOrCreate(
                ['year' => $year],
                ['year' => $year]
            );
        }
    }
}
