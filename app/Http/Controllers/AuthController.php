<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login (Request $request) {
        $credenciais = $request->all(['email', 'password']);

        $token = auth('api')->attempt($credenciais); // param 'api' definido em config/auth.php
        
        if($token) {
            return response()->json(['Token' => $token], 200);
        } else {
            return response()->json(['Erro' => 'Usuário ou senha inválidos!'], 403);
        }
    }

    public function logout () {
        auth('api')->logout();
        return response()->json(['Mensagem' => 'Logout realizado com sucesso!']);
    }

    public function refresh () {
        $token = auth('api')->refresh();
        return response()->json(['Token' => $token]);
    }

    public function me () {
        return response()->json(auth()->user());
    }

}
