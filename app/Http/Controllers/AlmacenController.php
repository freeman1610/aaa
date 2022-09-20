<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
{
    public function listar_almacen()
    {
        $selectAlmacen = Almacen::all();

        $returnDatos = array();

        foreach ($selectAlmacen as $datos) {

            $returnDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" onclick="mostrar(' . $datos->idalmacen . ')"><i class="fa fa-edit"></i></button> <button class="btn btn-warning btn-xs" onclick="eliminar(' . $datos->idalmacen . ')"><i class="fa fa-trash"></i></button>',
                "1" => $datos->codigo,
                "2" => $datos->marca,
                "3" => $datos->nombre,
                "4" => $datos->stock,
                "5" => $datos->descripcion,
                "6" => date_format($datos->created_at, 'd-m-Y'),
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

    public function registrar_articulo(Request $request)
    {
        $this->validate($request, [
            'codigo' => 'required',
            'marca' => 'required',
            'nombre' => 'required',
            'stock' => 'required',
            'descripcion' => 'required'
        ]);

        $comprobarCodigo = DB::table('almacen')
            ->select('codigo')
            ->where('codigo', $request->codigo)
            ->get();

        if (isset($comprobarCodigo[0]->codigo)) {
            return response()->json(['message' => 'El Codigo Ingresado Ya Ha Sido Registrado'], status: 422);
        }

        DB::insert('insert into almacen (idusuario, codigo, marca, nombre, stock, descripcion, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?, ?)', [
            Auth::user()->idusuario,
            $request->codigo,
            $request->marca,
            $request->nombre,
            $request->stock,
            $request->descripcion,
            new DateTime(),
            new DateTime()
        ]);
    }
}
