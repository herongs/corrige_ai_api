<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  protected function respondWithToken($token)
  {
    return response()->json([
      'token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60
    ]);
  }

  public function login(Request $request)
  {

    $this->validate($request, [
      'email' => 'required|string',
      'password' => 'required|string',
    ]);

    $credentials = [
      'email' => $request->email,
      'password' => $request->password
    ];

    if (!$token = auth()->attempt($credentials)) {
      return $this->errorResponse('Acesso não autorizado!', 401);
    }

    $usuario = Usuario::where('id', '=', Auth::user()->id)->firstOrFail();

    $usuario->ultimo_acesso = now();
    $usuario->save();

    $result = new \stdClass();
    $result->token = $token;
    $result->usuario = $usuario;

    return $this->successResponse($result);
  }

  public function loginAdmin(Request $request)
  {

    $this->validate($request, [
      'email' => 'required|string',
      'password' => 'required|string',
    ]);

    $credentials = [
      'email' => $request->email,
      'password' => $request->password
    ];

    if (!$token = auth()->attempt($credentials)) {
      return $this->errorResponse('Acesso não autorizado!', 401);
    }


    $usuario = Usuario::where('id', '=', Auth::user()->id)->firstOrFail();
    $usuario->ultimo_acesso = now();
    $usuario->save();

    $result = new \stdClass();
    $result->token = $token;
    $result->usuario = $usuario;

    return $this->successResponse($result);
  }
}
