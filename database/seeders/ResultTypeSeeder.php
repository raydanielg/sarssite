<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResultType;
use Illuminate\Support\Str;

class ResultTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Mock Exam',
                'description' => 'Mitihani ya majaribio ya kimkoa au kiwilaya'
            ],
            [
                'name' => 'Joint Exam',
                'description' => 'Mitihani ya pamoja kati ya shule mbalimbali'
            ],
            [
                'name' => 'Midterm Exam',
                'description' => 'Mitihani ya katikati ya muhula'
            ],
            [
                'name' => 'Annual Exam',
                'description' => 'Mitihani ya mwisho wa mwaka'
            ],
            [
                'name' => 'Terminal Exam',
                'description' => 'Mitihani ya mwisho wa muhula'
            ]
        ];

        foreach ($types as $type) {
            ResultType::create([
                'name' => $type['name'],
                'slug' => Str::slug($type['name']),
                'description' => $type['description'],
                'is_active' => true
            ]);
        }
    }
}
