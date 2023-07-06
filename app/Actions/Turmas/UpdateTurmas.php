<?php
namespace App\Actions\Turmas;
use App\Models\Turmas;
use Illuminate\Http\Request;
class UpdateTurmas
{
    public function handle(Request $request, $id): Turmas
    {
        try {
            $data = $request->only([
                'ativo',
                'descricao',
                'ano',
            ]);
            $model = Turmas::findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
