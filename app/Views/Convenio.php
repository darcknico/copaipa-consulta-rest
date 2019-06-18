<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class Convenio extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_convenios';

  protected $hidden = [
    'convenio_id',
    'nombre_institucion',
    'tipo_id',
    'localidad_id',
  ];

  protected $maps = [
    'id' => 'convenio_id',
    'institucion_nombre' => 'nombre_institucion',
    'id_tipo_convenio' => 'tipo_id',
    'id_localidad' => 'localidad_id',
  ];

  protected $appends = [
    'id',
    'institucion_nombre',
    'id_tipo_convenio',
    'id_localidad',
  ];

  public function localidad(){
    return $this->hasOne('App\Views\Convenios\Localidad','localidad_id','localidad_id');
  }

  public function tipo(){
    return $this->hasOne('App\Views\Convenios\TipoConvenio','tipo_id','tipo_id');
  }
}
