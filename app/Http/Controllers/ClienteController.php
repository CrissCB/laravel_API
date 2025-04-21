<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;


class ClienteController extends Controller
{
    /**
    * @OA\Get(
    *     path="/api/cliente",
    *     summary="Obtener todos los clientes",
    *     tags={"Clientes"},
    *     @OA\Response(
    *     response=200,
    *        description="Lista de clientes",
    *        @OA\JsonContent(
    *            type="array",
    *            @OA\Items(
    *                type="object",
    *                @OA\Property(property="id", type="integer", example=1),
    *                @OA\Property(property="nombre", type="string", example="Carlos"),
    *                @OA\Property(property="email", type="string", example="carlos@mail.com"),
    *            )
    *        )
    *    ),
    *     @OA\Response(
    *         response=400,
    *         description="No hay clientes registrados",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="no hay clientes registrados")
    *         )
    *     )
    * )
    */
    public function index()
    {
        $clientes = Cliente::all();

        if($clientes->isEmpty()){
            return response()->json(['message' => 'no hay clientes registrados'] , 400);
        }
        return response()->json($clientes, 200);
    }

    /**
    * @OA\Post(
    *     path="/api/cliente",
    *     summary="Registrar un nuevo cliente",
    *     tags={"Clientes"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"nombre", "apellido", "identificacion", "estado", "email"},
    *             @OA\Property(property="nombre", type="string", example="Juan"),
    *             @OA\Property(property="apellido", type="string", example="Pérez"),
    *             @OA\Property(property="identificacion", type="string", example="1234567890"),
    *             @OA\Property(property="estado", type="string", example="activo"),
    *             @OA\Property(property="fecha_nacimiento", type="string", format="date", example="1990-05-10"),
    *             @OA\Property(property="sexo", type="string", example="masculino"),
    *             @OA\Property(property="direccion", type="string", example="Calle Falsa 123"),
    *             @OA\Property(property="telefono", type="string", example="3001234567"),
    *             @OA\Property(property="email", type="string", format="email", example="juan@example.com")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Cliente creado exitosamente",
    *         @OA\JsonContent(
    *             @OA\Property(property="id", type="integer", example=1),
    *             @OA\Property(property="nombre", type="string", example="Juan"),
    *             @OA\Property(property="apellido", type="string", example="Pérez"),
    *             @OA\Property(property="email", type="string", example="juan@example.com")
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de los datos",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
    *             @OA\Property(
    *                 property="errors",
    *                 type="object",
    *                 example={"email": {"El campo email es obligatorio"}}
    *             ),
    *             @OA\Property(property="status", type="integer", example=400)
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error al crear cliente",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error al crear cliente"),
    *             @OA\Property(property="status", type="integer", example=500)
    *         )
    *     )
    * )
    */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'apellido' => 'required',
            'identificacion' => 'required',
            'estado' => 'required',
            'email' => 'required|email',

        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }
        $cliente = Cliente::create([
            'nombre'=> $request->nombre,
            'apellido'=> $request->apellido,
            'identificacion'=> $request->identificacion,
            'estado'=> $request->estado,
            'fecha_nacimiento'=> $request->fecha_nacimiento,
            'sexo'=> $request->sexo,
            'direccion'=> $request->direccion,
            'telefono'=> $request->telefono,
            'email'=> $request->email,

        ]);
        if(!$cliente){
            $data = [
                'message' => 'Error al crear cliente',
                'status' => 500
            ];
        return response()->json($data,201);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/cliente/{id}",
     *     summary="Obtener un cliente por ID",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="cliente", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Carlos"),
     *                 @OA\Property(property="apellido", type="string", example="Ramírez"),
     *                 @OA\Property(property="identificacion", type="string", example="1234567890"),
     *                 @OA\Property(property="estado", type="string", example="A"),
     *                 @OA\Property(property="email", type="string", format="email", example="carlos.ramirez@email.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-04-15T12:34:56Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-04-15T12:34:56Z")
     *             ),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente no encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */



    public function show($id)
    {
        $cliente = Cliente::find($id);

        if(!$cliente){
            $data= [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
        return response()->json($data,404);
        }
        $data = [
            'cliente' => $cliente,
            'status' => 200
        ];
        return response()->json($data,200);
    }


    /**
    * @OA\Delete(
    *     path="/api/cliente/{id}",
    *     summary="Eliminar un cliente por ID",
    *     tags={"Clientes"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID del cliente a eliminar",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Cliente eliminado correctamente",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Cliente Eliminado"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Cliente no encontrado",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Cliente no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */
 
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if(!$cliente){
            $data= [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $cliente->delete();
        $data= [
            'message' => 'Cliente Eliminado',
            'status' => 200
        ];
        return response()->json($data,200);
    }


    /**
     * @OA\Put(
     *     path="/api/cliente/{id}",
     *     summary="Actualizar un cliente",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "apellido", "identificacion", "estado", "email"},
     *             @OA\Property(property="nombre", type="string", example="Carlos"),
     *             @OA\Property(property="apellido", type="string", example="Ramírez"),
     *             @OA\Property(property="identificacion", type="string", example="1234567890"),
     *             @OA\Property(property="estado", type="string", example="A"),
     *             @OA\Property(property="fecha_nacimiento", type="string", format="date", example="1990-05-20"),
     *             @OA\Property(property="sexo", type="string", example="M"),
     *             @OA\Property(property="direccion", type="string", example="Calle 123 #45-67"),
     *             @OA\Property(property="telefono", type="string", example="3123456789"),
     *             @OA\Property(property="email", type="string", format="email", example="carlos.ramirez@email.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente Actualizado"),
     *             @OA\Property(property="cliente", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error en la validación de los datos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error en la validación de los datos"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente no encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */
    


    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        if(!$cliente){
            $data= [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'apellido' => 'required',
            'identificacion' => 'required',
            'estado' => 'required',
            'email' => 'required|email',

        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }

        $cliente -> nombre = $request->nombre;
        $cliente -> apellido = $request->apellido;
        $cliente -> identificacion = $request->identificacion;
        $cliente -> estado = $request->estado;
        $cliente -> fecha_nacimiento = $request->fecha_nacimiento;
        $cliente -> sexo = $request->sexo;
        $cliente -> direccion = $request->direccion;
        $cliente -> telefono = $request->telefono;
        $cliente -> email = $request->email;

        $cliente->save();
        $data= [
            'message' => 'Cliente Actualizado',
            'cliente' => $cliente,
            'status' => 200
        ];
        return response()->json($data,200);
    }

    /**
     * @OA\Patch(
     *     path="/api/cliente/{id}",
     *     summary="Actualizar parcialmente un cliente",
     *     tags={"Clientes"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del cliente a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="string", maxLength=250, example="Carlos"),
     *             @OA\Property(property="apellido", type="string", maxLength=250, example="Ramírez"),
     *             @OA\Property(property="identificacion", type="string", maxLength=250, example="1234567890"),
     *             @OA\Property(property="estado", type="string", maxLength=2, example="A"),
     *             @OA\Property(property="email", type="string", format="email", example="carlos.ramirez@email.com")
     *         )     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cliente actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente Actualizado"),
     *             @OA\Property(property="cliente", type="object"),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
     *             @OA\Property(property="errors", type="object"),
     *             @OA\Property(property="status", type="integer", example=400)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cliente no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Cliente no encontrado"),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     )
     * )
     */

    public function updatePartial(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        if(!$cliente){
            $data= [
                'message' => 'Cliente no encontrado',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[
            'nombre' => 'max:250',
            'apellido' => 'max:250',
            'identificacion' => 'max:250',
            'estado' => 'max:2',
            'email' => 'email|unique:cliente',

        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }

        //Obligatorios al menos uno
        if($request->has('nombre')){
            $cliente-> nombre = $request->nombre;
        }

        if($request->has('apellido')){
            $cliente-> apellido = $request->apellido;
        }

        if($request->has('identificacion')){
            $cliente-> identificacion = $request->identificacion;
        }

        if($request->has('estado')){
            $cliente-> estado = $request->estado;
        }
        if($request->has('email')){
            $cliente-> email = $request->email;
        }
       

        $cliente->save();
        $data = [
            'message' => 'Cliente Actualizado',
            'cliente' => $cliente,
            'status' => 200
        ];

        return response()->json($data,200);
    }
}
