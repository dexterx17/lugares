<?php

namespace Database\Seeders\Geo;

use App\Canton;
use App\Pais;
use App\Provincia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CantonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = "database/backups/cantones.json";

        $content = File::get($filename);

        $cantones_gadm = json_decode($content);


        foreach ($cantones_gadm as $canton) {
            $p = new Canton();
            $p->gid0 = $canton->gid0; //pais
            $p->gid1 = $canton->gid1; //provincia
            $p->gid2 = $canton->gid2; //canton
            $p->canton = $canton->nombre;
            $p->tipo = $canton->tipo;
            $p->engtype = $canton->engtype;
            //$p->bandera_url = strtolower(substr($canton->code, 0,2)).'.svg' ;
            $p->minx = $canton->minx;
            $p->miny = $canton->miny;
            $p->maxx = $canton->maxx;
            $p->maxy = $canton->maxy;
            $p->lat = $canton->lat;
            $p->lng = $canton->lng;
            $p->zoom = 13;
            //true solo para cotopaxi
            $p->estado = $canton->gid1 == "ECU.6_1" ? true : false;

            $pais = Pais::where("gid0",$p->gid0)->first();
            $p->id_0 = $pais->id; 
            $provincia = Provincia::where("gid1",$p->gid1)->first();
            $p->id_1 = $provincia->id; 
            
            
            $p->save();
        }
    }
}