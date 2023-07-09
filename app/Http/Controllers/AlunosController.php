<?php
namespace App\Http\Controllers;
use App\Actions\Alunos\CreateAlunos;
use App\Actions\Alunos\UpdateAlunos;
use App\Models\Alunos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class AlunosController extends Controller
{
    public function all(Request $request)
    {
        $alunos = Alunos::get();
        return $this->successResponse($alunos);
    }
    public function one($id)
    {
        $alunos = Alunos::findOrFail($id);
        return $this->successResponse($alunos);
    }
    public function update(Request $request, UpdateAlunos $updateAlunos, $id)
    {
        $alunos = $updateAlunos->handle($request, $id);
        return $this->successResponse($alunos);
    }
    public function create(Request $request, CreateAlunos $createAlunos)
    {
        try {
            $alunos = $createAlunos->handle($request);
            return $this->successResponse($alunos, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request)
    {
        $search = $request->has('search') ? $this->_slugify($request->search) : '';
        $select = [
            'alunos.*',
            DB::raw('unaccent(alunos.descricao) as descricao_raw')
        ];
        $alunos = Alunos::when($request->has('search'), function ($query) use ($search) {
            return $query->whereRaw("LOWER(unaccent(alunos.descricao)) LIKE '%{$search}%'");
        })
            ->where('alunos.ativo', '=', true)
            ->orderBy('id')
            ->select($select)
            ->get();
        return $this->successResponse($alunos);
    }
}