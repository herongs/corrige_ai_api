<?php
namespace App\Actions\UsuariosTurmas;
use App\Models\UsuariosTurmas;
use Illuminate\Http\Request;
class CreateUsuariosTurmas
{
    public function handle(Request $request): UsuariosTurmas
    {
        try {
            $data = $request;
            return UsuariosTurmas::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
