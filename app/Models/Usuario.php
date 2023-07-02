<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Usuario extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'usuarios';
    protected $hidden = ['password'];
    protected $guarded = [];
}
