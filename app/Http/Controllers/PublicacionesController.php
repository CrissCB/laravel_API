<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Support\Facades\Validator;

class PublicacionesController extends Controller
{
    public function index()
    {
        $publicaciones = Publicacion::all();

        if($publicaciones->isEmpty()){
            return response()->json(['message' => 'no hay publicaciones registradas'] , 400);
        }
        return response()->json($publicaciones, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'titulo' => 'required',
            'estado' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }
        $publicacion = Publicacion::create([
            'titulo'=> $request->titulo,
            'descripcion'=> $request->descripcion,
            'imagen_url'=> $request->imagen_url,
            'id_emprendimiento'=> $request->id_emprendimiento,
            'id_feria'=> $request->id_feria,
            'fecha_publicacion'=> $request->fecha_publicacion,
            'estado'=> $request->estado

        ]);
        if(!$publicacion){
            $data = [
                'message' => 'Error al crear publicacion',
                'status' => 500
            ];
        return response()->json($data,201);
        }
    }

    public function show($id)
    {
        $publicacion = Publicacion::find($id);

        if(!$publicacion){
            $data= [
                'message' => 'Publicacion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }
        $data = [
            'publicacion' => $publicacion,
            'status' => 200
        ];
        return response()->json($data,200);
    }

    public function destroy($id)
    {
        $publicacion = Publicacion::find($id);
        if(!$publicacion){
            $data= [
                'message' => 'Publicacion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $publicacion->delete();
        $data= [
            'message' => 'Publicacion Eliminada',
            'status' => 200
        ];
        return response()->json($data,200);
    }

    public function update(Request $request, $id)
    {
        $publicacion = Publicacion::find($id);
        if(!$publicacion){
            $data= [
                'message' => 'Publicacion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[
            'titulo' => 'required',
            'estado' => 'required'

        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400); 
        }

        $publicacion -> titulo = $request->titulo;
        $publicacion -> descripcion = $request->descripcion;
        $publicacion -> imagen_url = $request->imagen_url;
        $publicacion -> id_emprendimiento = $request->id_emprendimiento;
        $publicacion -> id_feria = $request->id_feria;
        $publicacion -> fecha_publicacion = $request->fecha_publicacion;
        $publicacion -> estado = $request->estado;

        $publicacion->save();
        $data= [
            'message' => 'Publicacion Actualizada',
            'publicacion' => $publicacion,
            'status' => 200
        ];
        return response()->json($data,200);
    }


    public function updatePartial(Request $request, $id)
    {
        $publicacion = Publicacion::find($id);
        if(!$publicacion){
            $data= [
                'message' => 'Publicacion no encontrada',
                'status' => 404
            ];
        return response()->json($data,404);
        }

        $validator = Validator::make($request->all(),[

            'titulo' => 'max:255',
            'descripcion' => 'max:500',
            'imagen_url' => 'max:255',
            'id_emprendimiento' => 'integer',
            'id_feria' => 'integer',
            'fecha_publicacion' => 'date',
            'estado' => 'max:2'

        ]);

        if ($request->has('titulo')) {
            $publicacion->titulo = $request->titulo;
        }
    
        if ($request->has('descripcion')) {
            $publicacion->descripcion = $request->descripcion;
        }
    
        if ($request->has('imagen_url')) {
            $publicacion->imagen_url = $request->imagen_url;
        }
    
        if ($request->has('id_emprendimiento')) {
            $publicacion->id_emprendimiento = $request->id_emprendimiento;
        }
    
        if ($request->has('id_feria')) {
            $publicacion->id_feria = $request->id_feria;
        }
    
        if ($request->has('fecha_publicacion')) {
            $publicacion->fecha_publicacion = $request->fecha_publicacion;
        }
    
        if ($request->has('estado')) {
            $publicacion->estado = $request->estado;
        }
    
        $publicacion->save();
        $data = [
            'message' => 'Publicacion Actualizado',
            'publicacion' => $publicacion,
            'status' => 200
        ];

        return response()->json($data,200);
    }
}
