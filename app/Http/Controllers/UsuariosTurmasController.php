<?php
namespace App\Http\Controllers;
use App\Actions\UsuariosTurmas\CreateUsuariosTurmas;
use App\Actions\UsuariosTurmas\UpdateUsuariosTurmas;
use App\Models\UsuariosTurmas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class UsuariosTurmasController extends Controller
{
    public function all(Request $request)
    {
        $usuarios_turmas = UsuariosTurmas::get();
        return $this->successResponse($usuarios_turmas);
    }
    public function one($id)
    {
        $usuarios_turmas = UsuariosTurmas::findOrFail($id);
        return $this->successResponse($usuarios_turmas);
    }
    public function update(Request $request, UpdateUsuariosTurmas $updateUsuariosTurmas, $id)
    {
        $usuarios_turmas = $updateUsuariosTurmas->handle($request, $id);
        return $this->successResponse($usuarios_turmas);
    }
    public function create(Request $request, CreateUsuariosTurmas $createUsuariosTurmas)
    {
        try {
            $usuarios_turmas = $createUsuariosTurmas->handle($request);
            return $this->successResponse($usuarios_turmas, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request)
    {
        $search = $request->has('search') ? $this->_slugify($request->search) : '';
        $select = [
            'usuarios_turmas.*',
            DB::raw('unaccent(usuarios_turmas.descricao) as descricao_raw')
        ];
        $usuarios_turmas = UsuariosTurmas::when($request->has('search'), function ($query) use ($search) {
            return $query->whereRaw("LOWER(unaccent(usuarios_turmas.descricao)) LIKE '%{$search}%'");
        })
            ->where('usuarios_turmas.ativo', '=', true)
            ->orderBy('id')
            ->select($select)
            ->get();
        return $this->successResponse($usuarios_turmas);
    }
}