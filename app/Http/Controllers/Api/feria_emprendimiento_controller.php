<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feria_emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class feria_emprendimiento_controller extends Controller
{

    /**
    * @OA\Get(
    *     path="/api/feria_emprendimiento",
    *     summary="Obtener lista de Ferias_emprendimiento",
    *     tags={"feria emprendimiento"},
    *     @OA\Response(
    *         response=200,
    *         description="Lista de Ferias-emprendimiento",
    *         @OA\JsonContent(
    *          type="object",
    *             @OA\Property(property="feria_emprendimiento", type="array",
    *                 @OA\Items(type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="id_feria", type="integer", example=1),
    *                     @OA\Property(property="id_emprendimiento", type="integer", example=1)
    *                 )
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     )
    * )
    */
    public function index()
    {
        $feria_emprendimiento = Feria_emprendimiento::all();

        $data = [
            'feria_emprendimiento' => $feria_emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Get(
    *     path="/api/feria_emprendimiento/{id}",
    *     summary="Obtener Feria-emprendimiento por ID",
    *     tags={"feria emprendimiento"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de la Feria-emprendimiento",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Feria-emprendimiento encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Feria-emprendimiento", type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="id_feria", type="integer", example=1),
    *                     @OA\Property(property="id_emprendimiento", type="integer", example=1)
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Feria-emprendimiento no encontrada",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria-emprendimiento no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function show($id)
    {
        $feria_emprendimiento = Feria_emprendimiento::find($id);

        if (!$feria_emprendimiento) {
            $data = [
                'message' => 'Feria-emprendimiento no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'Feria-emprendimiento' => $feria_emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Post(
    *     path="/api/feria_emprendimiento",
    *     summary="Crear Feria-emprendimiento",
    *     tags={"feria emprendimiento"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"id_feria", "id_emprendimiento"},
    *             @OA\Property(property="id_feria", type="integer", example=1),
    *             @OA\Property(property="id_emprendimiento", type="integer", example=1)
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Feria-emprendimiento creado correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Feria-emprendimiento", type="object",
    *                     @OA\Property(property="id_feria", type="integer", example=1),
    *                     @OA\Property(property="id_emprendimiento", type="integer", example=1),
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
    *         description="Error interno del servidor",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Error al crear el Feria-emprendimiento"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_feria' => [
                'required',
                'integer',
                'exists:feria,id',
                Rule::unique('feria_emprendimiento')->where(function ($query) use ($request) {
                    return $query->where('id_feria', $request->id_feria)
                                 ->where('id_emprendimiento', $request->id_emprendimiento);
                }),
            ],
            'id_emprendimiento' => 'required|integer|exists:emprendimiento,id',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la base de datos',
                'Error' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $feria_emprendimiento = Feria_emprendimiento::create($request->all());

        if (!$feria_emprendimiento) {
            $data = [
                'message' => 'Error al crear el Feria-emprendimiento',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Feria-emprendimiento creado correctamente',
            'Feria-emprendimiento' => $feria_emprendimiento,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    /**
    * @OA\Delete(
    *     path="/api/feria_emprendimiento/{id}",
    *     summary="Eliminar Feria-emprendimiento",
    *     tags={"feria emprendimiento"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de la Feria-emprendimiento",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Feria-emprendimiento eliminado correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="feria", type="string", example="eliminada"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Feria-emprendimiento no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria-emprendimiento no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function destroy($id)
    {
        $feria_emprendimiento = Feria_emprendimiento::find($id);

        if (!$feria_emprendimiento) {
            $data = [
                'message' => 'Feria-emprendimiento no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $feria_emprendimiento->delete();

        $data = [
            'message' => 'Feria-emprendimiento eliminado correctamente',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Put(
    *     path="/api/feria_emprendimiento/{id}",
    *     summary="Actualizar Feria-emprendimiento",
    *     tags={"feria emprendimiento"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de la Feria-emprendimiento",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *             required=true,
    *             @OA\JsonContent(
    *             required={"id_feria", "id_emprendimiento"},
    *             @OA\Property(property="id_feria", type="integer", example=1),
    *             @OA\Property(property="id_emprendimiento", type="integer", example=1)
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Feria-emprendimiento actualizado correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria-emprendimiento actualizado correctamente"),
    *             @OA\Property(property="Feria-emprendimiento", type="object",
    *                     @OA\Property(property="id_feria", type="integer", example=1),
    *                     @OA\Property(property="id_emprendimiento", type="integer", example=1),
    *                     @OA\Property(property="id", type="integer", example=1)
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Feria-emprendimiento no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria-emprendimiento no encontrado"),
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
    *             @OA\Property(property="message", type="string", example="error al actualizar el Feria-emprendimiento"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function update(Request $request, $id)
    {
        $feria_emprendimiento = Feria_emprendimiento::find($id);

        if (!$feria_emprendimiento) {
            $data = [
                'message' => 'Feria-emprendimiento no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'id_feria' => [
                'required',
                'integer',
                'exists:feria,id',
                Rule::unique('feria_emprendimiento')->where(function ($query) use ($request) {
                    return $query->where('id_feria', $request->id_feria)
                                 ->where('id_emprendimiento', $request->id_emprendimiento);
                }),
            ],
            'id_emprendimiento' => 'required|integer|exists:emprendimiento,id',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la base de datos',
                'Error' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $feria_emprendimiento->update($request->all());

        if (!$feria_emprendimiento) {
            $data = [
                'message' => 'Error al actualizar el Feria-emprendimiento',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Feria-emprendimiento actualizado correctamente',
            'Feria-emprendimiento' => $feria_emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Patch(
    *     path="/api/feria_emprendimiento/{id}",
    *     summary="Actualizar parcialmente Feria-emprendimiento",
    *     tags={"feria emprendimiento"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de la Feria-emprendimiento",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             @OA\Property(property="id_feria", type="integer", example=1),
    *             @OA\Property(property="id_emprendimiento", type="integer", example=1)
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Feria-emprendimiento actualizado correctamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria-emprendimiento actualizado correctamente"),
    *             @OA\Property(property="Feria-emprendimiento", type="object",
    *                     @OA\Property(property="id_feria", type="integer", example=1),
    *                     @OA\Property(property="id_emprendimiento", type="integer", example=1)
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Feria-emprendimiento no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Feria-emprendimiento no encontrado"),
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
    *             @OA\Property(property="message", type="string", example="error al actualizar el Feria-emprendimiento"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function updatePartial(Request $request, $id)
    {
        $feria_emprendimiento = Feria_emprendimiento::find($id);

        if (!$feria_emprendimiento) {
            $data = [
                'message' => 'Feria-emprendimiento no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'id_feria' => [
                'integer',
                'exists:feria,id',
                Rule::unique('feria_emprendimiento')->where(function ($query) use ($request, $feria_emprendimiento) {
                    return $query->where('id_feria', $request->id_feria)
                                 ->where('id_emprendimiento', $feria_emprendimiento->id_emprendimiento);
                })
            ],
            'id_emprendimiento' => [
                'integer',
                'exists:emprendimiento,id',
                Rule::unique('feria_emprendimiento')->where(function ($query) use ($request, $feria_emprendimiento) {
                    return $query->where('id_feria', $feria_emprendimiento->id_feria)
                                 ->where('id_emprendimiento', $request->id_emprendimiento);
                })
            ]
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la base de datos',
                'Error' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $feria_emprendimiento->update($request->only(['id_feria', 'id_emprendimiento']));

        if (!$feria_emprendimiento) {
            $data = [
                'message' => 'Error al actualizar el Feria-emprendimiento',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Feria-emprendimiento actualizado correctamente',
            'Feria-emprendimiento' => $feria_emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
