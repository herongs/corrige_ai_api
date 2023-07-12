<?php
namespace App\Actions\GabaritoQuestoes;
use App\Models\GabaritoQuestoes;
use Illuminate\Http\Request;
class UpdateGabaritoQuestoes
{
    public function handle(Request $request, $id): GabaritoQuestoes
    {
        try {
            $data = $request->only([
                'prova_id',
                'numero_questao',
                'resposta',
            ]);
            $model = GabaritoQuestoes::findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
