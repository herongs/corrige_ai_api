<?php
namespace App\Actions\UsuariosTurmas;
use App\Models\UsuariosTurmas;
use Illuminate\Http\Request;
class UpdateUsuariosTurmas
{
    public function handle(Request $request, $id): UsuariosTurmas
    {
        try {
            $data = $request;
            $model = UsuariosTurmas::findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
