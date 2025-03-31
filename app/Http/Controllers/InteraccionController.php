<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interaccion;
use Illuminate\Support\Facades\Validator;

class InteraccionController extends Controller
{
    public function index()
    {
        $interacciones = Interaccion::all();

        if($interacciones->isEmpty()){
            return response()->json(['message' => 'no hay interacciones registradas'] , 400);
        }
        return response()->json($interacciones, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[

            'id_cliente' => 'required|integer|exists:cliente,id',
            'id_publicacion' => 'required|integer|exists:publicaciones,id'


        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }

        $interaccion = Interaccion::create([

            'id_cliente'=> $request->id_cliente,
            'id_publicacion'=> $request->id_publicacion,
            'fecha_interaccion'=> $request->fecha_interaccion,
            'comentarios'=> $request->comentarios,
            'calificacion'=> $request->calificacion

        ]);
        if(!$interaccion){
            $data = [
                'message' => 'Error al crear interaccion',
                'status' => 500
            ];
        return response()->json($data,201);
        }
    }

    public function show($id)
    {
        $interaccion = Interaccion::find($id);

        if(!$interaccion){
            $data= [
                'message' => 'Interaccion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }
        $data = [
            'interaccion' => $interaccion,
            'status' => 200
        ];
        return response()->json($data,200);
    }

    public function destroy($id)
    {
        $interaccion = Interaccion::find($id);
        if(!$interaccion){
            $data= [
                'message' => 'Interaccion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $interaccion->delete();
        $data= [
            'message' => 'Interaccion Eliminada',
            'status' => 200
        ];
        return response()->json($data,200);
    }

    public function update(Request $request, $id)
    {
        $interaccion = Interaccion::find($id);
        if(!$interaccion){
            $data= [
                'message' => 'Interaccion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[

            'id_cliente' => 'required|integer|exists:cliente,id',
            'id_publicacion' => 'required|integer|exists:publicaciones,id'


        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }

        $interaccion -> id_cliente = $request->id_cliente;
        $interaccion -> id_publicacion = $request->id_publicacion;
        $interaccion -> fecha_interaccion = $request->fecha_interaccion;
        $interaccion -> comentarios = $request->comentarios;
        $interaccion -> calificacion = $request->calificacion;

        $interaccion->save();
        $data= [
            'message' => 'Interaccion Actualizada',
            'interaccion' => $interaccion,
            'status' => 200
        ];
        return response()->json($data,200);
    }


    public function updatePartial(Request $request, $id)
    {
        $interaccion = Interaccion::find($id);
        if(!$interaccion){
            $data= [
                'message' => 'Interaccion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        //Obligatorios al menos uno
        if($request->has('id_cliente')){
            $interaccion-> id_cliente = $request->id_cliente;
        }

        if($request->has('id_publicacion')){
            $interaccion-> id_publicacion = $request->id_publicacion;
        }

        if($request->has('fecha_interaccion')){
            $interaccion-> fecha_interaccion = $request->fecha_interaccion;
        }

        if($request->has('comentarios')){
            $interaccion-> comentarios = $request->comentarios;
        }
        if($request->has('calificacion')){
            $interaccion-> calificacion = $request->calificacion;
        }
       

        $interaccion->save();
        $data = [
            'message' => 'Interaccion Actualizada',
            'interaccion' => $interaccion,
            'status' => 200
        ];

        return response()->json($data,200);
    }
}
