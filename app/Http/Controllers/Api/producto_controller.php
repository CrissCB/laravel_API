<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class producto_controller extends Controller
{
    public function getAll()
    {
        $productos = Producto::all();

        $data = [
            'productos' => $productos,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function getId($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'producto' => $producto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_emprendimiento' => 'required|integer|exists:emprendimiento,id',
            'nombre' => 'required|string|max:255',
            'detalle' => 'nullable|string',
            'precio' => 'nullable|numeric|between:0,999999.99',
            'stock' => 'required|integer|min:0',
            'fecha_elaboracion' => 'nullable|date|before_or_equal:fecha_vencimiento',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_elaboracion',
            'talla' => 'nullable|string|max:50',
            'codigo_qr' => 'nullable|string|max:50|unique:producto,codigo_qr',
            'estado' => 'nullable|string|in:disponible,agotado,descontinuado',
            'id_cat' => 'required|integer|exists:categoria_producto,id_cat'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $producto = Producto::create($request->all());

        if (!$producto) {
            $data = [
                'message' => 'Error al crear el producto',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Producto creado exitosamente',
            'producto' => $producto,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function delete($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $producto->delete();

        $data = [
            'message' => 'Producto eliminado exitosamente',
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'id_emprendimiento' => 'required|integer|exists:emprendimiento,id',
            'nombre' => 'required|string|max:255',
            'detalle' => 'nullable|string',
            'precio' => 'nullable|numeric|between:0,999999.99',
            'stock' => 'required|integer|min:0',
            'fecha_elaboracion' => 'nullable|date|before_or_equal:fecha_vencimiento',
            'fecha_vencimiento' => 'nullable|date|after_or_equal:fecha_elaboracion',
            'talla' => 'nullable|string|max:50',
            'codigo_qr' => 'nullable|string|max:50|unique:producto,codigo_qr',
            'estado' => 'nullable|string|in:disponible,agotado,descontinuado',
            'id_cat' => 'required|integer|exists:categoria_producto,id_cat'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $producto->update($request->all());

        if (!$producto) {
            $data = [
                'message' => 'Error al actualizar el producto',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Producto actualizado exitosamente',
            'producto' => $producto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message' => 'Producto no encontrado',
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'id_emprendimiento' => 'integer|exists:emprendimiento,id',
            'nombre' => 'string|max:255',
            'detalle' => 'string',
            'precio' => 'numeric|between:0,999999.99',
            'stock' => 'integer|min:0',
            'fecha_elaboracion' => 'date|before_or_equal:fecha_vencimiento',
            'fecha_vencimiento' => 'date|after_or_equal:fecha_elaboracion',
            'talla' => 'string|max:50',
            'codigo_qr' => 'string|max:50|unique:producto,codigo_qr',
            'estado' => 'string|in:disponible,agotado,descontinuado',
            'id_cat' => 'integer|exists:categoria_producto,id_cat'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 400
            ];

            return response()->json($data, 400);
        }

        $producto->update($request->only((array_keys($validator->validated()))));

        if (!$producto) {
            $data = [
                'message' => 'Error al actualizar el producto',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Producto actualizado parcialmente exitosamente',
            'producto' => $producto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
