<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LevelsTableSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            ['name' => 'O-Level', 'slug' => 'o-level'],
            ['name' => 'A-Level', 'slug' => 'a-level'],
        ];

        foreach ($levels as $level) {
            Level::updateOrCreate(
                ['slug' => $level['slug']],
                ['name' => $level['name']]
            );
        }
    }
}
