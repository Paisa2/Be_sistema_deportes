<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $txtBuscar = "%";
        if($request->has("txtBuscar"))
        {
            $txtBuscar = $request->txtBuscar;
            $categorias = Categoria::with(['disiplina:id,nombre,entrenador:id,nombre'])
                                    ->where('nom_categoria', 'nombre', "%{$txtBuscar}%")
                                    ->get();
        }
        else
            $categorias = Categoria::get();

            return response()->json($categorias, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoriaRequest $request)
    {
        //Insert into categoria values
        $input = $request->all();

        //Y todo recoger el usuario autenticado
        $input['user_id'] = auth()->user()->id;
        $categoria = Categoria::create($input);

        return response()->json(["res" => true, "message" => "Registrado Correcamente"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //select * from categoria where id = $id
        $categoria = Categoria::with(['disiplina:id,nombre'])->findOrFail($id);
        return response()->json($categoria, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update categoria set nombre = $request
        $input = $request->all();
        $categoria = Categoria::find($id);
        $categoria->update($input);

        return response()->json(['res' => true, "message" => "modificado correctamente"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            //delete from categoria where id = $id
            Categoria::destroy($id);
            return \response()->json(['res' => true, 'message' => 'eliminada correctamente'], 200);
        }
        catch(\Exception $e) {
            return \response()->json(['res' => false,'message' => $e->getMessage()], 500);
        }
    }
}
