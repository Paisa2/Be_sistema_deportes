<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEntrenadorRequest;
use App\Http\Requests\UpdateEntrenadorRequest;
use App\Models\Entrenador;
use Illuminate\Http\Request;

class EntrenadorController extends Controller
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
            $entrenadores = Entrenador::with(["user:id,nombre"])
                            ->whereNombre($txtBuscar)
                            ->orWhere('nombre', 'apellido', 'edad', 'archivo', "%{$txtBuscar}%")
                            ->get();
        }
        else
            $entrenadores = Entrenador::get();

            return response()->json($entrenadores, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateEntrenadorRequest $request)
    {
        $input = $request->all();

        $input['user_id'] = auth()->user()->id;
        $entrenadores = Entrenador::create($input);

        return response()->json(["res" => true, "massage" => "Resgistrado correctamente"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $entrenador = Entrenador::with(['disiplina:id,nombre, categorias:id,nom_categoria'])->findOrFail($id);
        return response()->json($entrenador, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEntrenadorRequest $request, $id)
    {
        $input = $request->all();
        $entrenador = Entrenador::find($id);
        $entrenador->update($input);

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
            Entrenador::destroy($id);
            return response()->json(['res'=> true, 'message' => 'Eliminado correctamente'], 200);
        }
        catch(\Exception $e) {
            return response()->json(['res' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
