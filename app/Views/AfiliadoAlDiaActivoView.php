<?php

namespace App\Views;

use App\Views\MatriculaConstanciaReciprocidadView;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

class AfiliadoAlDiaActivoView extends Model
{
  use Eloquence, Mappable;

  protected $table ='afiliados_al_dia_activos';

  protected $casts = ['id' => 'string'];

  protected $appends = [
  	'reciprocidad'
  ]; 

  protected function getReciprocidadAttribute(){
  	$todo = MatriculaConstanciaReciprocidadView::where('id','like',$this['id'])->first();
  	return $todo;
  }
}
