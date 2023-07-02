<?php
namespace App\Actions\Usuarios;
use App\Models\Usuarios;
use Illuminate\Http\Request;
class UpdateUsuarios
{
    public function handle(Request $request, $id): Usuarios
    {
        try {
            $data = $request->only([
                'nome',
                'email',
                'password',
                'estado_id',
                'cidade_id',
                'cpf',
                'telefone',
                'cep',
                'bairro',
                'logradouro',
                'numero',
                'complemento',
            ]);
            $model = Usuarios::findOrFail($id);
            $model->fill($data);
            $model->save();
            return $model;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
