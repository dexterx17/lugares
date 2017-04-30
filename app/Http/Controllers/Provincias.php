<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Pais;
use App\Provincia;

class Provincias extends Controller
{
    var $datos=[];
    
	/**
     * Muestra el listado de elementos
     */
    public function index($pais_id){
        $this->datos['pais'] = Pais::find($pais_id);
        $this->datos['provincias_data'] = Provincia::where('id_0',$pais_id)->orderBy('provincia','ASC')->get();
        return view('provincias.manager',$this->datos);
    }

    /**
     * Muestra el formulario para editar un elemento
     */
    public function edit($id){
        $provincia = Provincia::find($id);
        $this->datos['provincia'] = $provincia;
        $this->datos['pais'] = Pais::find($provincia->id_0);
        $zoom=[];
        for ($i=1; $i < 22; $i++) { 
            $zoom[$i]=$i;
        }
        $this->datos['zoom_list'] =$zoom;
        return view('provincias.edit',$this->datos);
    }

    /**
     * Toma los datos del formulario de actualizacion para enviarlos a la base de datos
     */
    public function update(Request $request, $id){
        $provincia = Provincia::find($id);
        $provincia->fill($request->all());
        $provincia->save();

        if($request->ajax()){
            return response()->json($provincia);
        }else{
            return redirect()->route('provincias.index',$provincia->id_0);
        }
    }

    /**
     * Elimina un elemento de la base de datos
     */
    public function destroy($id){
        $provincia = Provincia::find($id);
        $provincia->delete();
        //flash("Provincia $provincia->nombre eliminada correctamente",'success');
        return response()->json($provincia);
    }
}
