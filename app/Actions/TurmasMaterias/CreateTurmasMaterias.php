<?php
namespace App\Actions\TurmasMaterias;
use App\Models\TurmasMaterias;
use Illuminate\Http\Request;
class CreateTurmasMaterias
{
    public function handle(Request $request): TurmasMaterias
    {
        try {
            $data = $request;
            return TurmasMaterias::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
