<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function exchangeToken(Request $request)
    {
        $code = $request->input('code');

        $response = Http::asForm()->post(env('KEYCLOAK_BASE_URL') . '/realms/' . env('KEYCLOAK_REALM') . '/protocol/openid-connect/token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('KEYCLOAK_CLIENT_ID'),
            'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
            'code' => $code,
            'redirect_uri' => env('KEYCLOAK_REDIRECT_URI'),
        ]);

        if ($response->failed()){
            $data = [
                'status' => 'error',
                'message' => 'Token exchange failed',
                'code' => 401,
                'data' => null
            ];
            return response()->json($data, 401);
        }

        return $response->json();
    }
}