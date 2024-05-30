<?php
namespace App\Actions\TurmasMaterias;
use App\Models\TurmasMaterias;
use Illuminate\Http\Request;
class UpdateTurmasMaterias
{
    public function handle(Request $request, $id): TurmasMaterias
    {
        try {
            $data = $request;
            $model = TurmasMaterias::findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
