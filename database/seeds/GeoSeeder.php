<?php

namespace Database\Seeders;

use Database\Seeders\Geo\CantonesSeeder;
use Database\Seeders\Geo\PaisesSeeder;
use Database\Seeders\Geo\ParroquiasSeeder;
use Database\Seeders\Geo\ProvinciasSeeder;
use Illuminate\Database\Seeder;

class GeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PaisesSeeder::class,
            // ProvinciasSeeder::class,
            // CantonesSeeder::class,
            // ParroquiasSeeder::class,
        ]);
    }
}