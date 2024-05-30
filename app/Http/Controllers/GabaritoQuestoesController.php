<?php
namespace App\Http\Controllers;
use App\Actions\GabaritoQuestoes\CreateGabaritoQuestoes;
use App\Actions\GabaritoQuestoes\UpdateGabaritoQuestoes;
use App\Models\GabaritoQuestoes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class GabaritoQuestoesController extends Controller
{
    public function all(Request $request)
    {
        $gabarito_questoes = GabaritoQuestoes::get();
        return $this->successResponse($gabarito_questoes);
    }
    public function one($id)
    {
        $gabarito_questoes = GabaritoQuestoes::findOrFail($id);
        return $this->successResponse($gabarito_questoes);
    }
    public function update(Request $request, UpdateGabaritoQuestoes $updateGabaritoQuestoes, $id)
    {
        $gabarito_questoes = $updateGabaritoQuestoes->handle($request, $id);
        return $this->successResponse($gabarito_questoes);
    }
    public function create(Request $request, CreateGabaritoQuestoes $createGabaritoQuestoes)
    {
        try {
            $gabarito_questoes = $createGabaritoQuestoes->handle($request);
            return $this->successResponse($gabarito_questoes, 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function search(Request $request)
    {
        $search = $request->has('search') ? $this->_slugify($request->search) : '';
        $select = [
            'gabarito_questoes.*',
            DB::raw('unaccent(gabarito_questoes.descricao) as descricao_raw')
        ];
        $gabarito_questoes = GabaritoQuestoes::when($request->has('search'), function ($query) use ($search) {
            return $query->whereRaw("LOWER(unaccent(gabarito_questoes.descricao)) LIKE '%{$search}%'");
        })
            ->where('gabarito_questoes.ativo', '=', true)
            ->orderBy('id')
            ->select($select)
            ->get();
        return $this->successResponse($gabarito_questoes);
    }
}