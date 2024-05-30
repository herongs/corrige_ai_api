<?php
namespace App\Http\Controllers;
use App\Actions\TurmasMaterias\CreateTurmasMaterias;
use App\Actions\TurmasMaterias\UpdateTurmasMaterias;
use App\Models\TurmasMaterias;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class TurmasMateriasController extends Controller
{
    public function all(Request $request)
    {
        $turmas_materias = TurmasMaterias::get();
        return $this->successResponse($turmas_materias);
    }
    public function one($id)
    {
        $turmas_materias = TurmasMaterias::findOrFail($id);
        return $this->successResponse($turmas_materias);
    }
    public function update(Request $request, UpdateTurmasMaterias $updateTurmasMaterias, $id)
    {
        $turmas_materias = $updateTurmasMaterias->handle($request, $id);
        return $this->successResponse($turmas_materias);
    }
    public function create(Request $request, CreateTurmasMaterias $createTurmasMaterias)
    {
        try {
            $turmas_materias = $createTurmasMaterias->handle($request);
            return $this->successResponse($turmas_materias, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request)
    {
        $search = $request->has('search') ? $this->_slugify($request->search) : '';
        $select = [
            'turmas_materias.*',
            DB::raw('unaccent(turmas_materias.descricao) as descricao_raw')
        ];
        $turmas_materias = TurmasMaterias::when($request->has('search'), function ($query) use ($search) {
            return $query->whereRaw("LOWER(unaccent(turmas_materias.descricao)) LIKE '%{$search}%'");
        })
            ->where('turmas_materias.ativo', '=', true)
            ->orderBy('id')
            ->select($select)
            ->get();
        return $this->successResponse($turmas_materias);
    }
}