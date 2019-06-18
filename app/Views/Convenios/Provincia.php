<?php

namespace App\Views\Convenios;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class Provincia extends Model
{
  use Eloquence, Mappable;

  protected $table ='view_provincias_convenios';

  protected $hidden = [
    'id_provincia',
    'provincia',
  ];

  protected $maps = [
    'id' => 'id_provincia',
    'nombre' => 'provincia',
  ];

  protected $appends = [
    'id',
    'nombre',
  ];

}
