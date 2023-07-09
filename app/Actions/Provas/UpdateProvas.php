<?php
namespace App\Actions\Provas;
use App\Models\Provas;
use Illuminate\Http\Request;
class UpdateProvas
{
    public function handle(Request $request, $id): Provas
    {
        try {
            $data = $request->only([
                'data',
                'data_aplicacao',
                'turma_id',
                'materia_id'
            ]);
            $model = Provas::findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
