<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Pais;

class Paises extends Controller
{
    var $datos=[];
    
	/**
     * Muestra el listado de elementos
     */
    public function index(){
        $this->datos['paises_data'] = Pais::orderBy('pais','ASC')->get();
        return view('paises.manager',$this->datos);
    }

    /**
     * Muestra el formulario para editar un elemento
     */
    public function edit($id){
        $this->datos['pais'] = Pais::find($id);
        return view('paises.edit',$this->datos);
    }

    /**
     * Toma los datos del formulario de actualizacion para enviarlos a la base de datos
     */
    public function update(Request $request, $id){
        $pais = Pais::find($id);
        $pais->fill($request->all());
        $pais->save();

        if($request->ajax()){
            return response()->json($pais);
        }else{
            return redirect()->route('paises.index');
        }
    }

    /**
     * Elimina un elemento de la base de datos
     */
    public function destroy($id){
        $pais = Pais::find($id);
        $pais->delete();
        //flash("Pais $pais->nombre eliminada correctamente",'success');
        return response()->json($pais);
    }
}
