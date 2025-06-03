<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Support\Facades\Validator;



class PublicacionesController extends Controller
{
 
    /**
     * @OA\Get(
     *     path="/api/publicaciones",
     *     summary="Obtener todas las publicaciones",
     *     tags={"Publicaciones"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de publicaciones obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="id_emprendimiento", type="integer", example=2),
     *                 @OA\Property(property="titulo", type="string", example="Lanzamiento de nuevo producto"),
     *                 @OA\Property(property="descripcion", type="string", example="Estamos emocionados de lanzar nuestro nuevo producto."),
     *                 @OA\Property(property="imagen", type="string", example="https://ejemplo.com/imagen.jpg"),
     *                 @OA\Property(property="fecha_publicacion", type="string", format="date", example="2025-04-06"),
     *                 @OA\Property(property="estado", type="string", example="activo"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-06T10:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-06T10:15:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="No hay publicaciones registradas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="no hay publicaciones registradas")
     *         )
     *     )
     * )
     */


    public function index()
    {
        $publicaciones = Publicacion::all();

        if($publicaciones->isEmpty()){
            $data = [
                'status' => 'error',
                'message' => 'no hay publicaciones registradas',
                'code' => 400,
                'data' => null
            ];
            return response()->json($data, 400);
        }

        $data = [
            'status' => 'success',
            'message' => 'Lista de publicaciones',
            'code' => 200,
            'data' => $publicaciones
        ];
        return response()->json($data, 200);
    }

    /**
    * @OA\Post(
    *     path="/api/publicaciones",
    *     summary="Crear una nueva publicación",
    *     tags={"Publicaciones"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"titulo", "estado"},
    *             @OA\Property(property="titulo", type="string", example="Nueva feria artesanal"),
    *             @OA\Property(property="descripcion", type="string", example="Evento local con productos hechos a mano"),
    *             @OA\Property(property="imagen_url", type="string", format="url", example="https://example.com/imagen.jpg"),
    *             @OA\Property(property="id_emprendimiento", type="integer", example=5),
    *             @OA\Property(property="id_feria", type="integer", example=3),
    *             @OA\Property(property="fecha_publicacion", type="string", format="date-time", example="2025-04-06T14:00:00Z"),
    *             @OA\Property(property="estado", type="string", example="activa")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Publicación creada con éxito",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Publicación creada"),
    *             @OA\Property(property="status", type="integer", example=201)
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de los datos",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
    *             @OA\Property(property="errors", type="object"),
    *             @OA\Property(property="status", type="integer", example=400)
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error al crear publicación",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error al crear publicacion"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'titulo' => 'required',
            'estado' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'status' => 'error',
                'message' => 'Error en la validacion de los datos',
                'code' => 400,
                'data' => $validator->errors(),
            ];
            return response()->json($data, 400); 
        }
        $publicacion = Publicacion::create([
            'titulo'=> $request->titulo,
            'descripcion'=> $request->descripcion,
            'imagen_url'=> $request->imagen_url,
            'id_emprendimiento'=> $request->id_emprendimiento,
            'id_feria'=> $request->id_feria,
            'fecha_publicacion'=> $request->fecha_publicacion,
            'estado'=> $request->estado

        ]);
        if(!$publicacion){
            $data = [
                'status' => 'error',
                'message' => 'Error al crear publicacion',
                'code' => 500,
                'data' => null
            ];
        return response()->json($data,500);
        }

        $data = [
            'message' => 'Publicación creada',
            'status' => 201,
            'publicacion' => $publicacion
        ];
        return response()->json($data, 201);
    }

    /**
    * @OA\Get(
    *     path="/api/publicaciones/{id}",
    *     summary="Obtener una publicación por ID",
    *     tags={"Publicaciones"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID de la publicación",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Publicación encontrada",
    *         @OA\JsonContent(
    *             @OA\Property(property="publicacion", type="object"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Publicación no encontrada",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Publicacion no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */

    public function show($id)
    {
        $publicacion = Publicacion::find($id);

        if(!$publicacion){
            $data= [
                'status' => 'error',
                'message' => 'Publicacion no encontrada',
                'code' => 404,
                'data' => null
            ];
        return response()->json($data,404);
        }
        $data = [
            'status' => 'success',
            'message' => 'Publicacion encontrada',
            'code' => 200,
            'data' => $publicacion
        ];
        return response()->json($data,200);
    }

    /**
    * @OA\Delete(
    *     path="/api/publicaciones/{id}",
    *     summary="Eliminar una publicación por ID",
    *     tags={"Publicaciones"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID de la publicación a eliminar",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Publicación eliminada",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Publicacion Eliminada"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Publicación no encontrada",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Publicacion no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */

    public function destroy($id)
    {
        $publicacion = Publicacion::find($id);
        if(!$publicacion){
            $data= [
                'status' => 'error',
                'message' => 'Publicacion no encontrada',
                'code' => 404,
                'data' => null
            ];
        return response()->json($data,404);
        }

        $publicacion->delete();
        $data= [
            'status' => 'success',
            'message' => 'Publicacion Eliminada',
            'code' => 200,
            'data' => null
        ];
        return response()->json($data,200);
    }

    /**
    * @OA\Put(
    *     path="/api/publicaciones/{id}",
    *     summary="Actualizar completamente una publicación",
    *     tags={"Publicaciones"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID de la publicación a actualizar",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"titulo", "estado"},
    *             @OA\Property(property="titulo", type="string", example="Nuevo título de publicación"),
    *             @OA\Property(property="descripcion", type="string", example="Descripción actualizada"),
    *             @OA\Property(property="imagen_url", type="string", example="http://imagen.com/foto.jpg"),
    *             @OA\Property(property="id_emprendimiento", type="integer", example=2),
    *             @OA\Property(property="id_feria", type="integer", example=1),
    *             @OA\Property(property="fecha_publicacion", type="string", format="date", example="2025-04-06"),
    *             @OA\Property(property="estado", type="string", example="A")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Publicación actualizada exitosamente",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Publicacion Actualizada"),
    *             @OA\Property(property="publicacion", type="object"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de datos",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
    *             @OA\Property(property="errors", type="object"),
    *             @OA\Property(property="status", type="integer", example=400)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Publicación no encontrada",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Publicacion no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */

    public function update(Request $request, $id)
    {
        $publicacion = Publicacion::find($id);
        if(!$publicacion){
            $data= [
                'status' => 'error',
                'message' => 'Publicacion no encontrada',
                'code' => 404,
                'data' => null
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[
            'titulo' => 'required',
            'estado' => 'required'

        ]);

        if ($validator->fails()){
            $data = [
                'status' => 'error',
                'message' => 'Error en la validacion de los datos',
                'code' => 400,
                'data' => $validator->errors(),
            ];
            return response()->json($data, 400);
        }

        $publicacion -> titulo = $request->titulo;
        $publicacion -> descripcion = $request->descripcion;
        $publicacion -> imagen_url = $request->imagen_url;
        $publicacion -> id_emprendimiento = $request->id_emprendimiento;
        $publicacion -> id_feria = $request->id_feria;
        $publicacion -> fecha_publicacion = $request->fecha_publicacion;
        $publicacion -> estado = $request->estado;

        $publicacion->save();
        $data= [
            'status' => 'success',
            'message' => 'Publicacion Actualizada',
            'code' => 200,
            'data' => $publicacion
        ];
        return response()->json($data,200);
    }

    /**
    * @OA\Patch(
    *     path="/api/publicaciones/{id}",
    *     summary="Actualizar parcialmente una publicación",
    *     tags={"Publicaciones"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID de la publicación a actualizar",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\RequestBody(
    *         required=false,
    *         @OA\JsonContent(
    *             @OA\Property(property="titulo", type="string", maxLength=255, example="Título actualizado"),
    *             @OA\Property(property="descripcion", type="string", maxLength=500, example="Descripción parcial"),
    *             @OA\Property(property="imagen_url", type="string", maxLength=255, example="http://example.com/nueva-imagen.jpg"),
    *             @OA\Property(property="id_emprendimiento", type="integer", example=5),
    *             @OA\Property(property="id_feria", type="integer", example=2),
    *             @OA\Property(property="fecha_publicacion", type="string", format="date", example="2025-04-06"),
    *             @OA\Property(property="estado", type="string", maxLength=2, example="A")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Publicación actualizada parcialmente",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Publicacion Actualizado"),
    *             @OA\Property(property="publicacion", type="object"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de datos",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
    *             @OA\Property(property="errors", type="object"),
    *             @OA\Property(property="status", type="integer", example=400)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Publicación no encontrada",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Publicacion no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */


    public function updatePartial(Request $request, $id)
    {
        $publicacion = Publicacion::find($id);
        if(!$publicacion){
            $data= [
                'status' => 'error',
                'message' => 'Publicacion no encontrada',
                'code' => 404,
                'data' => null
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[

            'titulo' => 'max:255',
            'descripcion' => 'max:500',
            'imagen_url' => 'max:255',
            'id_emprendimiento' => 'integer',
            'id_feria' => 'integer',
            'fecha_publicacion' => 'date',
            'estado' => 'max:2'

        ]);

        if ($request->has('titulo')) {
            $publicacion->titulo = $request->titulo;
        }
    
        if ($request->has('descripcion')) {
            $publicacion->descripcion = $request->descripcion;
        }
    
        if ($request->has('imagen_url')) {
            $publicacion->imagen_url = $request->imagen_url;
        }
    
        if ($request->has('id_emprendimiento')) {
            $publicacion->id_emprendimiento = $request->id_emprendimiento;
        }
    
        if ($request->has('id_feria')) {
            $publicacion->id_feria = $request->id_feria;
        }
    
        if ($request->has('fecha_publicacion')) {
            $publicacion->fecha_publicacion = $request->fecha_publicacion;
        }
    
        if ($request->has('estado')) {
            $publicacion->estado = $request->estado;
        }
    
        $publicacion->save();
        $data = [
            'status' => 'success',
            'message' => 'Publicacion Actualizado',
            'code' => 200,
            'data' => $publicacion
        ];

        return response()->json($data,200);
    }
}
