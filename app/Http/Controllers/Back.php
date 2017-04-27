<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Lugar;
use App\Provincia;
use App\Categoria;
use App\User;

use Auth;

class Back extends Controller
{
	var $datos=[];

	public function __construct(){
        include_once(app_path() . '/Libraries/Mapserver.php');
    }

	public function index(){
		return view('welcome',$this->datos);
	}

	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function game()
    {
        $this->datos['categorias'] = Categoria::orderBy('categoria','ASC')->get()->lists('nombre','categoria');
        
        $this->datos['provincias'] = Provincia::byPais(68)->orderBy('provincia','ASC')->get()->lists('provincia','id_1');
            
        
        return view('inicio',$this->datos);
    }

    public function game_provincia($categoria,$provincia)
    {
    	$categoria = Categoria::find($categoria);
    	$provincias = Provincia::where('id_0',68)->orderBy('provincia','ASC')->get();
    	$provincia = Provincia::where('id_0',68)->where('id_1',$provincia)->first();


    	$this->datos['categorias'] = Categoria::orderBy('categoria','ASC')->get();
    	$this->datos['categoria']=$categoria;
    	$this->datos['provincia']=$provincia;

    	$this->datos['provincias']=$provincias;

        $this->datos['items'] = Lugar::byCategoria($categoria->categoria)->get();

        $this->datos['items_visitados'] = Lugar::visitedByCategoriaProvincia(Auth::user()->id,$categoria->categoria,$provincia->id_1)->get();

    	return view('explorar',$this->datos);
    }

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
    	$categorias = $request->type;
    	foreach ($categorias as $key => $c) {
			$categoria = Categoria::firstOrNew(['categoria'=>$c]);
			$categoria->categoria= $c;
			$categoria->icono_url = $request->icon;
			$categoria->save();
		}

	    $lugar = new Lugar();
	    $lugar->name = $request->name;
	    $lugar->vecinity = $request->vecinity;
	    $lugar->lat = $request->lat;
	    $lugar->lng = $request->lng;
	    $lugar->google_id = $request->place_id;
	    $loc= qryPoint($lugar->lat,$lugar->lng);
	    $lugar->id_0 = $loc['id_0'];
	    $lugar->id_1 = $loc['id_1'];
	    $lugar->id_2 = $loc['id_2'];
	    $lugar->id_3 = $loc['id_3'];
	    try{
		    if($lugar->save()){
		    	$lugar->categorias()->sync($categorias);
		        return response()->json($lugar);
		    }
	    }catch(\Exception $er){
	    	return response()->json(['lugar_store_error']);
	    }
	    return response()->json(['lugar_store_error']);
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_item(Request $request,$google_id){

    	$categorias = $request->categorias;

    	foreach ($categorias as $key => $c) {
	    		$categoria = Categoria::firstOrNew(['categoria'=>$c]);
	    		$categoria->categoria= $c;
	    		$categoria->icono_url = "";
	    		$categoria->save();
    	}

	    $lugar = Lugar::where('google_id',$google_id)->first();
	    $lugar->name = $request->name;
	    $lugar->imagen = $request->imagen;
	    $lugar->direccion = $request->direccion;
	    $lugar->vecinity = $request->vecinity;
	    $lugar->telefono = $request->telefono;
	    $lugar->web = $request->web;
	    $lugar->loaded = true;
	    
	    if($lugar->save()){
	    	$lugar->categorias()->sync($categorias);
	        return response()->json($lugar);
	    }
	    return response()->json(['lugar_store_error']);
	}

	public function get_item($google_id){
		$lugar = Lugar::where('google_id',$google_id)->first();
		$lugar->cats = $lugar->categorias->lists('categoria');
		$lugar->visited=false;
		return response()->json($lugar);
	}

	public function visited(Request $request){
		$google_id  = $request->place_id;
		$user_id  = $request->user_id;
		$lugar = Lugar::where('google_id',$google_id)->first();
		$lugar->user()->sync([$user_id]);
		return response()->json($lugar);
	}
}
