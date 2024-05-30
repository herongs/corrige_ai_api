<?php
namespace App\Http\Controllers;
use App\Actions\Provas\CreateProvas;
use App\Actions\Provas\UpdateProvas;
use App\Models\Provas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class ProvasController extends Controller
{
    public function all(Request $request)
    {
        $provas = Provas::get();
        return $this->successResponse($provas);
    }
    public function one($id)
    {
        $provas = Provas::findOrFail($id);
        return $this->successResponse($provas);
    }
    public function update(Request $request, UpdateProvas $updateProvas, $id)
    {
        $provas = $updateProvas->handle($request, $id);
        return $this->successResponse($provas);
    }
    public function create(Request $request, CreateProvas $createProvas)
    {
        try {
            $provas = $createProvas->handle($request);
            return $this->successResponse($provas, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request)
    {
        $search = $request->has('search') ? $this->_slugify($request->search) : '';
        $select = [
            'provas.*',
            DB::raw('unaccent(provas.descricao) as descricao_raw')
        ];
        $provas = Provas::when($request->has('search'), function ($query) use ($search) {
            return $query->whereRaw("LOWER(unaccent(provas.descricao)) LIKE '%{$search}%'");
        })
            ->where('provas.ativo', '=', true)
            ->orderBy('id')
            ->select($select)
            ->get();
        return $this->successResponse($provas);
    }
}