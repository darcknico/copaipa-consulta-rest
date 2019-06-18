<?php

namespace App\Http\Controllers;

use App\Views\AfiliadoAlDiaActivoView;
use App\Views\ConsejoColegioView;
use App\Views\MatriculaConstanciaReciprocidadView;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Storage;
use JasperPHP\JasperPHP; 

class AfiliadoController extends Controller
{
	public function buscar(Request $request){
		$matricula = $request->input('matricula',null);
		if($matricula==null){
			return response()->json([
				'error' => 'Matricula invalida.',
			],403);
		}
		$afiliado = AfiliadoAlDiaActivoView::where('id','like',$matricula)->first();
		if(!$afiliado){
			return response()->json([
				'error' => 'El matriculado no se encuentra o usted no tiene su matricula al dia.',
			],403);
		}

		return response()->json($afiliado,200);
	}

	public function certificado_convenio(Request $request){
		$matricula = $request->route('matricula');
	    $jasper = new JasperPHP;
	    $input = storage_path("app/reportes/copaipa_consulta_matricula.jasper");
	    $output = storage_path("app/reportes/".uniqid());
	    $ext = "pdf";

	    $jasper->process(
	        $input,
	        $output,
	        [$ext],
	        [
				'REPORT_LOCALE' => 'es',
				"logo" => storage_path("app/logo/logo_copaipa_2.png"),
				"firma" => storage_path("app/logo/firma.png"),
				"matricula" => $matricula,
	        ],
	        \Config::get('database.connections.mysql')
	    )->execute();
	    
	    $file = base64_encode(file_get_contents($output . '.' . $ext));
	    $filename ='copaipa_matricula_'.$matricula.'_convenio.pdf';
	    unlink($output. '.'  . $ext);

	    return response()->json([
	      'filename' => $filename,
	      'file' => $file,
	    ],200);
	}

	public function certificado_comun(Request $request){
		$matricula = $request->route('matricula');
	    $jasper = new JasperPHP;
	    $input = storage_path("app/reportes/copaipa_consulta_matricula_comun.jasper");
	    $output = storage_path("app/reportes/".uniqid());
	    $ext = "pdf";

	    $jasper->process(
	        $input,
	        $output,
	        [$ext],
	        [
				'REPORT_LOCALE' => 'es',
				"logo" => storage_path("app/logo/logo_copaipa_2.png"),
				"firma" => storage_path("app/logo/firma.png"),
				"matricula" => $matricula,
	        ],
	        \Config::get('database.connections.mysql')
	    )->execute();
	    
	    $file = base64_encode(file_get_contents($output . '.' . $ext));
	    $filename ='copaipa_matricula_'.$matricula.'_comun.pdf';
	    unlink($output. '.'  . $ext);

	    return response()->json([
	      'filename' => $filename,
	      'file' => $file,
	    ],200);
	}

	public function certificado_reciprocidad(Request $request){
		$matricula = $request->route('matricula');

		$id_colegio = $request->input('id_colegio');

	    $jasper = new JasperPHP;
	    $input = storage_path("app/reportes/copaipa_consulta_matricula_reciprocidad.jasper");
	    $output = storage_path("app/reportes/".uniqid());
	    $ext = "pdf";

	    $jasper->process(
	        $input,
	        $output,
	        [$ext],
	        [
				'REPORT_LOCALE' => 'es',
				"logo" => storage_path("app/logo/logo_copaipa_2.png"),
				"firma" => storage_path("app/logo/firma.png"),
				"matricula" => $matricula,
				"id_colegio" => $id_colegio,
	        ],
	        \Config::get('database.connections.mysql')
	    )->execute();
	    
	    $file = base64_encode(file_get_contents($output . '.' . $ext));
	    $filename ='copaipa_matricula_'.$matricula.'_reciprocidad.pdf';
	    unlink($output. '.'  . $ext);

	    return response()->json([
	      'filename' => $filename,
	      'file' => $file,
	    ],200);
	}

	public function consejos_colegios(Request $request){
		$todo = ConsejoColegioView::all();

		return response()->json($todo,200);
	}


}