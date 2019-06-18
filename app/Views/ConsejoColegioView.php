<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class ConsejoColegioView extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_listado_consejos_y_colegios';

}
