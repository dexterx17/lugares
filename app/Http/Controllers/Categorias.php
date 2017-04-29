<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Categoria;

class Categorias extends Controller
{
	/**
     * Muestra el listado de elementos
     */
    public function index(){
        $this->datos['categorias_data'] = Categoria::orderBy('categoria','ASC')->get();
        return view('categorias.manager',$this->datos);
    }

    /**
     * Muestra el formulario para crear un elemento
     */
    public function create(){
        return view('categorias.create',$this->datos);
    }

    /**
     * Toma los datos del formulario de insercion para enviarlos a la base de datos
     */
    public function store(Request $request){
        $categoria = new Categoria($request->all());

        $categoria->save();
        //flash("$categoria->nombre actualizado correctamente",'success');
        return redirect()->route('categorias.index');
    }

    /**
     * Muestra el formulario para editar un elemento
     */
    public function edit($id){
        $this->datos['categoria'] = Categoria::find($id);
        return view('categorias.edit',$this->datos);
    }

    /**
     * Toma los datos del formulario de actualizacion para enviarlos a la base de datos
     */
    public function update(Request $request, $id){
        $categoria = Categoria::find($id);
        $categoria->fill($request->all());
        if($request->has('activa'))
            $categoria->activa=TRUE;
        else
            $categoria->activa=FALSE;
        $categoria->save();

        if($request->ajax()){
            return response()->json($categoria);
        }else{
            return redirect()->route('categorias.index');
        }
    }

    /**
     * Elimina un elemento de la base de datos
     */
    public function destroy($id){
        $categoria = Categoria::find($id);
        $categoria->delete();
        //flash("Categoria $categoria->nombre eliminada correctamente",'success');
        return response()->json($categoria);
    }
}
