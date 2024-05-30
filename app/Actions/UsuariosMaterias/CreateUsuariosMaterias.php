<?php
namespace App\Actions\UsuariosMaterias;
use App\Models\UsuariosMaterias;
use Illuminate\Http\Request;
class CreateUsuariosMaterias
{
    public function handle(Request $request): UsuariosMaterias
    {
        try {
            $data = $request;
            return UsuariosMaterias::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
