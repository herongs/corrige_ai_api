<?php
namespace App\Http\Controllers;
use App\Actions\Turmas\CreateTurmas;
use App\Actions\Turmas\UpdateTurmas;
use App\Models\Turmas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class TurmasController extends Controller
{
    public function all(Request $request)
    {
        $turmas = Turmas::get();
        return $this->successResponse($turmas);
    }
    public function one($id)
    {
        $turmas = Turmas::findOrFail($id);
        return $this->successResponse($turmas);
    }
    public function update(Request $request, UpdateTurmas $updateTurmas, $id)
    {
        $turmas = $updateTurmas->handle($request, $id);
        return $this->successResponse($turmas);
    }
    public function create(Request $request, CreateTurmas $createTurmas)
    {
        try {
            $turmas = $createTurmas->handle($request);
            return $this->successResponse($turmas, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request)
    {
        $search = $request->has('search') ? $this->_slugify($request->search) : '';
        $select = [
            'turmas.*',
            DB::raw('unaccent(turmas.descricao) as descricao_raw')
        ];
        $turmas = Turmas::when($request->has('search'), function ($query) use ($search) {
            return $query->whereRaw("LOWER(unaccent(turmas.descricao)) LIKE '%{$search}%'");
        })
            ->where('turmas.ativo', '=', true)
            ->orderBy('id')
            ->select($select)
            ->get();
        return $this->successResponse($turmas);
    }
}