<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Lugar;
use App\Categoria;
use App\User;

class Back extends Controller
{
	var $datos;

	public function index(){

		$this->datos['items'] = Lugar::all();
		return view('welcome',$this->datos);
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
		$categoria = Categoria::findOrNew($request->type);

		$categoria->categoria= $request->type;
		$categoria->icono_url = $request->icon;
		$categoria->save();

	    $lugar = new Lugar();
	    $lugar->name = $request->name;
	    $lugar->vecinity = $request->vecinity;
	    $lugar->lat = $request->lat;
	    $lugar->lng = $request->lng;
	    $lugar->google_id = $request->place_id;
	    
	    if($lugar->save()){
	    	$lugar->categorias()->attach($categoria);
	        return response()->json($lugar);
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
	    		$categoria = Categoria::findOrNew($c);
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
