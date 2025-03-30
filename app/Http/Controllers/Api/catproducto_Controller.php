<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria_producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class catproducto_Controller extends Controller
{
    public function getAll(){

        $catProducto = Categoria_producto::all();

        $data = [
            'categoria de productos' => $catProducto,
            'status' => 200
        ];
        
        return response()->json($data, 200);
    }
    
    public function getName($nombre){
        $catProducto = Categoria_producto::where('nombre',$nombre)->first();

        if (!$catProducto) {
            $data = [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'Categoria de producto' => $catProducto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function add(Request $request){

        $validar = Validator::make($request->all(),[
            'estado' => 'required|in:AC,IN',
            'descripcion' => 'nullable',
            'nombre' => 'required|max:255|unique:categoria_producto'
        ]);

        if ($validar -> fails()) {
            $data = [
                'message' => 'Error en la base de datos',
                'Error' => $validar->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $catProducto = Categoria_producto::create([
            'estado' => $request->estado,
            'descripcion'=> $request->descripcion,
            'nombre'=> $request->nombre
        ]);

        if (!$catProducto) {
            $data = [
                'message' => 'Error al crear la categoria de producto',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'Categoria producto' => $catProducto,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function delete($nombre){
        $catProducto = Categoria_producto::where('nombre',$nombre)->first();

        if (!$catProducto) {
            $data = [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $catProducto->delete();

        $data = [
            'Categoria de producto' => 'eliminada',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $nombre){
        $catProducto = Categoria_producto::where('nombre',$nombre)->first();

        if (!$catProducto) {
            $data = [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validar = Validator::make($request->all(), [
            'estado' => 'required|in:AC,IN',
            'descripcion' => 'nullable'
        ]);

        if ($validar -> fails()) {
            $data = [
                'message' => 'Error en la base de datos',
                'Error' => $validar->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $catProducto->estado = $request->estado;
        $catProducto->descripcion = $request->descripcion;

        $catProducto->save();

        $data = [
            'message' => 'categoria de producto actualizada',
            'Categoria de producto' => $catProducto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $nombre){
        $catProducto = Categoria_producto::where('nombre',$nombre)->first();

        if (!$catProducto) {
            $data = [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validar = Validator::make($request->all(), [
            'estado' => 'in:AC,IN',
            'descripcion' => 'nullable'
        ]);

        if ($validar -> fails()) {
            $data = [
                'message' => 'Error en la base de datos',
                'Error' => $validar->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        if ($request->has('estado')) {
            $catProducto->estado = $request->estado;
        }

        if ($request->has('descripcion')) {
            $catProducto->descripcion = $request->descripcion;
        }

        $catProducto->save();

        $data = [
            'message' => 'categoria de producto actualizada',
            'Categoria de producto' => $catProducto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}