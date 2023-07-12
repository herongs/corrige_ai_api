<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class GabaritoQuestoes extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'gabarito_questoes';
    protected $guarded = [];
}