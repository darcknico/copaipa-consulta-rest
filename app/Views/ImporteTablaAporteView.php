<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class ImporteTablaAporteView extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_importes_tabla_aportes';

}
