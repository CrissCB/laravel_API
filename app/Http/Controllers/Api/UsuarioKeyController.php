<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsuarioKey;
use Illuminate\Support\Facades\Validator;

class UsuarioKeyController extends Controller
{   
    public function index()
    {
        $usuarios_key = UsuarioKey::all(); 

        if($usuarios_key->isEmpty()){
            $data = [
                'status' => 'error',
                'message' => 'No hay usuarios registrados',
                'code' => 400,
                'data' => null
            ];
            return response()->json($data, 400);
        }

        // El accesor getIdentificacionAttribute ya hace el trabajo
        return response()->json($usuarios_key, 200);
    }

    public function show($id)
    {
        $usuario_key = UsuarioKey::find($id);
        
        if(!$usuario_key){
            $data = [
                'status' => 'error',
                'message' => 'Usuario no encontrado',
                'code' => 404,
                'data' => null
            ];
            return response()->json($data, 404);
        }
        
        return response()->json($usuario_key, 200);
    }
}