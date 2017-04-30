<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Provincia;
use App\Canton;

class Cantones extends Controller
{
    var $datos=[];
    
	/**
     * Muestra el listado de elementos
     */
    public function index($provincia_id){
        //$this->datos['pais'] = Pais::find($pais_id);
        $provincia = Provincia::find($provincia_id);
        $this->datos['provincia'] = $provincia;
        $this->datos['cantones_data'] = Canton::where('id_0',$provincia->id_0)->where('id_1',$provincia->id_1)->orderBy('canton','ASC')->get();
        return view('cantones.manager',$this->datos);
    }

    /**
     * Muestra el formulario para editar un elemento
     */
    public function edit($id){
        $canton = Canton::find($id);
        $this->datos['canton'] = $canton;
        $this->datos['provincia'] = Provincia::where('id_0',$canton->id_0)->where('id_1',$canton->id_1)->first();
        $zoom=[];
        for ($i=1; $i < 22; $i++) { 
            $zoom[$i]=$i;
        }
        $this->datos['zoom_list'] =$zoom;
        return view('cantones.edit',$this->datos);
    }

    /**
     * Toma los datos del formulario de actualizacion para enviarlos a la base de datos
     */
    public function update(Request $request, $id){
        $canton = Canton::find($id);
        $canton->fill($request->all());
        $canton->save();

        if($request->ajax()){
            return response()->json($canton);
        }else{
            return redirect()->route('cantones.index',$canton->id_0);
        }
    }

    /**
     * Elimina un elemento de la base de datos
     */
    public function destroy($id){
        $canton = Canton::find($id);
        $canton->delete();
        //flash("Canton $canton->nombre eliminada correctamente",'success');
        return response()->json($canton);
    }
}
