<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class UsuariosMaterias extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'usuarios_materias';
    protected $guarded = [];
}