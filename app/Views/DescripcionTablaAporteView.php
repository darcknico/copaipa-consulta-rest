<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class DescripcionTablaAporteView extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_descripcion_tabla_aportes';

}
