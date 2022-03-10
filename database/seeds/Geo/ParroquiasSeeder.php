<?php

namespace Database\Seeders\Geo;

use App\Canton;
use App\Pais;
use App\Parroquia;
use App\Provincia;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ParroquiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = "database/backups/parroquias.json";

        $content = File::get($filename);

        $parroquias_gadm = json_decode($content);


        foreach ($parroquias_gadm as $parroquia) {

            $p = new Parroquia();
            $p->gid0 = $parroquia->gid0; //pais
            $p->gid1 = $parroquia->gid1; //provincia
            $p->gid2 = $parroquia->gid2; //canton
            $p->gid3 = $parroquia->gid3; //parroquia
            //$p->icono = $parroquia->icono;
            $p->parroquia = $parroquia->nombre;
            $p->descripcion = $parroquia->descripcion;
            $p->nombre_corto = $parroquia->nombre;
            //$p->slug = $parroquia->slug;
            $p->tipo = $parroquia->tipo;
            $p->engtype = $parroquia->engtype;
            // dd($parroquia);
            //$p->bandera_url = strtolower(substr($parroquia->code, 0,2)).'.svg' ;
            $p->minx = $parroquia->minx;
            $p->miny = $parroquia->miny;
            $p->maxx = $parroquia->maxx;
            $p->maxy = $parroquia->maxy;
            $p->lat = $parroquia->lat;
            $p->lng = $parroquia->lng;
            //true solo para Tungurahua
            $p->estado = $parroquia->gid1 == "ECU.23_1" ? true : false;
            $p->zoom = 13;

            $pais = Pais::where("gid0",$p->gid0)->first();
            $p->id_0 = $pais->id; 
            $provincia = Provincia::where("gid1",$p->gid1)->first();
            $p->id_1 = $provincia->id; 
            $canton = Canton::where("gid2",$p->gid2)->first();
            $p->id_2 = $canton->id; 
            
            $p->save();
        }
    }
}