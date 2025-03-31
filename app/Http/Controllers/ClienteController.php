<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();

        if($clientes->isEmpty()){
            return response()->json(['message' => 'no hay clientes registrados'] , 400);
        }
        return response()->json($clientes, 200);
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
