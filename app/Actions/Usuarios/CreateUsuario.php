<?php
namespace App\Actions\Usuarios;
use App\Models\Usuarios;
use Illuminate\Http\Request;
class CreateUsuarios
{
    public function handle(Request $request): Usuarios
    {
        try {
            $data = $request->only([
                'descricao',
            ]);
            return Usuarios::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}