<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class feria_Controller extends Controller
{

    /**
    * @OA\Get(
    *     path="/api/feria",
    *     summary="Obtener todas las ferias",
    *     tags={"feria"},
    *     @OA\Response(
    *         response=200,
    *         description="Lista de ferias",
    *         @OA\JsonContent(
    *          type="object",
    *             @OA\Property(property="Ferias", type="array",
    *                 @OA\Items(type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Feria de Tecnología"),
    *                     @OA\Property(property="descripcion", type="text", example="Feria de tecnología y ciencia"),
    *                     @OA\Property(property="fecha_inicio", type="data", format="date-time", example="2023-10-01"),
    *                     @OA\Property(property="fecha_fin", type="data", format="date-time", example="2023-10-05"),
    *                     @OA\Property(property="modalidad", type="string", example="virtual"),
    *                     @OA\Property(property="localidad", type="string", example="Lima"),
    *                     @OA\Property(property="estado", type="string", example="próxima")
    *                 )
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     )
    * )
    */
    public function index()
    {
        $feria = Feria::all();

        $data = [
            'status' => 'success',
            'message' => 'Lista de ferias obtenida correctamente',
            'code' => 200,
            'data' => $feria
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Get(
    *     path="/api/feria/{id}",
    *     summary="Obtener una feria por ID",
    *     tags={"feria"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de la feria",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Feria encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="feria", type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Feria de Tecnología"),
    *                     @OA\Property(property="descripcion", type="text", example="Feria de tecnología y ciencia"),
    *                     @OA\Property(property="fecha_inicio", type="data", format="date-time", example="2023-10-01"),
    *                     @OA\Property(property="fecha_fin", type="data", format="date-time", example="2023-10-05"),
    *                     @OA\Property(property="modalidad", type="string", example="virtual"),
    *                     @OA\Property(property="localidad", type="string", example="Lima"),
    *                     @OA\Property(property="estado", type="string", example="próxima")
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Feria no encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function show($id)
    {
        $feria = Feria::find($id);

        if (!$feria) {
            $data = [
                'status' => 'error',
                'message' => 'Feria no encontrada',
                'code' => 404,
                'data' => null
            ];

            return response()->json($data, 404);
        }

        $data = [
            'status' => 'success',
            'message' => 'Feria encontrada correctamente',
            'code' => 200,
            'data' => $feria
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Post(
    *     path="/api/feria",
    *     summary="Crear una nueva feria",
    *     tags={"feria"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"nombre", "fecha_inicio", "fecha_fin", "modalidad", "estado"},
    *                     @OA\Property(property="nombre", type="string", example="Feria de Tecnología"),
    *                     @OA\Property(property="descripcion", type="text", example="Feria de tecnología y ciencia"),
    *                     @OA\Property(property="fecha_inicio", type="data", format="date-time", example="2023-10-01"),
    *                     @OA\Property(property="fecha_fin", type="data", format="date-time", example="2023-10-05"),
    *                     @OA\Property(property="modalidad", type="string", example="virtual"),
    *                     @OA\Property(property="localidad", type="string", example="Lima"),
    *                     @OA\Property(property="estado", type="string", example="próxima")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Feria creada correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Feria", type="object",
    *                     @OA\Property(property="nombre", type="string", example="Feria de Tecnología"),
    *                     @OA\Property(property="descripcion", type="text", example="Feria de tecnología y ciencia"),
    *                     @OA\Property(property="fecha_inicio", type="data", format="date-time", example="2023-10-01"),
    *                     @OA\Property(property="fecha_fin", type="data", format="date-time", example="2023-10-05"),
    *                     @OA\Property(property="modalidad", type="string", example="virtual"),
    *                     @OA\Property(property="localidad", type="string", example="Lima"),
    *                     @OA\Property(property="estado", type="string", example="próxima"),
    *                     @OA\Property(property="id", type="integer", example=1)
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
    *         description="Error al crear la feria",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Error al crear la feria"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'modalidad' => 'required|in:virtual,presencial',
            'localidad' => 'nullable|string|max:255',
            'estado' => 'required|in:próxima,en curso,finalizada'
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 'error',
                'message' => 'Error en la base de datos',
                'code' => 400,
                'data' => $validator->errors(),
            ];

            return response()->json($data, 400);
        }

        $feria = Feria::create($request->all());

        if (!$feria) {
            $data = [
                'status' => 'error',
                'message' => 'Error al crear la feria',
                'code' => 500,
                'data' => null
            ];

            return response()->json($data, 500);
        }

        $data = [
            'status' => 'success',
            'message' => 'Feria creada correctamente',
            'code' => 201,
            'data' => $feria
        ];

        return response()->json($data, 201);
    }

    /**
    * @OA\Delete(
    *     path="/api/feria/{id}",
    *     summary="Eliminar una feria por ID",
    *     tags={"feria"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de la feria",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Feria eliminada correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="feria", type="string", example="eliminada"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Feria no encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria no encontrada"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function destroy($id)
    {
        $feria = Feria::find($id);

        if (!$feria) {
            $data = [
                'status' => 'error',
                'message' => 'Feria no encontrada',
                'code' => 404,
                'data' => null
            ];

            return response()->json($data, 404);
        }

        $feria->delete();

        $data = [
            'status' => 'success',
            'message' => 'Feria eliminada correctamente',
            'code' => 200,
            'data' => null
        ];

        return response()->json($data, 200);
    }
    
    /**
    * @OA\Put(
    *     path="/api/feria/{id}",
    *     summary="actualizar una feria por ID",
    *     tags={"feria"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de la feria",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *             required=true,
    *             @OA\JsonContent(
    *                     required={"nombre", "fecha_inicio", "fecha_fin", "modalidad", "estado"},
    *                     @OA\Property(property="nombre", type="string", example="Feria de Tecnología"),
    *                     @OA\Property(property="descripcion", type="text", example="Feria de tecnología y ciencia"),
    *                     @OA\Property(property="fecha_inicio", type="data", format="date-time", example="2023-10-01"),
    *                     @OA\Property(property="fecha_fin", type="data", format="date-time", example="2023-10-05"),
    *                     @OA\Property(property="modalidad", type="string", example="virtual"),
    *                     @OA\Property(property="localidad", type="string", example="Lima"),
    *                     @OA\Property(property="estado", type="string", example="próxima")
    *             )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Feria actualizada correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria actualizada correctamente"),
    *             @OA\Property(property="Feria", type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Feria de Tecnología"),
    *                     @OA\Property(property="descripcion", type="text", example="Feria de tecnología y ciencia"),
    *                     @OA\Property(property="fecha_inicio", type="data", format="date-time", example="2023-10-01"),
    *                     @OA\Property(property="fecha_fin", type="data", format="date-time", example="2023-10-05"),
    *                     @OA\Property(property="modalidad", type="string", example="virtual"),
    *                     @OA\Property(property="localidad", type="string", example="Lima"),
    *                     @OA\Property(property="estado", type="string", example="próxima")
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Feria no encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria no encontrada"),
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
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error al actualizar la feria",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="error al actualizar la feria"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function update(Request $request, $id)
    {
        $feria = Feria::find($id);

        if (!$feria) {
            $data = [
                'status' => 'error',
                'message' => 'Feria no encontrada',
                'code' => 404,
                'data' => null
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'modalidad' => 'required|in:virtual,presencial',
            'localidad' => 'nullable|string|max:255',
            'estado' => 'required|in:próxima,en curso,finalizada'
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 'error',
                'message' => 'Error en la base de datos',
                'code' => 400,
                'data' => $validator->errors()
            ];

            return response()->json($data, 400);
        }

        $feria->update($request->all());

        if (!$feria) {
            $data = [
                'status' => 'error',
                'message' => 'Error al actualizar la feria',
                'code' => 500,
                'data' => null
            ];

            return response()->json($data, 500);
        }

        $data = [
            'status' => 'success',
            'message' => 'Feria actualizada correctamente',
            'code' => 200,
            'data' => $feria
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Patch(
    *     path="/api/feria/{id}",
    *     summary="Actualizar parcialmente una feria por ID",
    *     tags={"feria"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de la feria",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *                     @OA\Property(property="nombre", type="string", example="Feria de Tecnología"),
    *                     @OA\Property(property="descripcion", type="text", example="Feria de tecnología y ciencia"),
    *                     @OA\Property(property="fecha_inicio", type="data", format="date-time", example="2023-10-01"),
    *                     @OA\Property(property="fecha_fin", type="data", format="date-time", example="2023-10-05"),
    *                     @OA\Property(property="modalidad", type="string", example="virtual"),
    *                     @OA\Property(property="localidad", type="string", example="Lima"),
    *                     @OA\Property(property="estado", type="string", example="próxima")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Feria actualizada correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria actualizada correctamente"),
    *             @OA\Property(property="Feria", type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Feria de Tecnología"),
    *                     @OA\Property(property="descripcion", type="text", example="Feria de tecnología y ciencia"),
    *                     @OA\Property(property="fecha_inicio", type="data", format="date-time", example="2023-10-01"),
    *                     @OA\Property(property="fecha_fin", type="data", format="date-time", example="2023-10-05"),
    *                     @OA\Property(property="modalidad", type="string", example="virtual"),
    *                     @OA\Property(property="localidad", type="string", example="Lima"),
    *                     @OA\Property(property="estado", type="string", example="próxima")
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Feria no encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria no encontrada"),
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
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error al actualizar la feria",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="error al actualizar la feria"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function updatePartial(Request $request, $id)
    {
        $feria = Feria::find($id);

        if (!$feria) {
            $data = [
                'status' => 'error',
                'message' => 'Feria no encontrada',
                'code' => 404,
                'data' => null
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'string|max:255',
            'descripcion' => 'string',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date|after_or_equal:fecha_inicio',
            'modalidad' => 'in:virtual,presencial',
            'localidad' => 'string|max:255',
            'estado' => 'in:próxima,en curso,finalizada'
        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 'error',
                'message' => 'Error en la base de datos',
                'code' => 400,
                'data' => $validator->errors()
            ];

            return response()->json($data, 400);
        }

        $feria->update($request->only('nombre', 'descripcion', 'fecha_inicio', 'fecha_fin', 'modalidad', 'localidad', 'estado'));

        if (!$feria) {
            $data = [
                'status' => 'error',
                'message' => 'Error al actualizar la feria',
                'code' => 500,
                'data' => null
            ];

            return response()->json($data, 500);
        }

        $data = [
            'status' => 'success',
            'message' => 'Feria actualizada correctamente',
            'code' => 200,
            'data' => $feria
        ];

        return response()->json($data, 200);
    }

}