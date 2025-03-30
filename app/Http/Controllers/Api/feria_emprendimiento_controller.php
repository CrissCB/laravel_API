<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feria_emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class feria_emprendimiento_controller extends Controller
{
    public function getAll()
    {
        $feria_emprendimiento = Feria_emprendimiento::all();

        $data = [
            'feria_emprendimiento' => $feria_emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function getId($id)
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

    public function add(Request $request)
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

    public function delete($id)
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
