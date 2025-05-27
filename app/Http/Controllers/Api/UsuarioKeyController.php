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
            return response()->json(['message' => 'no hay usuarios registrados'], 400);
        }

        // El accesor getIdentificacionAttribute ya hace el trabajo
        return response()->json($usuarios_key, 200);
    }

    public function show($id)
    {
        $usuario_key = UsuarioKey::find($id);
        
        if(!$usuario_key){
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        
        return response()->json($usuario_key, 200);
    }
}