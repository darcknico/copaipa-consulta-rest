<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class SubcertificacionesTablaAporteView extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_subcertificaciones_tabla_aportes';

}
