<?php

namespace App\Http\Controllers;

use App\Models\Tipousuario;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TipoUsuarioController extends Controller
{
    public function listar_tipousuario()
    {
        $seleccionDeTipoUsuarios = DB::table('tipousuario')->select()->get();

        $arrayDeDatos = array();

        foreach ($seleccionDeTipoUsuarios as $dato) {
            $arrayDeDatos[]=array(
                "0"=>'<button class="btn btn-primary btn-xs" onclick="mostrar('.$dato->idtipousuario.')"><i class="fa fa-edit"></i></button>',
                "1"=>$dato->nombre_t,
                "2"=>$dato->descripcion,
                "3"=>$dato->created_at
            );
        }

        $results=array(
            "sEcho"=>1,//info para datatables
            "iTotalRecords"=>count($arrayDeDatos),//enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($arrayDeDatos),//enviamos el total de registros a visualizar
            "aaData"=>$arrayDeDatos);
        
        return response()->json($results, status: 200);
    }

    public function mostrar_tipousuario(Request $request)
    {
        $seleccionarTiposDeUsuario = DB::table('tipousuario')->select('idtipousuario', 'nombre_t', 'descripcion')->where('idtipousuario', $request->idtipousuario)->get();

        return response()->json($seleccionarTiposDeUsuario[0], status: 200);
    }

    public function guardar_tipousuario(Request $request)
    {

        $selecCampo = Tipousuario::find($request->idtipousuario);

        $selecCampo->descripcion = $request->descripcion;

        $selecCampo->save();

    }

}
