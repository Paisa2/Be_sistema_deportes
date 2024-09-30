<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

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
        $input['user_id'] = auth()->user()->id;
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
        $producto = Producto::with(['user:id,email,name'])->findOrFail($id);
        return response()->json($producto, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */// Modificar registros de la bd
    public function update(UpdateProductoRequest $request, $id)
    {
        //update producto set nombre = $request_________where id = $id
        $input = $request->all();
        $producto = Producto::find($id);
        $producto->update($input);

        return response()->json(["res" => true, "message" => "Modificado correctamente!"], 200);
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

    //Metodo de incrementar like de producto
    public function setLike($id) {
        $producto = Producto::find($id);
        $producto->like = $producto->like + 1;
        $producto->save();

        return \response()->json(['res' => true, 'message' => 'mas un like'], 200);
    }

    public function setDislike($id) {
        $producto = Producto::find($id);
        $producto->dislike = $producto->dislike + 1;
        $producto->save();

        return \response()->json(['res' => true, 'message' => 'mas un dislike'], 200);
    }

    private function cargarImagen($file, $id)
    {
        $nombreArchivo = time() . "_{$id}." . $file->getClientOriginalExtension();
        $file->move(public_path('imagenes'), $nombreArchivo);
        return $nombreArchivo;
    }

    //Metodo de subir imagen
    public function setImagen(Request $request, $id)
    {
        $producto = Producto::find($id);
        $producto->url_imagen = $this->cargarImagen($request->imagen, $id);
        $producto->save();
        return response()->json(["res" => true, "message" => "Imagen cargada correctamente!"], 200);
    }
}
