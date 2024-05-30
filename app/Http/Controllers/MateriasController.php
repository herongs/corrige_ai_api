<?php
namespace App\Http\Controllers;
use App\Actions\Materias\CreateMaterias;
use App\Actions\Materias\UpdateMaterias;
use App\Models\Materias;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class MateriasController extends Controller
{
    public function all(Request $request)
    {
        $materias = Materias::get();
        return $this->successResponse($materias);
    }
    public function one($id)
    {
        $materias = Materias::findOrFail($id);
        return $this->successResponse($materias);
    }
    public function update(Request $request, UpdateMaterias $updateMaterias, $id)
    {
        $materias = $updateMaterias->handle($request, $id);
        return $this->successResponse($materias);
    }
    public function create(Request $request, CreateMaterias $createMaterias)
    {
        try {
            $materias = $createMaterias->handle($request);
            return $this->successResponse($materias, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request)
    {
        $search = $request->has('search') ? $this->_slugify($request->search) : '';
        $select = [
            'materias.*',
            DB::raw('unaccent(materias.descricao) as descricao_raw')
        ];
        $materias = Materias::when($request->has('search'), function ($query) use ($search) {
            return $query->whereRaw("LOWER(unaccent(materias.descricao)) LIKE '%{$search}%'");
        })
            ->where('materias.ativo', '=', true)
            ->orderBy('id')
            ->select($select)
            ->get();
        return $this->successResponse($materias);
    }
}