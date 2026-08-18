<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DistrictsTableSeeder extends Seeder
{
    public function run()
    {
        $districtsByRegion = [
            'Arusha' => ['Arusha City', 'Arusha Rural', 'Karatu', 'Longido', 'Monduli', 'Ngorongoro', 'Meru'],
            'Dar es Salaam' => ['Ilala', 'Kinondoni', 'Temeke', 'Ubungo', 'Kigamboni'],
            'Dodoma' => ['Dodoma City', 'Bahi', 'Chamwino', 'Chemba', 'Kondoa', 'Kongwa', 'Mpwapwa'],
            'Geita' => ['Geita Town', 'Bukombe', 'Chato', 'Mbogwe', 'Nyang\'hwale'],
            'Iringa' => ['Iringa Urban', 'Iringa Rural', 'Kilolo', 'Mafinga', 'Mufindi'],
            'Kagera' => ['Bukoba Rural', 'Bukoba Urban', 'Karagwe', 'Kyerwa', 'Misenye', 'Ngara'],
            'Katavi' => ['Mpanda Town', 'Mpanda Rural', 'Nsimbo', 'Mlele'],
            'Kigoma' => ['Kigoma Urban', 'Kigoma Rural', 'Buhigwe', 'Kakonko', 'Kasulu Rural', 'Kasulu Town', 'Uvinza'],
            'Kilimanjaro' => ['Moshi Urban', 'Moshi Rural', 'Hai', 'Mwanga', 'Rombo', 'Same', 'Siha'],
            'Lindi' => ['Lindi Urban', 'Lindi Rural', 'Kilwa', 'Liwale', 'Nachingwea', 'Ruangwa'],
            'Manyara' => ['Babati Town', 'Babati Rural', 'Hanang', 'Kiteto', 'Mbulu', 'Simanjiro'],
            'Mara' => ['Musoma Urban', 'Musoma Rural', 'Bunda', 'Butiama', 'Rorya', 'Serengeti', 'Tarime'],
            'Mbeya' => ['Mbeya City', 'Mbeya Rural', 'Chunya', 'Ileje', 'Kyela', 'Mbarali', 'Rungwe', 'Busokelo'],
            'Morogoro' => ['Morogoro Urban', 'Morogoro Rural', 'Gairo', 'Ifakara Town', 'Kilombero', 'Kilosa', 'Malinyi', 'Mvomero', 'Ulanga'],
            'Mtwara' => ['Mtwara Urban', 'Mtwara Rural', 'Masasi Town', 'Masasi Rural', 'Mkuranga', 'Nanyamba Town', 'Newala', 'Tandahimba'],
            'Mwanza' => ['Ilemela', 'Nyamagana', 'Kwimba', 'Magu', 'Misungwi', 'Sengerema', 'Ukerewe'],
            'Njombe' => ['Njombe Town', 'Njombe Rural', 'Ludewa', 'Makete', 'Wanging\'ombe'],
            'Pemba Kaskazini' => ['Wete', 'Micheweni'],
            'Pemba Kusini' => ['Chake Chake', 'Mkoani'],
            'Pwani' => ['Kibaha Town', 'Kibaha Rural', 'Bagamoyo', 'Kisarawe', 'Mafia', 'Mkuranga', 'Rufiji'],
            'Rukwa' => ['Sumbawanga Town', 'Sumbawanga Rural', 'Kalambo', 'Nkasi'],
            'Ruvuma' => ['Songea Urban', 'Songea Rural', 'Mbinga', 'Namtumbo', 'Tunduru'],
            'Shinyanga' => ['Shinyanga Urban', 'Shinyanga Rural', 'Kahama Town', 'Kahama Rural', 'Kishapu'],
            'Simiyu' => ['Bariadi Town', 'Bariadi Rural', 'Busega', 'Itilima', 'Meatu'],
            'Singida' => ['Singida Urban', 'Singida Rural', 'Iramba', 'Manyoni', 'Mkalama', 'Itigi'],
            'Songwe' => ['Songwe', 'Mbozi', 'Chunya', 'Ileje'],
            'Tabora' => ['Tabora Urban', 'Tabora Rural', 'Igunga', 'Kaliua', 'Nzega', 'Sikonge', 'Uyui'],
            'Tanga' => ['Tanga City', 'Handeni', 'Kilindi', 'Korogwe Town', 'Korogwe Rural', 'Lushoto', 'Mkinga', 'Muheza', 'Pangani'],
            'Unguja Kaskazini' => ['Kaskazini A', 'Kaskazini B'],
            'Unguja Kusini' => ['Kusini', 'Kati'],
            'Unguja Mjini Magharibi' => ['Mjini', 'Magharibi A', 'Magharibi B'],
        ];

        foreach ($districtsByRegion as $regionName => $districts) {
            $region = Region::where('name', $regionName)->first();
            if (!$region) {
                continue;
            }

            foreach ($districts as $districtName) {
                District::updateOrCreate(
                    ['region_id' => $region->id, 'slug' => Str::slug($districtName)],
                    ['name' => $districtName]
                );
            }
        }
    }
}
