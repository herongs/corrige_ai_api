<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Provas extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'provas';
    protected $guarded = [];
}