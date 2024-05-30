<?php
namespace App\Actions\UsuariosMaterias;
use App\Models\UsuariosMaterias;
use Illuminate\Http\Request;
class UpdateUsuariosMaterias
{
    public function handle(Request $request, $id): UsuariosMaterias
    {
        try {
            $data = $request;
            $model = UsuariosMaterias::findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
