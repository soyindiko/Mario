<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlimentoVenta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alimentos_ventas';

    use SoftDeletes;
}
