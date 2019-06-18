<?php

namespace App\Views\Convenios;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class Localidad extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_localidades_convenios';

  protected $hidden = [
    'localidad_id',
    'localidad',
  ];

  protected $maps = [
    'id' => 'localidad_id',
    'nombre' => 'localidad',
  ];

  protected $appends = [
    'id',
    'nombre',
  ];

  public function provincia(){
    return $this->hasOne('App\Views\Convenios\Provincia','id_provincia','id_provincia');
  }
}
