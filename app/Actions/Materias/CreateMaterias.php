<?php
namespace App\Actions\Materias;
use App\Models\Materias;
use Illuminate\Http\Request;
class CreateMaterias
{
    public function handle(Request $request): Materias
    {
        try {
            $data = $request->only([
                'descricao',

                'ativo'
            ]);
            return Materias::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
