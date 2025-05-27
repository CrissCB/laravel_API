<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class emprendimiento_Controller extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/emprendimiento",
    *     summary="Listar todos los emprendimientos",
    *     tags={"Emprendimiento"},
    *     @OA\Response(
    *         response=200,
    *         description="Lista de emprendimientos",
    *         @OA\JsonContent(
    *          type="object",
    *             @OA\Property(property="Emprendimiento", type="array",
    *                 @OA\Items(type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="id_cat", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Emprendimiento 1"),
    *                     @OA\Property(property="marca", type="string", example="Marca 1"),
    *                     @OA\Property(property="descripcion", type="string", example="Descripción del emprendimiento 1"),
    *                     @OA\Property(property="estado", type="string", example="A"),
    *                     @OA\Property(property="id_usuario", type="integer", example=1)
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         ))
    *     )
    * )
    */
    public function index()
    {
        $emprendimiento = Emprendimiento::all();

        $data = [
            'emprendimiento' => $emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Get(
    *     path="/api/emprendimiento/{nombre}",
    *     summary="Obtener un emprendimiento por nombre",
    *     tags={"Emprendimiento"},
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         required=true,
    *         description="Nombre del emprendimiento",
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Emprendimiento encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Emprendimiento", type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="id_cat", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Emprendimiento 1"),
    *                     @OA\Property(property="marca", type="string", example="Marca 1"),
    *                     @OA\Property(property="descripcion", type="string", example="Descripción del emprendimiento 1"),
    *                     @OA\Property(property="estado", type="string", example="A"),
    *                     @OA\Property(property="id_usuario", type="integer", example=1),
    *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-10-01T00:00:00Z")
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Emprendimiento no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Emprendimiento no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function show($nombre)
    {
        $emprendimiento = Emprendimiento::where('nombre', $nombre)->first();

        if (!$emprendimiento) {
            $data = [
                'message' => 'Emprendimiento no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'Emprendimiento' => $emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

/**
    * @OA\Post(
    *     path="/api/emprendimiento",
    *     summary="Crear un nuevo emprendimiento",
    *     tags={"Emprendimiento"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"nombre", "id_cat", "estado", "id_usuario"},
    *             @OA\Property(property="id_cat", type="integer", example=1),
    *             @OA\Property(property="nombre", type="string", example="Emprendimiento 1"),
    *             @OA\Property(property="marca", type="string", example="Marca 1"),
    *             @OA\Property(property="descripcion", type="string", example="Descripción del emprendimiento 1"),
    *             @OA\Property(property="estado", type="string", example="A"),
    *             @OA\Property(property="id_usuario", type="string", example=1),
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Emprendimiento creado correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Emprendimiento", type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="id_cat", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Emprendimiento 1"),
    *                     @OA\Property(property="marca", type="string", example="Marca 1"),
    *                     @OA\Property(property="descripcion", type="string", example="Descripción del emprendimiento 1"),
    *                     @OA\Property(property="estado", type="string", example="A"),
    *                     @OA\Property(property="id_usuario", type="string", example=1),
    *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-10-01T00:00:00Z")
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
    *         description="Error interno del servidor",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Error al crear el emprendimiento"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_cat' => 'required|integer|exists:categoria_emprendimiento,id_cat',
            'nombre' => 'required|string|max:255|unique:emprendimiento,nombre',
            'marca' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:A,IN',
            'id_usuario' => 'required|string|exists:usuario,identificacion'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la base de datos',
                'Error' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $emprendimiento = Emprendimiento::create([
            'id_cat' => $request->id_cat,
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'id_usuario' => $request->id_usuario
        ]);

        if (!$emprendimiento) {
            $data = [
                'message' => 'Error al crear el emprendimiento',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'Emprendimiento' => $emprendimiento,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    /**
    * @OA\Delete(
    *     path="/api/emprendimiento/{nombre}",
    *     summary="Eliminar un emprendimiento por nombre",
    *     tags={"Emprendimiento"},
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         required=true,
    *         description="Nombre del emprendimiento",
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Emprendimiento eliminado correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Emprendimiento", type="string", example="eliminada"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Emprendimiento no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Emprendimiento no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function destroy($nombre)
    {
        $emprendimiento = Emprendimiento::where('nombre', $nombre)->first();

        if (!$emprendimiento) {
            $data = [
                'message' => 'Emprendimiento no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $emprendimiento->delete();

        $data = [
            'message' => 'Emprendimiento eliminado correctamente',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Put(
    *     path="/api/emprendimiento/{nombre}",
    *     summary="Actualizar un emprendimiento por nombre",
    *     tags={"Emprendimiento"},
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         required=true,
    *         description="Nombre del emprendimiento",
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"estado"},
    *                     @OA\Property(property="id_cat", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Emprendimiento 1"),
    *                     @OA\Property(property="marca", type="string", example="Marca 1"),
    *                     @OA\Property(property="descripcion", type="string", example="Descripción del emprendimiento 1"),
    *                     @OA\Property(property="estado", type="string", example="A"),
    *                     @OA\Property(property="id_usuario", type="integer", example=1),
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Emprendimiento actualizado correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Emprendimiento actualizado"),
    *             @OA\Property(property="Emprendimiento", type="object",
    *                     @OA\Property(property="id_cat", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Emprendimiento 1"),
    *                     @OA\Property(property="marca", type="string", example="Marca 1"),
    *                     @OA\Property(property="descripcion", type="string", example="Descripción del emprendimiento 1"),
    *                     @OA\Property(property="estado", type="string", example="A"),
    *                     @OA\Property(property="id_usuario", type="integer", example=1),
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-10-01T00:00:00Z")
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Emprendimiento no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Emprendimiento no encontrado"),
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
    *         description="Error interno del servidor",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Error al actualizar el emprendimiento"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function update(Request $request, $id_cat)
    {
        $emprendimiento = Emprendimiento::where('id_cat', $id_cat)->first();

        if (!$emprendimiento) {
            $data = [
                'message' => 'Emprendimiento no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            // 'id_cat' => 'required|integer|exists:categoria_emprendimiento,id_cat',
            'marca' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:A,IN',
            // 'id_usuario' => 'required|integer|exists:usuario,id'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la base de datos',
                'Error' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $emprendimiento->update([
            'id_cat' => $request->id_cat,
            'marca' => $request->marca,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'id_usuario' => $request->id_usuario
        ]);

        if (!$emprendimiento) {
            $data = [
                'message' => 'Error al actualizar el emprendimiento',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'Emprendimiento actualizado' => $emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Patch(
    *     path="/api/emprendimiento/{nombre}",
    *     summary="Actualizar parcialmente un emprendimiento por nombre",
    *     tags={"Emprendimiento"},
    *     @OA\Parameter(
    *         name="nombre",
    *         in="path",
    *         required=true,
    *         description="Nombre del emprendimiento",
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *                     @OA\Property(property="id_cat", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Emprendimiento 1"),
    *                     @OA\Property(property="marca", type="string", example="Marca 1"),
    *                     @OA\Property(property="descripcion", type="string", example="Descripción del emprendimiento 1"),
    *                     @OA\Property(property="estado", type="string", example="A"),
    *                     @OA\Property(property="id_usuario", type="string", example=1)
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Emprendimiento actualizado parcialmente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Emprendimiento actualizado parcialmente"),
    *             @OA\Property(property="Emprendimiento", type="object",
    *                     @OA\Property(property="id_cat", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Emprendimiento 1"),
    *                     @OA\Property(property="marca", type="string", example="Marca 1"),
    *                     @OA\Property(property="descripcion", type="string", example="Descripción del emprendimiento 1"),
    *                     @OA\Property(property="estado", type="string", example="A"),
    *                     @OA\Property(property="id_usuario", type="string", example=1),
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-10-01T00:00:00Z")
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Emprendimiento no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Emprendimiento no encontrado"),
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
    *         description="Error interno del servidor",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Error al actualizar el emprendimiento"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function updatePartial(Request $request, $nombre)
    {
        $emprendimiento = Emprendimiento::where('nombre', $nombre)->first();

        if (!$emprendimiento) {
            $data = [
                'message' => 'Emprendimiento no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'id_cat' => 'integer|exists:categoria_emprendimiento,id_cat',
            'marca' => 'string|max:255',
            'descripcion' => 'string',
            'estado' => 'in:A,IN',
            'id_usuario' => 'string|exists:usuario,id'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la base de datos',
                'Error' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $emprendimiento->update($request->only(['id_cat', 'marca', 'descripcion', 'estado', 'id_usuario']));

        if (!$emprendimiento) {
            $data = [
                'message' => 'Error al actualizar el emprendimiento',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'Emprendimiento actualizado parcialmente' => $emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
