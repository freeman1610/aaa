<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function listar_almacen()
    {
        $selectAlmacen = Almacen::all();

        $returnDatos = array();

        foreach ($selectAlmacen as $datos) {

            $returnDatos[] = [
                "0" => ($datos->condicion) ? '<button class="btn btn-primary btn-xs" onclick="mostrar(' . $datos->idalmacen . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" onclick="desactivar(' . $datos->idalmacen . ')"><i class="fa fa-close"></i></button>' . ' ' . '<button class="btn btn-warning btn-xs" onclick="eliminar(' . $datos->idalmacen . ')"><i class="fa fa-trash"></i></button>' : '<button class="btn btn-warning btn-xs" onclick="eliminar(' . $datos->idalmacen . ')"><i class="fa fa-trash"></i></button>' . ' ' . '<button class="btn btn-primary btn-xs" onclick="activar(' . $datos->idalmacen . ')"><i class="fa fa-check"></i></button>',
                "1" => $datos->codigo,
                "2" => $datos->nombre,
                "3" => $datos->stock,
                "4" => $datos->descripcion,
                "5" => $datos->created_at,
                "6" => ($datos->condicion) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
            ];
        }

        $results = [
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($returnDatos), //enviamos el total de registros al returnDatostable
            "iTotalDisplayRecords" => count($returnDatos), //enviamos el total de registros a visualizar
            "aaData" => $returnDatos
        ];

        return response()->json($results, status: 200);

        // return $selectAlmacen;
    }
}
