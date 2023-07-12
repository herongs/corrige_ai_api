<?php
namespace App\Actions\GabaritoQuestoes;
use App\Models\GabaritoQuestoes;
use Illuminate\Http\Request;
class CreateGabaritoQuestoes
{
    public function handle(Request $request): GabaritoQuestoes
    {
        try {
            $data = $request->only([
                'prova_id',
                'numero_questao',
                'resposta',
            ]);
            return GabaritoQuestoes::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
