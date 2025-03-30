<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class emprendimiento_Controller extends Controller
{
    public function getAll()
    {
        $emprendimiento = Emprendimiento::all();

        $data = [
            'emprendimiento' => $emprendimiento,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function getName($nombre)
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

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_cat' => 'required|integer|exists:categoria_emprendimiento,id_cat',
            'nombre' => 'required|string|max:255|unique:emprendimiento,nombre',
            'marca' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:A,IN',
            'id_usuario' => 'required|integer|exists:usuario,id'
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

    public function delete($nombre)
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

    public function update(Request $request, $nombre)
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
            'id_cat' => 'required|integer|exists:categoria_emprendimiento,id_cat',
            'marca' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:A,IN',
            'id_usuario' => 'required|integer|exists:usuario,id'
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
            'id_usuario' => 'integer|exists:usuario,id'
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
