<?php

namespace App\Http\Controllers;

use App\Views\Convenio;
use App\Views\Convenios\Localidad;
use App\Views\Convenios\Provincia;
use App\Views\Convenios\TipoConvenio;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use Storage;

class ConvenioController extends Controller
{
	public function index(Request $request){
		$start = $request->query('start',"");
		$length = $request->query('length',"");

		$registros = Convenio::with('localidad','tipo')->whereNotNull('convenio_id');

		if(strlen($start)==0 or strlen($length)==0 ){
			return $registros->get();
		}

		$search = $request->query('search',null);
		$id_localidad = $request->query('id_localidad',0);
		$id_provincia = $request->query('id_provincia',0);
		$id_tipo_convenio = $request->query('id_tipo_convenio',0);

		$registros
			->when($id_localidad>0,function($q)use($id_localidad){
				return $q->where('id_localidad',$id_localidad);
			})
			->when($id_provincia>0,function($q)use($id_provincia){
				return $q->whereHas('localidad',function($qt)use($id_provincia){
					$qt->where('id_provincia',$id_provincia);
				});
			})
			->when($id_tipo_convenio!='0',function($q)use($id_tipo_convenio){
				return $q->where('id_tipo_convenio',$id_tipo_convenio);
			});
		$values = explode(" ", $search);
		if(count($values)>0){
			foreach ($values as $key => $value) {
				if(strlen($value)>0){
				$registros = $registros->where(function($query) use  ($value) {
					$query->where('nombre_institucion','like','%'.$value.'%');
					});
				}
			}
		}
		$sql = $registros->toSql();
		$q = clone($registros->getQuery());
		$total_count = $q->count();
		if($length>0){
			$registros = $registros->limit($length);
			if($start>1){
				$registros = $registros->offset($start - 1)->get();
			} else {
				$registros = $registros->get();
			}
		} else {
			$registros = $registros->get();
		}
		return response()->json([
			'total_count'=>intval($total_count),
			'items'=>$registros,
		],200);

	}

	public function localidades(Request $request){
		$id_provincia = $request->query('id_provincia',0);
		$registros = Localidad::when($id_provincia>0,function($q)use($id_provincia){
				return $q->where('id_provincia',$id_provincia);
			})->get();

		return response()->json($registros,200);
	}

	public function provincias(Request $request){
		$todo = Provincia::all();
		return response()->json($todo,200);
	}

	public function tipos(Request $request){
		$todo = TipoConvenio::all();
		return response()->json($todo,200);
	}
}