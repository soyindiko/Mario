<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CinePelicula extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cines_peliculas';

    use SoftDeletes;
}
