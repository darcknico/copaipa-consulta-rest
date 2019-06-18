<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class MatriculaConstanciaReciprocidadView extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_matriculados_para_constancia_reciprocidad';

  protected $casts = ['id' => 'string'];

}
