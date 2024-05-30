<?php
namespace App\Actions\Turmas;
use App\Models\Turmas;
use Illuminate\Http\Request;
class CreateTurmas
{
    public function handle(Request $request): Turmas
    {
        try {
            $data = $request->only([
                'descricao',
                'ano',
                'ativo'
            ]);
            return Turmas::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
