<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria_Emprendimiento;
use Illuminate\Support\Facades\Validator;

class Categoria_EmprendimientoController extends Controller
{

    /**
    * @OA\Get(
    *     path="/api/categoria_emprendimiento",
    *     summary="Obtener todas las categorías de emprendimiento",
    *     tags={"Categorías de Emprendimiento"},
    *     @OA\Response(
    *         response=200,
    *         description="Lista de categorías obtenida exitosamente",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(
    *                 type="object",
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="nombre", type="string", example="Tecnología"),
    *                 @OA\Property(property="descripcion", type="string", example="Emprendimientos tecnológicos")
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="No hay categorías registradas",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="no hay categorias registradas")
    *         )
    *     )
    * )
    */

    public function index()
    {
        $categorias = Categoria_Emprendimiento::all();

        if($categorias->isEmpty()){
            return response()->json(['message' => 'no hay categorias registradas'] , 400);
        }
        return response()->json($categorias, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/categoria_emprendimiento",
     *     summary="Crear una nueva categoría de emprendimiento",
     *     tags={"Categorías de Emprendimiento"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"estado", "nombre"},
     *             @OA\Property(property="estado", type="string", example="activo"),
     *             @OA\Property(property="nombre", type="string", example="Tecnología"),
     *             @OA\Property(property="descripcion", type="string", example="Emprendimientos tecnológicos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Categoría creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoría creada con éxito"),
     *             @OA\Property(property="categoria", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="estado", type="string", example="activo"),
     *                 @OA\Property(property="nombre", type="string", example="Tecnología"),
     *                 @OA\Property(property="descripcion", type="string", example="Emprendimientos tecnológicos")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validación de los datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error en la validación de los datos"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al crear categoría",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error al crear categoría")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            
            'estado' => 'required',
            'nombre' => 'required'

        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }
        $categoria_emprendimiento = Categoria_Emprendimiento::create([

            'estado'=> $request->estado,
            'descripcion'=> $request->descripcion,
            'nombre'=> $request->nombre

        ]);
        if(!$categoria_emprendimiento){
            $data = [
                'message' => 'Error al crear categoria ',
                'status' => 500
            ];
        return response()->json($data,201);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/categoria_emprendimiento/{id}",
     *     summary="Obtener una categoría de emprendimiento por ID",
     *     tags={"Categorías de Emprendimiento"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría de emprendimiento",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="categoria_emprendimiento", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="estado", type="string", example="activo"),
     *                 @OA\Property(property="nombre", type="string", example="Tecnología"),
     *                 @OA\Property(property="descripcion", type="string", example="Emprendimientos tecnológicos")
     *             ),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoria no encontrada"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */

    public function show($id)
    {
        $categoria_emprendimiento = Categoria_Emprendimiento::find($id);

        if(!$categoria_emprendimiento){
            $data= [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }
        $data = [
            'categoria_emprendimiento' => $categoria_emprendimiento,
            'status' => 200
        ];
        return response()->json($data,200);
    }

    /**
     * @OA\Delete(
     *     path="/api/categoria_emprendimiento/{id}",
     *     summary="Eliminar una categoría de emprendimiento",
     *     tags={"Categorías de Emprendimiento"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría de emprendimiento a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría eliminada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoría Eliminada"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoria no encontrada"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */

    public function destroy($id)
    {
        $categoria_emprendimiento = Categoria_Emprendimiento::find($id);
        if(!$categoria_emprendimiento){
            $data= [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $categoria_emprendimiento->delete();
        $data= [
            'message' => 'Categoria Eliminada',
            'status' => 200
        ];
        return response()->json($data,200);
    }

    /**
     * @OA\Put(
     *     path="/api/categoria_emprendimiento/{id}",
     *     summary="Actualizar una categoría de emprendimiento",
     *     tags={"Categorías de Emprendimiento"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría de emprendimiento a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"estado", "nombre"},
     *             @OA\Property(property="estado", type="string", example="activo"),
     *             @OA\Property(property="nombre", type="string", example="Tecnología"),
     *             @OA\Property(property="descripcion", type="string", example="Emprendimientos tecnológicos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoría Actualizada"),
     *             @OA\Property(property="categoria_emprendimiento", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validación de los datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error en la validación de los datos"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoria no encontrada")
     *         )
     *     )
     * )
     */    

    public function update(Request $request, $id)
    {
        $categoria_emprendimiento = Categoria_Emprendimiento::find($id);
        if(!$categoria_emprendimiento){
            $data= [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[
            
            'estado' => 'required',
            'nombre' => 'required',

        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }

       
        $categoria_emprendimiento -> estado = $request->estado;
        $categoria_emprendimiento -> descripcion = $request->descripcion;
        $categoria_emprendimiento -> nombre = $request->nombre;

        $categoria_emprendimiento->save();
        $data= [
            'message' => 'Categoria Actualizada',
            'categoria_emprendimiento' => $categoria_emprendimiento,
            'status' => 200
        ];
        return response()->json($data,200);
    }
    
    /**
     * @OA\Patch(
     *     path="/api/categoria_emprendimiento/{id}",
     *     summary="Actualizar parcialmente una categoría de emprendimiento",
     *     tags={"Categorías de Emprendimiento"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la categoría de emprendimiento a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="estado", type="string", maxLength=2, example="A"),
     *             @OA\Property(property="nombre", type="string", maxLength=255, example="Tecnología"),
     *             @OA\Property(property="descripcion", type="string", maxLength=500, example="Emprendimientos tecnológicos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categoría actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoría Actualizada"),
     *             @OA\Property(property="categoria_emprendimiento", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Categoría no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Categoria no encontrada")
     *         )
     *     )
     * )
     */

    public function updatePartial(Request $request, $id)
    {
        $categoria_emprendimiento = Categoria_Emprendimiento::find($id);
        if(!$categoria_emprendimiento){
            $data= [
                'message' => 'Categoria no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[

            'estado' => 'max:2',
            'descripcion' => 'max:500',
            'nombre' => 'max:255'

        ]);

        if ($request->has('nombre')) {
            $categoria_emprendimiento->nombre = $request->nombre;
        }
    
        if ($request->has('descripcion')) {
            $categoria_emprendimiento->descripcion = $request->descripcion;
        }

        if ($request->has('estado')) {
            $categoria_emprendimiento->estado = $request->estado;
        }
    
        $categoria_emprendimiento->save();
        $data = [
            'message' => 'Categoria Actualizada',
            'categoria_emprendimiento' => $categoria_emprendimiento,
            'status' => 200
        ];

        return response()->json($data,200);
    }
}
