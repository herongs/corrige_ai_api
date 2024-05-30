<?php
namespace App\Http\Controllers;
use App\Actions\UsuariosMaterias\CreateUsuariosMaterias;
use App\Actions\UsuariosMaterias\UpdateUsuariosMaterias;
use App\Models\UsuariosMaterias;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class UsuariosMateriasController extends Controller
{
    public function all(Request $request)
    {
        $usuarios_materias = UsuariosMaterias::get();
        return $this->successResponse($usuarios_materias);
    }
    public function one($id)
    {
        $usuarios_materias = UsuariosMaterias::findOrFail($id);
        return $this->successResponse($usuarios_materias);
    }
    public function update(Request $request, UpdateUsuariosMaterias $updateUsuariosMaterias, $id)
    {
        $usuarios_materias = $updateUsuariosMaterias->handle($request, $id);
        return $this->successResponse($usuarios_materias);
    }
    public function create(Request $request, CreateUsuariosMaterias $createUsuariosMaterias)
    {
        try {
            $usuarios_materias = $createUsuariosMaterias->handle($request);
            return $this->successResponse($usuarios_materias, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request)
    {
        $search = $request->has('search') ? $this->_slugify($request->search) : '';
        $select = [
            'usuarios_materias.*',
            DB::raw('unaccent(usuarios_materias.descricao) as descricao_raw')
        ];
        $usuarios_materias = UsuariosMaterias::when($request->has('search'), function ($query) use ($search) {
            return $query->whereRaw("LOWER(unaccent(usuarios_materias.descricao)) LIKE '%{$search}%'");
        })
            ->where('usuarios_materias.ativo', '=', true)
            ->orderBy('id')
            ->select($select)
            ->get();
        return $this->successResponse($usuarios_materias);
    }
}