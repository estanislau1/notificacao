<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicador extends \Eloquent
{
    
	use SoftDeletes;

		protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $table = "INDICADOR";
    protected $primaryKey = "id_indicador";

}
