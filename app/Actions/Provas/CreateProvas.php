<?php
namespace App\Actions\Provas;
use App\Models\Provas;
use Illuminate\Http\Request;
class CreateProvas
{
    public function handle(Request $request): Provas
    {
        try {
            $data = $request->only([
                'data',
                'data_aplicacao',
                'turma_id',
                'materia_id'
            ]);
            return Provas::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
