<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transformers\PaisesTransformer;
use App\Http\Requests;

use League\Fractal;

use App\Pais;
use App\Provincia;
use App\Canton;
use DB;

class Mapas extends Controller
{
    var $mapfile;

    public function __construct(){
        include_once(app_path() . '/Libraries/Mapserver.php');
    }

    public function queryPoint($lat=0, $lng=0){
        return response()->success(qryPoint($lat,$lng));
    }

    public function queryImage($parametros=array(),$render=true,$width=500,$height=400){
        echo qryImage('gadm',$parametros,false,$width,$height);
    }

    public function gadm_paises(){
        $paises = Pais::all();
        return response()->success(compact('paises'));
    }

    /**
     * Devueve una imagen de paises explorados randomica
     * @param  Request $request Parametros por GET
     * @return imagen           Imagen del pais
     */
    public function imgRandom( Request $request){
        $render = ($request->has('render') ) ?$request->input('render'):false;
        $width  = ($request->has('width') ) ?$request->input('width'):500;
        $height = ($request->has('height') ) ?$request->input('height'):400;
        $img_format = ($request->has('format') ) ?$request->input('format'):"png";
        return paises_explorados_random('gadm_nivel0',$render,$width,$height,$img_format);
    }

    /**
     * Recorre la capa requerida para extraer los extent de cada
     * feature y escribirlos en nueva tabla
     * @param  string $capa nombre de la capa
     * @return [type]       [description]
     */
    public function extent($capa="paises",Request $request){
        $elementos = [];
        $query = [];

        switch ($capa) {
            case 'gadm_nivel0':
                //$elementos = Pais::where('id_0',68)->get();
                $elementos = Pais::skip(80)->take(20)->get();
                
                foreach ($elementos as $key => $elemento) {
                    $query =['id_0'=>$elemento->id_0];
                    $valor = extraer_extent($capa,$query);
                    $elemento->minx = $valor['minx'];
                    $elemento->miny = $valor['miny'];
                    $elemento->maxx = $valor['maxx'];
                    $elemento->maxy = $valor['maxy'];
                    $elemento->lat = $valor['lat'];
                    $elemento->lng = $valor['lng'];
                    $elemento->save();
                    //sleep(1);
                    echo "$key||OK $elemento->id_0 </br>";
                }
                break;
            case 'gadm_nivel1':
                if($request->has('id_0')){
                    $elementos = Provincia::where('id_0',$request->id_0)->get();
                }else{
                    $elementos = Provincia::all();
                }


                foreach ($elementos as $key => $elemento) {
                    $query =['ID_0'=>$elemento->id_0,'ID_1'=>$elemento->id_1];
                    //dd($capa,$query);
                    $valor = extraer_extent($capa,$query);
                    $elemento->minx = $valor['minx'];
                    $elemento->miny = $valor['miny'];
                    $elemento->maxx = $valor['maxx'];
                    $elemento->maxy = $valor['maxy'];
                    $elemento->lat = $valor['lat'];
                    $elemento->lng = $valor['lng'];
                    $elemento->save();
                    //sleep(1);
                    echo "OK $elemento->id_0/$elemento->id_1 </br>";
                }
                break;
            case 'gadm_nivel2':
                if($request->has('id_0')){
                    $provincias = Provincia::where('id_0',$request->id_0)->get();
                }else{
                    $provincias = Provincia::all();
                }
                foreach ($provincias as $key => $provincia) {
                    foreach ($provincia->cantones()->get() as $key => $elemento) {
                        $query =['id_0'=>$elemento->id_0,'id_1'=>$elemento->id_1,'id_2'=>$elemento->id_2];
                        $valor = extraer_extent($capa,$query);
                        $elemento->minx = $valor['minx'];
                        $elemento->miny = $valor['miny'];
                        $elemento->maxx = $valor['maxx'];
                        $elemento->maxy = $valor['maxy'];
                        $elemento->lat = $valor['lat'];
                        $elemento->lng = $valor['lng'];
                        $elemento->save();
                        //sleep(1);
                        echo "OK $elemento->id_0/$elemento->id_1/$elemento->id_2 </br>";
                    }
                }
                break;
        }
    }
}
