<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Turmas extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'turmas';
    protected $guarded = [];
}