<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Lugar;
use App\Pais;
use App\Provincia;
use App\Categoria;
use App\User;

use Auth;

class Back extends Controller
{
	var $datos=[];

	public function __construct(){
        include_once(app_path() . '/Libraries/Mapserver.php');
		$this->datos['total_categorias'] = Categoria::where('activa',1)->count();
    }

	public function index(){
		$this->datos['total_lugares'] = Lugar::count();
		if(Auth::user())
			return redirect()->route('game');
		return view('welcome',$this->datos);
	}

	/**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function game($pais_id=68)
    {
    	$pais = Pais::find($pais_id);
    	$paises = Pais::orderBy('pais','ASC')->get();


    	$this->datos['pais'] = $pais;
    	$this->datos['paises'] = $paises;
        $this->datos['categorias'] = Categoria::where('activa',1)->orderBy('nombre','ASC')->get()->lists('nombre','categoria');
        
    	$this->datos['items'] = Lugar::byPais($pais_id)->count();
        $this->datos['provincias'] = Provincia::byPais($pais_id)->orderBy('provincia','ASC')->get()->lists('provincia','id_1');
            
    	$this->datos['items_user'] = Lugar::visitedByPais(Auth::user()->id,$pais->id_0)->count();
        
        return view('inicio',$this->datos);
    }

    public function estadisticas($pais_id=68){
    	$pais = Pais::find($pais_id);
    	$paises = Pais::orderBy('pais','ASC')->get();
    	$users = User::orderByPoints()->get();
    	$categorias = Categoria::orderByLugares()->get();

    	$this->datos['pais'] = $pais;
    	$this->datos['paises'] = $paises;
    	$this->datos['users'] = $users;
    	$this->datos['categorias'] = $categorias;

    	$this->datos['items'] = Lugar::byPais($pais_id)->count();
    	$this->datos['items_user'] = Lugar::visitedByPais(Auth::user()->id,$pais->id_0)->count();

        return view('estadisticas',$this->datos);
    }

    public function game_provincia($categoria,$pais,$provincia)
    {
    	$categoria = Categoria::find($categoria);
    	$provincia = Provincia::where('id_0',$pais)->where('id_1',$provincia)->first();

    	$this->datos['categorias'] = Categoria::where('activa',1)->orderBy('nombre','ASC')->get();
    	$this->datos['provincias']=Provincia::where('id_0',$pais)->orderBy('provincia','ASC')->get();
    	
    	$this->datos['categoria']=$categoria;
    	$this->datos['provincia']=$provincia;

        $this->datos['items'] = Lugar::byCategoriaProvincia($categoria->categoria,$provincia)->count();

        $this->datos['items_user'] = Lugar::visitedByCategoriaProvincia(Auth::user()->id,$categoria->categoria,$provincia)->count();
        
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
    	$new_items = 0;
    	$items = [];
    	if($request->has('items')){
    		foreach ($request->items as $key => $item) {
			    $lugar = new Lugar();
			    $lugar->lat = $item['lat'];
			    $lugar->lng = $item['lng'];
			    $lugar->google_id = $item['place_id'];
			    $loc= qryPoint($lugar->lat,$lugar->lng);
			    $lugar->id_0 = $loc['id_0'];
			    $lugar->id_1 = $loc['id_1'];
			    $lugar->id_2 = $loc['id_2'];
			    $lugar->id_3 = $loc['id_3'];
			    try{
				    if($lugar->save()){
				        $new_items++;
				    }
			    }catch(\Exception $er){
			    	$lugar = Lugar::where('google_id',$item['place_id'])->first();
			    }
				$lugar->categorias()->sync($categorias);
			    $lugar->visited = (boolean)$lugar->isVisited(Auth::user()->id)->count();
			    $items[]=$lugar;	
    		}
	    	return response()->json(['sync'=>true,'new_items'=>$new_items,'sync_items'=>$items]);
    	}

	    return response()->json(['sync'=>false,'new_items'=>$new_items,'sync_items'=>[]]);
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_item(Request $request,$google_id){

    	$categorias = $request->categorias;

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

	/**
	 * Marca como visitado un lugar
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function visited(Request $request){
		$google_id  = $request->place_id;
		$user_id  = Auth::user()->id;
		$lugar = Lugar::where('google_id',$google_id)->first();
		$lugar->user()->sync([$user_id]);
		return response()->json($lugar);
	}
}
