<?php
namespace App\Http\Controllers;
use App\Actions\Usuarios\CreateUsuarios;
use App\Actions\Usuarios\UpdateUsuarios;
use App\Models\Usuario;
use Illuminate\Http\Request;
class UsuariosController extends Controller
{
    public function all(Request $request)
    {
        $Usuarios = Usuario::get();
        return $this->successResponse($Usuarios);
    }
    public function one($id)
    {
        $Usuarios = Usuario::findOrFail($id);
        return $this->successResponse($Usuarios);
    }
    public function update(Request $request, UpdateUsuarios $updateUsuarios, $id)
    {
        $Usuarios = $updateUsuarios->handle($request, $id);
        return $this->successResponse($Usuarios);
    }
    public function create(Request $request, CreateUsuarios $createUsuarios)
    {
        try {
            $Usuarios = $createUsuarios->handle($request);
            return $this->successResponse($Usuarios, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
