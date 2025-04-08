<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interaccion;
use Illuminate\Support\Facades\Validator;


class InteraccionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/interaccion",
     *     summary="Obtener todas las interacciones",
     *     tags={"Interacciones"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de interacciones obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="usuario_id", type="integer", example=5),
     *                 @OA\Property(property="tipo", type="string", example="like"),
     *                 @OA\Property(property="descripcion", type="string", example="El usuario dio like a un post."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-06T14:23:45Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-06T14:25:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="No hay interacciones registradas",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="no hay interacciones registradas")
     *         )
     *     )
     * )
     */


    public function index()
    {
        $interacciones = Interaccion::all();

        if($interacciones->isEmpty()){
            return response()->json(['message' => 'no hay interacciones registradas'] , 400);
        }
        return response()->json($interacciones, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/interaccion",
     *     summary="Crear una nueva interacción",
     *     tags={"Interacciones"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"id_cliente", "id_publicacion"},
     *             @OA\Property(property="id_cliente", type="integer", example=1),
     *             @OA\Property(property="id_publicacion", type="integer", example=10),
     *             @OA\Property(property="fecha_interaccion", type="string", format="date", example="2025-04-06"),
     *             @OA\Property(property="comentarios", type="string", example="Buen contenido"),
     *             @OA\Property(property="calificacion", type="integer", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Interacción creada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Interacción creada exitosamente"),
     *             @OA\Property(property="interaccion", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="id_cliente", type="integer", example=1),
     *                 @OA\Property(property="id_publicacion", type="integer", example=10),
     *                 @OA\Property(property="fecha_interaccion", type="string", example="2025-04-06"),
     *                 @OA\Property(property="comentarios", type="string", example="Buen contenido"),
     *                 @OA\Property(property="calificacion", type="integer", example=5),
     *                 @OA\Property(property="created_at", type="string", example="2025-04-06T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", example="2025-04-06T12:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validación de los datos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al crear interaccion",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error al crear interaccion")
     *         )
     *     )
     * )
     */


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[

            'id_cliente' => 'required|integer|exists:cliente,id',
            'id_publicacion' => 'required|integer|exists:publicaciones,id'


        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }

        $interaccion = Interaccion::create([

            'id_cliente'=> $request->id_cliente,
            'id_publicacion'=> $request->id_publicacion,
            'fecha_interaccion'=> $request->fecha_interaccion,
            'comentarios'=> $request->comentarios,
            'calificacion'=> $request->calificacion

        ]);
        if(!$interaccion){
            $data = [
                'message' => 'Error al crear interaccion',
                'status' => 500
            ];
        return response()->json($data,201);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/interaccion/{id}",
     *     summary="Obtener una interacción por ID",
     *     tags={"Interacciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la interacción",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interacción obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="interaccion", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="id_cliente", type="integer", example=1),
     *                 @OA\Property(property="id_publicacion", type="integer", example=10),
     *                 @OA\Property(property="fecha_interaccion", type="string", format="date", example="2025-04-06"),
     *                 @OA\Property(property="comentarios", type="string", example="Buen contenido"),
     *                 @OA\Property(property="calificacion", type="integer", example=5),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-06T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-06T12:00:00Z")
     *             ),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interacción no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Interaccion no encontrada"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */
    

    public function show($id)
    {
        $interaccion = Interaccion::find($id);

        if(!$interaccion){
            $data= [
                'message' => 'Interaccion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }
        $data = [
            'interaccion' => $interaccion,
            'status' => 200
        ];
        return response()->json($data,200);
    }

    /**
    * @OA\Delete(
    *     path="/api/interaccion/{id}",
    *     summary="Eliminar una interacción por ID",
    *     tags={"Interacciones"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID de la interacción a eliminar",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Interacción eliminada exitosamente",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Interaccion Eliminada"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Interacción no encontrada",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Interaccion no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */

    public function destroy($id)
    {
        $interaccion = Interaccion::find($id);
        if(!$interaccion){
            $data= [
                'message' => 'Interaccion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $interaccion->delete();
        $data= [
            'message' => 'Interaccion Eliminada',
            'status' => 200
        ];
        return response()->json($data,200);
    }

    /**
     * @OA\Put(
     *     path="/api/interaccion/{id}",
     *     summary="Actualizar completamente una interacción por ID",
     *     tags={"Interacciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la interacción a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id_cliente", type="integer", example=1),
     *             @OA\Property(property="id_publicacion", type="integer", example=5),
     *             @OA\Property(property="fecha_interaccion", type="string", format="date", example="2025-04-06"),
     *             @OA\Property(property="comentarios", type="string", example="Muy buena publicación"),
     *             @OA\Property(property="calificacion", type="integer", example=4)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interacción actualizada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Interaccion Actualizada"),
     *             @OA\Property(property="interaccion", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="id_cliente", type="integer", example=1),
     *                 @OA\Property(property="id_publicacion", type="integer", example=5),
     *                 @OA\Property(property="fecha_interaccion", type="string", format="date", example="2025-04-06"),
     *                 @OA\Property(property="comentarios", type="string", example="Muy buena publicación"),
     *                 @OA\Property(property="calificacion", type="integer", example=4),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-06T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-06T12:30:00Z")
     *             ),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validación de los datos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
     *             @OA\Property(property="errors", type="object"),
     *             @OA\Property(property="status", type="integer", example=400)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interacción no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Interaccion no encontrada"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */


    public function update(Request $request, $id)
    {
        $interaccion = Interaccion::find($id);
        if(!$interaccion){
            $data= [
                'message' => 'Interaccion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[

            'id_cliente' => 'required|integer|exists:cliente,id',
            'id_publicacion' => 'required|integer|exists:publicaciones,id'


        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }

        $interaccion -> id_cliente = $request->id_cliente;
        $interaccion -> id_publicacion = $request->id_publicacion;
        $interaccion -> fecha_interaccion = $request->fecha_interaccion;
        $interaccion -> comentarios = $request->comentarios;
        $interaccion -> calificacion = $request->calificacion;

        $interaccion->save();
        $data= [
            'message' => 'Interaccion Actualizada',
            'interaccion' => $interaccion,
            'status' => 200
        ];
        return response()->json($data,200);
    }


    /**
     * @OA\Patch(
     *     path="/api/interaccion/{id}",
     *     summary="Actualizar parcialmente una interacción por ID",
     *     tags={"Interacciones"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la interacción a actualizar parcialmente",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id_cliente", type="integer", example=1),
     *             @OA\Property(property="id_publicacion", type="integer", example=5),
     *             @OA\Property(property="fecha_interaccion", type="string", format="date", example="2025-04-06"),
     *             @OA\Property(property="comentarios", type="string", example="Comentario actualizado"),
     *             @OA\Property(property="calificacion", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Interacción actualizada parcialmente con éxito",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Interaccion Actualizada"),
     *             @OA\Property(property="interaccion", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="id_cliente", type="integer", example=1),
     *                 @OA\Property(property="id_publicacion", type="integer", example=5),
     *                 @OA\Property(property="fecha_interaccion", type="string", format="date", example="2025-04-06"),
     *                 @OA\Property(property="comentarios", type="string", example="Comentario actualizado"),
     *                 @OA\Property(property="calificacion", type="integer", example=3),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-06T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-06T12:30:00Z")
     *             ),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Interacción no encontrada",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Interaccion no encontrada"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */
    

    public function updatePartial(Request $request, $id)
    {
        $interaccion = Interaccion::find($id);
        if(!$interaccion){
            $data= [
                'message' => 'Interaccion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        //Obligatorios al menos uno
        if($request->has('id_cliente')){
            $interaccion-> id_cliente = $request->id_cliente;
        }

        if($request->has('id_publicacion')){
            $interaccion-> id_publicacion = $request->id_publicacion;
        }

        if($request->has('fecha_interaccion')){
            $interaccion-> fecha_interaccion = $request->fecha_interaccion;
        }

        if($request->has('comentarios')){
            $interaccion-> comentarios = $request->comentarios;
        }
        if($request->has('calificacion')){
            $interaccion-> calificacion = $request->calificacion;
        }
       

        $interaccion->save();
        $data = [
            'message' => 'Interaccion Actualizada',
            'interaccion' => $interaccion,
            'status' => 200
        ];

        return response()->json($data,200);
    }
}
