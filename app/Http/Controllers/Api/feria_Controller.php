<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class feria_Controller extends Controller
{
    public function getAll()
    {
        $feria = Feria::all();

        $data = [
            'feria' => $feria,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function getName($id)
    {
        $feria = Feria::find($id);

        if (!$feria) {
            $data = [
                'message' => 'Feria no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'Feria' => $feria,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function add(Request $request)
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
                'message' => 'Error en la base de datos',
                'Error' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $feria = Feria::create($request->all());

        if (!$feria) {
            $data = [
                'message' => 'Error al crear la feria',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'Feria' => $feria,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function delete($id)
    {
        $feria = Feria::find($id);

        if (!$feria) {
            $data = [
                'message' => 'Feria no encontrada',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $feria->delete();

        $data = [
            'message' => 'Feria eliminada correctamente',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    
    public function update(Request $request, $id)
    {
        $feria = Feria::find($id);

        if (!$feria) {
            $data = [
                'message' => 'Feria no encontrada',
                'status' => 404
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
                'message' => 'Error en la base de datos',
                'Error' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $feria->update($request->all());

        if (!$feria) {
            $data = [
                'message' => 'Error al actualizar la feria',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'Feria' => $feria,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $feria = Feria::find($id);

        if (!$feria) {
            $data = [
                'message' => 'Feria no encontrada',
                'status' => 404
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
                'message' => 'Error en la base de datos',
                'Error' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $feria->update($request->only('nombre', 'descripcion', 'fecha_inicio', 'fecha_fin', 'modalidad', 'localidad', 'estado'));

        if (!$feria) {
            $data = [
                'message' => 'Error al actualizar la feria',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'Feria' => $feria,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

}