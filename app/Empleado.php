<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    //

protected $table = "empleados"; /* llama la tabla empleados */

protected $guarded = ['id']; /* evita que se agregen datos a la columna id */

}



