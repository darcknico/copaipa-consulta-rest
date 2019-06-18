<?php

namespace App\Http\Controllers;

use App\User;
use App\Views\AfiliadoAlDiaActivoView;
use App\Views\ConsejoColegioView;
use App\Views\MatriculaConstanciaReciprocidadView;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Storage;
use JasperPHP\JasperPHP; 

class UsuarioController extends Controller
{

    public function concidencias(Request $request){
      $email = $request->query('email','');
      if(empty($email)){
      	$email = '';
      }
      $todo = User::where('email','like',$email)
        ->first();
      if($todo){
        $response['coincidencia'] = 1;
      } else {
        $response['coincidencia'] = 0;
      }
      return response()->json($response, 200);
    }

}
