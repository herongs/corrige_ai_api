<?php
namespace App\Actions\Alunos;
use App\Models\Alunos;
use Illuminate\Http\Request;
class CreateAlunos
{
    public function handle(Request $request): Alunos
    {
        try {
            $data = $request->only([
                'nome',
                'turma_id',
                'matricula'
            ]);
            return Alunos::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
