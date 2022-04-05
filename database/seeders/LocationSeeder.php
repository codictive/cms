<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Codictive\Cms\Models\Province;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $states = json_decode(file_get_contents(storage_path('/locations.json')), true);

        foreach ($states as $state) {
            $p = Province::create(['name' => $state['name']]);
            foreach ($state['cities'] as $city) {
                $c = $p->cities()->create(['name' => $city['name']]);
            }
        }
    }
}
