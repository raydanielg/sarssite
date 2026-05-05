<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            'Arusha', 'Dar es Salaam', 'Dodoma', 'Geita', 'Iringa', 'Kagera', 'Katavi', 'Kigoma', 
            'Kilimanjaro', 'Lindi', 'Manyara', 'Mara', 'Mbeya', 'Morogoro', 'Mtwara', 'Mwanza', 
            'Njombe', 'Pemba Kaskazini', 'Pemba Kusini', 'Pwani', 'Rukwa', 'Ruvuma', 'Shinyanga', 
            'Simiyu', 'Singida', 'Songwe', 'Tabora', 'Tanga', 'Unguja Kaskazini', 'Unguja Kusini', 
            'Unguja Mjini Magharibi'
        ];

        foreach ($regions as $region) {
            Region::updateOrCreate(
                ['name' => $region],
                ['slug' => Str::slug($region)]
            );
        }
    }
}
