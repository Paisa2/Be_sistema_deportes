<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDisiplinaRequest;
use App\Http\Requests\UpdateDisiplinaRequest;
use App\Models\Disiplina;
use Illuminate\Http\Request;

class DiusiplinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $txtBuscar = "%";
        if($request->has("txtBuscar"))
        {
            $txtBuscar = $request->txtBuscar;
            $disiplinas = Disiplina::with(['user:id,email'])
                        ->whereNombre($txtBuscar)
                        ->orWhere('nombre', 'descripcion', "%{$txtBuscar}%")
                        ->get();
        }
        else
            $disiplinas = Disiplina::with(['user:id,email'])->get();

        return response()->json($disiplinas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDisiplinaRequest $request)
    {
        //
        $input = $request->all();

        $input['user_id'] = auth()->user()->id;
        $disiplina = Disiplina::create($input);

        return response()->json(["res" => true, "message" => "Registrado correctamente"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $disiplina = Disiplina::with(['user:id,email,name'])->findOrFail($id);
        return response()->json($disiplina, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDisiplinaRequest $request, $id)
    {
        $input = $request->all();
        $disiplina = Disiplina::find($id);
        $disiplina->update($input);

        return response()->json(['res' => true, "message" => "Modificadso correctamente!"], 200);
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
            Disiplina::destroy($id);
            return response()->json(['res'=> true, 'message' => 'eliminado correctamente'], 200);
        }
        catch(\Exception $e) {
            return response()->json(['res'=> false,'message' => $e->getMessage()], 500);
        }
    }
}
