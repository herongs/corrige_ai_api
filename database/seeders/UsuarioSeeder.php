<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $usuario = Usuario::firstOrNew(
      array(
        'email' => 'suporte@corrigeai.com.br',
      ),
      array(
        'nome' => 'Suporte',
        'password' => Hash::make('corrigeai2023'),
      )
    );
    $usuario->save();
  }
}
