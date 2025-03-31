<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();

        if($usuarios->isEmpty()){
            return response()->json(['message' => 'no hay usuarios registrados'] , 400);
        }
        return response()->json($usuarios, 200);
    }

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


