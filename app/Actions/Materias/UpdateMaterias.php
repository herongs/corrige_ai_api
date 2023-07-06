<?php
namespace App\Actions\Materias;
use App\Models\Materias;
use Illuminate\Http\Request;
class UpdateMaterias
{
    public function handle(Request $request, $id): Materias
    {
        try {
            $data = $request->only([
                'ativo',
                'descricao',
            ]);
            $model = Materias::findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
