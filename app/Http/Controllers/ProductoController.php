<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProductoRequest;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *///Sirve para listar buscar informacion de una tabla
    public function index(Request $request)
    {


        //select * from producto inme (DMR laravel ELOQUENT)
        // $productos = Producto::with(['user:id,email,name'])->paginate(10);

        //select * from producto where nombre like  "%par%"

        $txtBuscar = "%";
        if($request->has("txtBuscar"))
        {
            $txtBuscar = $request->txtBuscar;
            $productos = Producto::with(['user:id,email'])
                            ->whereCodigo($txtBuscar)
                            ->orWhere('nombre', 'like', "%{$txtBuscar}%")
                            ->orderBy('precio')
                            ->get();
        }
        else
            $productos = Producto::with(['user:id,email'])->get();

        return response()->json($productos, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Insertar nuevos registros
    public function store(CreateProductoRequest $request)
    {
        //insert into productos values {_________}
        $input = $request->all();

        //V todo recoger el usuario autenticado
        $input['user_id'] = 1;
        $producto = Producto::create($input);

        return response()->json(["res" => true, "message" => "Registrado correctamente!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //recoger un solo registro de la bdd
    public function show($id)
    {
        //selec * from producto where id = $id
        $producto = Producto::with(['user:id,email,name'])->find($id);
        return $producto;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Sirve para eliminar registro
    public function destroy($id)
    {
        try {
        //delete from productos where id = $id
        Producto::destroy($id);
        return \response()->json(['res' => true, 'message' => 'eliminado correctamente'], 200);
        }
        catch(\Exception $e) {
            return \response()->json(['res' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
