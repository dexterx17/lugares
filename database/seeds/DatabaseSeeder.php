<?php

use Illuminate\Database\Seeder;

use App\User;
use Database\Seeders\Geo\PaisesSeeder;
use Database\Seeders\GeoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name'=>'test',
            'email'=>'test@test.com',
            'password'=>bcrypt('12345'),
            'type' => 'superadmin'
        ]);
        $this->call([CategoriasSeeder::class, PaisesSeeder::class]);

     
    }
}
