<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;


class UsuarioController extends Controller
{   

    /**
    * @OA\Get(
    *     path="/api/user",
    *     summary="Obtener todos los usuarios",
    *     tags={"Usuarios"},
    *     @OA\Response(
    *         response=200,
    *         description="Lista de usuarios",
    *         @OA\JsonContent(
    *             type="array",
    *             @OA\Items(type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="No hay usuarios registrados",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="no hay usuarios registrados")
    *         )
    *     )
    * )
    */

    public function index()
    {
        $usuarios = Usuario::all();

        if($usuarios->isEmpty()){
            return response()->json(['message' => 'no hay usuarios registrados'] , 400);
        }
        return response()->json($usuarios, 200);
    }


    /**
    * @OA\Post(
    *     path="/api/user",
    *     summary="Crear un nuevo usuario",
    *     tags={"Usuarios"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"nombre","apellido","identificacion","estado","email"},
    *             @OA\Property(property="nombre", type="string", example="Juan"),
    *             @OA\Property(property="apellido", type="string", example="Pérez"),
    *             @OA\Property(property="identificacion", type="string", example="12345678"),
    *             @OA\Property(property="codigo", type="string", example="U2025"),
    *             @OA\Property(property="programa", type="string", example="Ingeniería de Sistemas"),
    *             @OA\Property(property="estado", type="string", example="1"),
    *             @OA\Property(property="fecha_nacimiento", type="string", format="date", example="2000-05-20"),
    *             @OA\Property(property="sexo", type="string", example="M"),
    *             @OA\Property(property="direccion", type="string", example="Calle 123 #45-67"),
    *             @OA\Property(property="telefono", type="string", example="3123456789"),
    *             @OA\Property(property="redes_sociales", type="string", example="@juanperez"),
    *             @OA\Property(property="email", type="string", format="email", example="juan@example.com")
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Usuario creado exitosamente",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Usuario creado"),
    *             @OA\Property(property="usuario", type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de los datos",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
    *             @OA\Property(property="errors", type="object")
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Error al crear usuario",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error al crear usuario")
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
        $usuario = Usuario::create([
            'nombre'=> $request->nombre,
            'apellido'=> $request->apellido,
            'identificacion'=> $request->identificacion,
            'codigo'=> $request->codigo,
            'programa'=> $request->programa,
            'estado'=> $request->estado,
            'fecha_nacimiento'=> $request->fecha_nacimiento,
            'sexo'=> $request->sexo,
            'direccion'=> $request->direccion,
            'telefono'=> $request->telefono,
            'redes_sociales'=> $request->redes_sociales,
            'email'=> $request->email,

        ]);
        if(!$usuario){
            $data = [
                'message' => 'Error al crear usuario',
                'status' => 500
            ];
        return response()->json($data,201);
        }
    }


    /**
    * @OA\Get(
    *     path="/api/user/{id}",
    *     summary="Obtener un usuario por ID",
    *     tags={"Usuarios"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID del usuario",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Usuario encontrado",
    *         @OA\JsonContent(
    *             @OA\Property(property="usuario", type="object"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Usuario no encontrado",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Usuario no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */

    public function show($id)
    {
        $usuario = Usuario::find($id);

        if(!$usuario){
            $data= [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
        return response()->json($data,404);
        }
        $data = [
            'usuario' => $usuario,
            'status' => 200
        ];
        return response()->json($data,200);
    }

    /**
    * @OA\Delete(
    *     path="/api/user/{id}",
    *     summary="Eliminar un usuario por ID",
    *     tags={"Usuarios"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID del usuario a eliminar",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Usuario eliminado",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Usuario Eliminado"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Usuario no encontrado",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Usuario no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */

    public function destroy($id)
    {
        $usuario = Usuario::find($id);
        if(!$usuario){
            $data= [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $usuario->delete();
        $data= [
            'message' => 'Usuario Eliminado',
            'status' => 200
        ];
        return response()->json($data,200);
    }

    /**
    * @OA\Put(
    *     path="/api/user/{id}",
    *     summary="Actualizar un usuario por ID",
    *     tags={"Usuarios"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID del usuario a actualizar",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"nombre","apellido","identificacion","estado","email"},
    *             @OA\Property(property="nombre", type="string", example="Carlos"),
    *             @OA\Property(property="apellido", type="string", example="Pérez"),
    *             @OA\Property(property="identificacion", type="string", example="1122334455"),
    *             @OA\Property(property="codigo_estudiantil", type="string", example="2020123456"),
    *             @OA\Property(property="programa", type="string", example="Ingeniería de Sistemas"),
    *             @OA\Property(property="estado", type="string", example="A"),
    *             @OA\Property(property="fecha_nacimiento", type="string", format="date", example="1998-04-15"),
    *             @OA\Property(property="sexo", type="string", example="M"),
    *             @OA\Property(property="direccion", type="string", example="Calle 123 #45-67"),
    *             @OA\Property(property="telefono", type="string", example="3201234567"),
    *             @OA\Property(property="redes_sociales", type="string", example="@carlosperez"),
    *             @OA\Property(property="email", type="string", format="email", example="carlos@example.com")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Usuario actualizado",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Usuario Actualizado"),
    *             @OA\Property(property="usuario", type="object"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de los datos",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
    *             @OA\Property(property="errors", type="object"),
    *             @OA\Property(property="status", type="integer", example=400)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Usuario no encontrado",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Usuario no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */

    public function update(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        if(!$usuario){
            $data= [
                'message' => 'Usuario no encontrado',
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

        $usuario -> nombre = $request->nombre;
        $usuario -> apellido = $request->apellido;
        $usuario -> identificacion = $request->identificacion;
        $usuario -> codigo_estudiantil = $request->codigo_estudiantil;
        $usuario -> programa = $request->programa;
        $usuario -> estado = $request->estado;
        $usuario -> fecha_nacimiento = $request->fecha_nacimiento;
        $usuario -> sexo = $request->sexo;
        $usuario -> direccion = $request->direccion;
        $usuario -> telefono = $request->telefono;
        $usuario -> redes_sociales = $request->redes_sociales;
        $usuario -> email = $request->email;

        $usuario->save();
        $data= [
            'message' => 'Usuario Actualizado',
            'usuario' => $usuario,
            'status' => 200
        ];
        return response()->json($data,200);
    }

    /**
    * @OA\Patch(
    *     path="/api/user/{id}",
    *     summary="Actualizar parcialmente un usuario por ID",
    *     tags={"Usuarios"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="ID del usuario a actualizar",
    *         required=true,
    *         @OA\Schema(type="integer", example=1)
    *     ),
    *     @OA\RequestBody(
    *         required=true,
    *         description="Datos a actualizar (al menos uno)",
    *         @OA\JsonContent(
    *             @OA\Property(property="nombre", type="string", maxLength=250, example="Luis"),
    *             @OA\Property(property="apellido", type="string", maxLength=250, example="Ramírez"),
    *             @OA\Property(property="identificacion", type="string", maxLength=250, example="1234567890"),
    *             @OA\Property(property="estado", type="string", maxLength=2, example="A"),
    *             @OA\Property(property="email", type="string", format="email", example="luis.ramirez@example.com")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Usuario actualizado parcialmente",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Usuario Actualizado"),
    *             @OA\Property(property="usuario", type="object"),
    *             @OA\Property(property="status", type="integer", example=200)
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Error en la validación de los datos",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Error en la validacion de los datos"),
    *             @OA\Property(property="errors", type="object"),
    *             @OA\Property(property="status", type="integer", example=400)
    *         )
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Usuario no encontrado",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Usuario no encontrado"),
    *             @OA\Property(property="status", type="integer", example=404)
    *         )
    *     )
    * )
    */

    public function updatePartial(Request $request, $id)
    {
        $usuario = Usuario::find($id);
        if(!$usuario){
            $data= [
                'message' => 'Usuario no encontrado',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[
            'nombre' => 'max:250',
            'apellido' => 'max:250',
            'identificacion' => 'max:250',
            'estado' => 'max:2',
            'email' => 'email|unique:usuario',

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
            $usuario-> nombre = $request->nombre;
        }

        if($request->has('apellido')){
            $usuario-> apellido = $request->apellido;
        }

        if($request->has('identificacion')){
            $usuario-> identificacion = $request->identificacion;
        }

        if($request->has('estado')){
            $usuario-> estado = $request->estado;
        }
        if($request->has('email')){
            $usuario-> email = $request->email;
        }
       

        $usuario->save();
        $data = [
            'message' => 'Usuario Actualizado',
            'usuario' => $usuario,
            'status' => 200
        ];

        return response()->json($data,200);
    }
}


