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
}