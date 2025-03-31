<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria_producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Info(
 *     title="API de Categorías de Productos",
 *     version="1.0.0",
 *     description="API para gestionar categorías de productos"
 * )
 */

class catproducto_Controller extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/categoria_productos",
    *     summary="Obtener todas las categorías de productos",
    *     tags={"Categorías de Productos"},
    *     @OA\Response(
    *         response=200,
    *         description="Lista de categorías de productos",
    *         @OA\JsonContent(
    *          type="object",
    *             @OA\Property(property="categoria de productos", type="array",
    *                 @OA\Items(type="object",
    *                     @OA\Property(property="id_cat", type="integer", example=1),
    *                     @OA\Property(property="estado", type="char", example="AC"),
    *                     @OA\Property(property="descripcion", type="text", example="Productos electrónicos para el hogar"),
    *                     @OA\Property(property="nombre", type="string", example="Electrodomésticos"),
    *                 )
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     )
    * )
    */
    public function index(){

        $catProducto = Categoria_producto::all();

        $data = [
            'categoria de productos' => $catProducto,
            'status' => 200
        ];
        
        return response()->json($data, 200);
    }

    /**
    * @OA\Get(
    *     path="/api/categoria_productos/{nombre}",
    *     summary="Obtener una categoría de producto por nombre",
    *     tags={"Categorías de Productos"},
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         required=true,
    *         description="Nombre de la categoría de producto",
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Categoría de producto encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Categoria de producto", type="object",
    *                 @OA\Property(property="id_cat", type="integer", example=1),
    *                 @OA\Property(property="estado", type="char", example="AC"),
    *                 @OA\Property(property="descripcion", type="text", example="Productos electrónicos para el hogar"),
    *                 @OA\Property(property="nombre", type="string", example="Electrodomésticos"),
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Categoría no encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Categoria no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function show($nombre){
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

    /**
    * @OA\Post(
    *     path="/api/categoria_productos",
    *     summary="Crear una nueva categoría de producto",
    *     tags={"Categorías de Productos"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"estado", "nombre"},
    *             @OA\Property(property="estado", type="char", enum={"AC", "IN"}, example="AC"),
    *             @OA\Property(property="descripcion", type="text", example="Productos electrónicos para el hogar"),
    *             @OA\Property(property="nombre", type="string", example="Electrodomésticos")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Categoría de producto creada correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Categoria producto", type="object",
    *                 @OA\Property(property="estado", type="char", example="AC"),
    *                 @OA\Property(property="descripcion", type="text", example="Productos electrónicos para el hogar"),
    *                 @OA\Property(property="nombre", type="string", example="Electrodomésticos"),
    *                 @OA\Property(property="id_cat", type="integer", example=1)
    *             ),
    *             @OA\Property(property="status", type="integer", example=201)
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de datos",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Error en la base de datos"),
    *             @OA\Property(property="Error", type="object",
    *                 @OA\Property(property="nombre", type="array",
    *                     @OA\Items(type="string", example="El campo nombre ya ha sido utilizado")
    *                 )
    *             ),
    *             @OA\Property(property="status", type="integer", example=400)
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error al crear la categoria de producto",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Error al crear la categoria de producto"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function store(Request $request){

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

    /**
    * @OA\Delete(
    *     path="/api/categoria_productos/{nombre}",
    *     summary="Eliminar una categoría de producto por nombre",
    *     tags={"Categorías de Productos"},
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         required=true,
    *         description="Nombre de la categoría de producto",
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Categoría eliminada correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Categoria de producto", type="string", example="eliminada"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Categoría no encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Categoria no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function destroy($nombre){
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

    /**
    * @OA\Put(
    *     path="/api/categoria_productos/{nombre}",
    *     summary="Actualizar una categoría de producto por nombre",
    *     tags={"Categorías de Productos"},
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         required=true,
    *         description="Nombre de la categoría de producto",
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"estado"},
    *             @OA\Property(property="estado", type="char", enum={"AC", "IN"}, example="AC"),
    *             @OA\Property(property="descripcion", type="text", example="Productos electrónicos para el hogar")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Categoría actualizada correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="categoria de producto actualizada"),
    *             @OA\Property(property="Categoria de producto", type="object",
    *                 @OA\Property(property="id_cat", type="integer", example=1),
    *                 @OA\Property(property="estado", type="char", example="AC"),
    *                 @OA\Property(property="descripcion", type="text", example="Productos electrónicos para el hogar"),
    *                 @OA\Property(property="nombre", type="string", example="Electrodomésticos"),
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Categoría no encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Categoria no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de datos",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Error en la base de datos"),
    *             @OA\Property(property="Error", type="object",
    *                 @OA\Property(property="nombre", type="array",
    *                     @OA\Items(type="string", example="El campo nombre ya ha sido utilizado")
    *                 )
    *             ),
    *             @OA\Property(property="status", type="integer", example=400)
    *         )
    *     )
    * )
    */
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

    /**
    * @OA\Patch(
    *     path="/api/categoria_productos/{nombre}",
    *     summary="Actualizar parcialmente una categoría de producto por nombre",
    *     tags={"Categorías de Productos"},
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         required=true,
    *         description="Nombre de la categoría de producto",
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             @OA\Property(property="estado", type="char", enum={"AC", "IN"}, example="AC"),
    *             @OA\Property(property="descripcion", type="text", example="Productos electrónicos para el hogar")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Categoría actualizada parcialmente correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="categoria de producto actualizada"),
    *             @OA\Property(property="Categoria de producto", type="object",
    *                 @OA\Property(property="id_cat", type="integer", example=1),
    *                 @OA\Property(property="estado", type="char", example="AC"),
    *                 @OA\Property(property="descripcion", type="text", example="Productos electrónicos para el hogar"),
    *                 @OA\Property(property="nombre", type="string", example="Electrodomésticos"),
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Categoría no encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Categoria no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de datos",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Error en la base de datos"),
    *             @OA\Property(property="Error", type="object",
    *                 @OA\Property(property="nombre", type="array",
    *                     @OA\Items(type="string", example="El campo nombre ya ha sido utilizado")
    *                 )
    *             ),
    *             @OA\Property(property="status", type="integer", example=400)
    *         )
    *     )
    * )
    */
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