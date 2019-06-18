<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class DetalleTablaAporteView extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_detalle_tabla_aportes';

}
