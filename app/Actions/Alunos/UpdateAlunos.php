<?php
namespace App\Actions\Alunos;
use App\Models\Alunos;
use Illuminate\Http\Request;
class UpdateAlunos
{
    public function handle(Request $request, $id): Alunos
    {
        try {
            $data = $request->only([
                'nome',
                'turma_id',
                'matricula'
            ]);
            $model = Alunos::findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
