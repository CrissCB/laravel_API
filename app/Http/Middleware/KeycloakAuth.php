<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KeycloakAuth
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'Token no enviado'], 401);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $realm = 'laravel-realm'; // tu realm
            $url = "http://keycloak:8080/realms/{$realm}/protocol/openid-connect/certs";

            $jwks = Http::get($url)->json();
            $decoded = JWT::decode($token, JWK::parseKeySet($jwks));

            // Puedes guardar info del usuario aquí si deseas
            $request->attributes->set('user', $decoded);

            return $next($request);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Token inválido', 'detalle' => $e->getMessage()], 401);
        }
    }
}