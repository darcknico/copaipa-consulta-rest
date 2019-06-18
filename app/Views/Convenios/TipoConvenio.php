<?php

namespace App\Views\Convenios;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class TipoConvenio extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_tipoconvenio';

  protected $hidden = [
    'tipo_id',
    'tipo_descri',
  ];

  protected $maps = [
    'id' => 'tipo_id',
    'nombre' => 'tipo_descri',
  ];

  protected $appends = [
    'id',
    'nombre',
  ];
}
