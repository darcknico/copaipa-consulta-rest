<?php

namespace App\Http\Controllers;

use App\Views\DescripcionTablaAporteView;
use App\Views\DetalleTablaAporteView;
use App\Views\ImporteTablaAporteView;
use App\Views\SubcertificacionesTablaAporteView;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Storage;
use JasperPHP\JasperPHP; 

class TablaAporteController extends Controller
{

  public function tabla(Request $request)
  {
  	$todo = DescripcionTablaAporteView::all();
  	return response()->json($todo,200);
  }

  public function importes(Request $request){
    $id_tarea = $request->query('id_tarea',0);
    $id_subtarea = $request->query('id_subtarea',0);
    $id_subcategoria = $request->query('id_subcategoria',0);

    $todo = ImporteTablaAporteView::where([
      'id_tarea' => $id_tarea,
      'id_subtarea' => $id_subtarea,
      'id_subcategoria' => $id_subcategoria,
    ])->orderBy('tacrtimportes_secuencia','asc')->get();

    return response()->json($todo,200);
  }

  public function detalles(Request $request){
    $id_tarea = $request->query('id_tarea',0);
    $id_subtarea = $request->query('id_subtarea',0);
    $id_subcategoria = $request->query('id_subcategoria',0);
    $importe = $request->query('importe',0);

    $todo = DetalleTablaAporteView::where([
      'tacrt_id' => $id_tarea,
      'tasubcrt_id' => $id_subtarea,
      'tatarsubcrt_id' => $id_subcategoria,
    ])
    ->where('tacrtimportes_desde','<=',$importe)
    ->where('tacrtimportes_hasta','>=',$importe)
    ->first();
    if(!$todo){
      $todo = DetalleTablaAporteView::where([
      'tacrt_id' => $id_tarea,
      'tasubcrt_id' => $id_subtarea,
      'tatarsubcrt_id' => $id_subcategoria,
      ])
      ->where('tacrtimportes_hasta','<',$importe)
      ->orderBy('tacrtimportes_hasta','desc')
      ->first();
    }

    $descuento = SubcertificacionesTablaAporteView::where([
      'tacrt_id' => $id_tarea,
      'tasubcrt_id' => $id_subtarea,
      'tatarsubcrt_id' => $id_subcategoria,
    ])
    ->first();

    return response()->json([
      'detalle'=>$todo,
      'descuento'=>$descuento, 
    ],200);
  }

  public function subcertificaciones(Request $request){
    $id_tarea = $request->query('id_tarea',0);
    $id_subtarea = $request->query('id_subtarea',0);
    $id_subcategoria = $request->query('id_subcategoria',0);

    $todo = SubcertificacionesTablaAporteView::where([
      'tacrt_id' => $id_tarea,
      'tasubcrt_id' => $id_subtarea,
      'tatarsubcrt_id' => $id_subcategoria,
    ])
    ->first();

    return response()->json($todo,200);
  }

  public function reporte(Request $request){
    $detalles = [
      'data' => json_decode($request->getContent(),true),
    ];
    $json = 'reportes/'.uniqid().'.json';
    \Storage::put($json, json_encode($detalles));
    $json_file = storage_path("app/".$json);
    $jasper = new JasperPHP;
    $input = storage_path("app/reportes/copaipa_consulta_aportes.jrxml");
    $output = storage_path("app/reportes/".uniqid());
    $ext = "pdf";

    $jasper->process(
        $input,
        $output,
        [$ext],
        [
          'REPORT_LOCALE' => 'es',
          "logo" => storage_path("app/logo/logo.png"),
        ],
        [
          "driver"=>"json",
          "json_query" => "data",
          "data_file" =>  $json_file
        ]
    )->execute();
    
    $file = base64_encode(file_get_contents($output . '.' . $ext));
    $filename ='copaipa_detalle_aportes';

    unlink($output. '.'  . $ext);
    unlink($json_file);
    /*
    header('Access-Control-Allow-Origin: *');
    header('Content-Description: application/pdf');
    header('Content-Type: application/pdf');
    header('Content-Disposition:attachment; filename=' . $filename . '.' . $ext);
    readfile($output . '.' . $ext);
    
    flush();
    */
    return response()->json([
      'filename' => $filename,
      'file' => $file,
    ],200);
  }

  public function reporte_test(Request $request){
    $detalles = [
      'data' => json_decode($request->getContent(),true),
    ];
    $json = 'reportes/'.uniqid().'.json';
    \Storage::put($json, json_encode($detalles));
    $json_file = storage_path("app/".$json);
    $jasper = new JasperPHP;
    $input = storage_path("app/reportes/copaipa_consulta_aportes.jrxml");
    $output = storage_path("app/reportes/".uniqid());
    $ext = "pdf";

    $jasper->process(
        $input,
        $output,
        [$ext],
        [
          'REPORT_LOCALE' => 'es',
          "logo" => storage_path("app/logo/logo.png"),
        ],
        [
          "driver"=>"json",
          "json_query" => "data",
          "data_file" =>  $json_file
        ]
    )->execute();
    
    $file = base64_encode(file_get_contents($output . '.' . $ext));
    $filename ='copaipa_detalle_aportes.pdf';

    return response()->download(
        $output . '.' . $ext, 
        $filename,
        ['Content-Type: application/pdf'])->deleteFileAfterSend();
  }
}