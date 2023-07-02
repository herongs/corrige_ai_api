<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;
class Usuario extends Authenticatable implements  Auditable
{
  use SoftDeletes, \OwenIt\Auditing\Auditable;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'usuarios';
    protected $hidden = ['password'];
    protected $guarded = [];
}
