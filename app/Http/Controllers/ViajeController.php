<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cava;
use App\Models\Chofer;
use App\Models\Chuto;
use App\Models\Empleado;
use App\Models\Flete;
use App\Models\Viaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViajeController extends Controller
{
    public function listar_viajes()
    {
        $selectViajes = Viaje::all();
        $arrayDatos = [];
        foreach ($selectViajes as $datos) {

            $selectChofer = DB::table('empleado')
                ->join('empleado', 'choferes.chofer_id', '=', 'empleado.id_emp')
                ->select('empleado.nombre', 'empleado.apellido')
                ->where('choferes.chofer_id', '=', $datos->viajes_idchofer)
                ->get();

            // $selectChuto = Chuto::find($datos->viajes_idchuto);
            // $selectCava = Cava::find($datos->viajes_idcava);

            // $fleteIda = Flete::find($datos->viajes_idflete_ida);
            // $fleteRetorno = Flete::find($datos->viajes_idflete_retorno);

            $arrayDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" title="Editar" onclick="mostrarFlete(' . $datos->viajes_id . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $datos->viajes_id . ')"><i class="fa fa-trash"></i></button>',
                "1" => $datos->viajes_codigo,
                "2" => $selectChofer[0]->nombre . ' ' . $selectChofer[0]->apellido,
                "3" => '<table class="table"><tr><td> contenido </td><td> xd</td></tr><tr><td> dos</td><td>AAA</td></tr></table>',
                "4" => $datos->viajes_descripciondelacargar,
                "5" => '<table class="table"><tr><td> contenido </td><td> xd</td></tr><tr><td> dos</td><td>AAA</td></tr></table>',
                "6" => $datos->viajes_observaciones
                // "7" => $tipo_flete
            ];
        }
        $results = [
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($arrayDatos), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($arrayDatos), //enviamos el total de registros a visualizar
            "aaData" => $arrayDatos
        ];
        return response()->json($results, status: 200);
    }
}
