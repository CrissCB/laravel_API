<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class producto_controller extends Controller
{

    /**
    * @OA\Get(
    *     path="/api/producto",
    *     summary="Obtener todos los productos",
    *     tags={"Producto"},
    *     @OA\Response(
    *         response=200,
    *         description="Lista de productos",
    *         @OA\JsonContent(
    *          type="object",
    *             @OA\Property(property="", type="array",
    *                 @OA\Items(type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="id_emprendimiento", type="integer", example=1),
    *                     @OA\Property(property="nombre", type="string", example="Producto 1"),
    *                     @OA\Property(property="detalle", type="string", example="Detalle del producto 1"),
    *                     @OA\Property(property="precio", type="number", format="float", example=10.50),
    *                     @OA\Property(property="stock", type="integer", example=100),
    *                     @OA\Property(property="fecha_elaboracion", type="string", format="date", example="2023-01-01"),
    *                     @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2023-12-31"),
    *                     @OA\Property(property="talla", type="string", example="M"),
    *                     @OA\Property(property="codigo_qr", type="string", example="QR123456"),
    *                     @OA\Property(property="estado", type="string", example="disponible"),
    *                     @OA\Property(property="id_cat", type="integer", example=1)
    *                 )
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     )
    * )
    */
    public function index()
    {
        $productos = Producto::all();

        $data = [
            'status' => '200',
            'message' => 'Lista de productos obtenida exitosamente',
            'code' => 200,
            'data' => $productos,
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Get(
    *     path="/api/producto/{id}",
    *     summary="Obtener un producto por ID",
    *     tags={"Producto"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de el producto",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Producto encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Productos", type="object",
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="id_emprendimiento", type="integer", example=1),
    *                 @OA\Property(property="nombre", type="string", example="Producto 1"),
    *                 @OA\Property(property="detalle", type="string", example="Detalle del producto 1"),
    *                 @OA\Property(property="precio", type="number", format="float", example=10.50),
    *                 @OA\Property(property="stock", type="integer", example=100),
    *                 @OA\Property(property="fecha_elaboracion", type="string", format="date", example="2023-01-01"),
    *                 @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2023-12-31"),
    *                 @OA\Property(property="talla", type="string", example="M"),
    *                 @OA\Property(property="codigo_qr", type="string", example="QR123456"),
    *                 @OA\Property(property="estado", type="string", example="disponible"),
    *                 @OA\Property(property="id_cat", type="integer", example=1)
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Producto no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Producto no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'status' => 'error',
                'message' => 'Producto no encontrado',
                'code' => 404,
                'data' => null
            ];

            return response()->json($data, 404);
        }

        $data = [
            'status' => 'success',
            'message' => 'Producto encontrado',
            'code' => 200,
            'data' => $producto
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Post(
    *     path="/api/producto",
    *     summary="Crear un nuevo producto",
    *     tags={"Producto"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"id_emprendimiento", "nombre", "stock", "estado", "id_cat"},
    *             @OA\Property(property="id_emprendimiento", type="integer", example=1),
    *             @OA\Property(property="nombre", type="string", example="Producto 1"),
    *             @OA\Property(property="detalle", type="string", example="Detalle del producto 1"),
    *             @OA\Property(property="precio", type="number", format="float", example=10.50),
    *             @OA\Property(property="stock", type="integer", example=100),
    *             @OA\Property(property="fecha_elaboracion", type="string", format="date", example="2023-01-01"),
    *             @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2023-12-31"),
    *             @OA\Property(property="talla", type="string", example="M"),
    *             @OA\Property(property="codigo_qr", type="string", example="QR123456"),
    *             @OA\Property(property="estado", type="string", example="disponible"),
    *             @OA\Property(property="id_cat", type="integer", example=1)
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Producto creado exitosamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Producto", type="object",
    *                 @OA\Property(property="id_emprendimiento", type="integer", example=1),
    *                 @OA\Property(property="nombre", type="string", example="Producto 1"),
    *                 @OA\Property(property="detalle", type="string", example="Detalle del producto 1"),
    *                 @OA\Property(property="precio", type="number", format="float", example=10.50),
    *                 @OA\Property(property="stock", type="integer", example=100),
    *                 @OA\Property(property="fecha_elaboracion", type="string", format="date", example="2023-01-01"),
    *                 @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2023-12-31"),
    *                 @OA\Property(property="talla", type="string", example="M"),
    *                 @OA\Property(property="codigo_qr", type="string", example="QR123456"),
    *                 @OA\Property(property="estado", type="string", example="disponible"),
    *                 @OA\Property(property="id_cat", type="integer", example=1),
    *                 @OA\Property(property="id", type="integer", example=1)
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
    *             @OA\Property(property="message", type="string", example="Error al crear el producto"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function store(Request $request)
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
                'status' => 'error',
                'message' => 'Error de validación',
                'code' => 400,
                'data' => $validator->errors()
            ];

            return response()->json($data, 400);
        }

        $producto = Producto::create($request->all());

        if (!$producto) {
            $data = [
                'status' => 'error',
                'message' => 'Error al crear el producto',
                'code' => 500,
                'data' => null
            ];

            return response()->json($data, 500);
        }

        $data = [
            'status' => 'success',
            'message' => 'Producto creado exitosamente',
            'code' => 201,
            'data' => $producto
        ];

        return response()->json($data, 201);
    }

    /**
    * @OA\Delete(
    *     path="/api/producto/{id}",
    *     summary="Eliminar un producto por ID",
    *     tags={"Producto"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de el producto",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Producto eliminado exitosamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Producto", type="string", example="eliminado"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Producto no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Producto no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'status' => 'error',
                'message' => 'Producto no encontrado',
                'code' => 404,
                'data' => null
            ];

            return response()->json($data, 404);
        }

        $producto->delete();

        $data = [
            'status' => 'success',
            'message' => 'Producto eliminado exitosamente',
            'code' => 200,
            'data' => null
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Put(
    *     path="/api/producto/{id}",
    *     summary="Actualizar un producto por ID",
    *     tags={"Producto"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de el producto",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *             required=true,
    *             @OA\JsonContent(
    *             required={"id_emprendimiento", "nombre", "stock", "estado", "id_cat"},
    *             @OA\Property(property="id_emprendimiento", type="integer", example=1),
    *             @OA\Property(property="nombre", type="string", example="Producto 1"),
    *             @OA\Property(property="detalle", type="string", example="Detalle del producto 1"),
    *             @OA\Property(property="precio", type="number", format="float", example=10.50),
    *             @OA\Property(property="stock", type="integer", example=100),
    *             @OA\Property(property="fecha_elaboracion", type="string", format="date", example="2023-01-01"),
    *             @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2023-12-31"),
    *             @OA\Property(property="talla", type="string", example="M"),
    *             @OA\Property(property="codigo_qr", type="string", example="QR123456"),
    *             @OA\Property(property="estado", type="string", example="disponible"),
    *             @OA\Property(property="id_cat", type="integer", example=1)
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Producto actualizado exitosamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Producto actualizado exitosamente"),
    *             @OA\Property(property="Producto", type="object",
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="id_emprendimiento", type="integer", example=1),
    *                 @OA\Property(property="nombre", type="string", example="Producto 1"),
    *                 @OA\Property(property="detalle", type="string", example="Detalle del producto 1"),
    *                 @OA\Property(property="precio", type="number", format="float", example=10.50),
    *                 @OA\Property(property="stock", type="integer", example=100),
    *                 @OA\Property(property="fecha_elaboracion", type="string", format="date", example="2023-01-01"),
    *                 @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2023-12-31"),
    *                 @OA\Property(property="talla", type="string", example="M"),
    *                 @OA\Property(property="codigo_qr", type="string", example="QR123456"),
    *                 @OA\Property(property="estado", type="string", example="disponible"),
    *                 @OA\Property(property="id_cat", type="integer", example=1)
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Producto no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Producto no encontrado"),
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
    *             @OA\Property(property="message", type="string", example="error al actualizar el producto"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'status' => 'error',
                'message' => 'Producto no encontrado',
                'code' => 404,
                'data' => null
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
                'status' => 'error',
                'message' => 'Error de validación',
                'code' => 400,
                'data' => $validator->errors()
            ];

            return response()->json($data, 400);
        }

        $producto->update($request->all());

        if (!$producto) {
            $data = [
                'status' => 'error',
                'message' => 'Error al actualizar el producto',
                'code' => 500,
                'data' => null
            ];

            return response()->json($data, 500);
        }

        $data = [
            'status' => 'success',
            'message' => 'Producto actualizado exitosamente',
            'code' => 200,
            'data' => $producto
        ];

        return response()->json($data, 200);
    }

    /**
    * @OA\Patch(
    *     path="/api/producto/{id}",
    *     summary="Actualizar parcialmente un producto por ID",
    *     tags={"Producto"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         required=true,
    *         description="ID de el producto",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             @OA\Property(property="id_emprendimiento", type="integer", example=1),
    *             @OA\Property(property="nombre", type="string", example="Producto 1"),
    *             @OA\Property(property="detalle", type="string", example="Detalle del producto 1"),
    *             @OA\Property(property="precio", type="number", format="float", example=10.50),
    *             @OA\Property(property="stock", type="integer", example=100),
    *             @OA\Property(property="fecha_elaboracion", type="string", format="date", example="2023-01-01"),
    *             @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2023-12-31"),
    *             @OA\Property(property="talla", type="string", example="M"),
    *             @OA\Property(property="codigo_qr", type="string", example="QR123456"),
    *             @OA\Property(property="estado", type="string", example="disponible"),
    *             @OA\Property(property="id_cat", type="integer", example=1)
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Producto actualizado parcialmente exitosamente",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Producto actualizado parcialmente exitosamente"),
    *             @OA\Property(property="Producto", type="object",
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="id_emprendimiento", type="integer", example=1),
    *                 @OA\Property(property="nombre", type="string", example="Producto 1"),
    *                 @OA\Property(property="detalle", type="string", example="Detalle del producto 1"),
    *                 @OA\Property(property="precio", type="number", format="float", example=10.50),
    *                 @OA\Property(property="stock", type="integer", example=100),
    *                 @OA\Property(property="fecha_elaboracion", type="string", format="date", example="2023-01-01"),
    *                 @OA\Property(property="fecha_vencimiento", type="string", format="date", example="2023-12-31"),
    *                 @OA\Property(property="talla", type="string", example="M"),
    *                 @OA\Property(property="codigo_qr", type="string", example="QR123456"),
    *                 @OA\Property(property="estado", type="string", example="disponible"),
    *                 @OA\Property(property="id_cat", type="integer", example=1)
    *             ),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Producto no encontrado",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Producto no encontrado"),
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
    *             @OA\Property(property="message", type="string", example="error al actualizar el producto"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */
    public function updatePartial(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'status' => 'error',
                'message' => 'Producto no encontrado',
                'code' => 404,
                'data' => null
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
                'status' => 'error',
                'message' => 'Error de validación',
                'code' => 400,
                'data' => $validator->errors()
            ];

            return response()->json($data, 400);
        }

        $producto->update($request->only((array_keys($validator->validated()))));

        if (!$producto) {
            $data = [
                'status' => 'error',
                'message' => 'Error al actualizar el producto',
                'code' => 500,
                'data' => null
            ];

            return response()->json($data, 500);
        }

        $data = [
            'status' => 'success',
            'message' => 'Producto actualizado parcialmente exitosamente',
            'code' => 200,
            'data' => $producto
        ];

        return response()->json($data, 200);
    }
}
