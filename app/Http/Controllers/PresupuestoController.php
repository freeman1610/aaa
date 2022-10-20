<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\DB;

class PresupuestoController extends Controller
{
    public function listar_pre()
    {
        $selecPresupuesto = DB::table('presupuesto')->select('fondos', 'created_at', 'presupuestoAnterior', 'presupuestoActual')->orderBy('created_at', 'desc')->get();

        $arrayDeDatos = [];

        foreach ($selecPresupuesto as $dato) {


            $arrayDeDatos[] = [
                "0" => $dato->fondos,
                "1" => $dato->presupuestoAnterior,
                "2" => $dato->presupuestoActual,
                "3" => $dato->created_at
            ];
        }

        $results = [
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($arrayDeDatos), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($arrayDeDatos), //enviamos el total de registros a visualizar
            "aaData" => $arrayDeDatos
        ];

        return response()->json($results, status: 200);
    }

    public function insertar_pre(Request $request)
    {

        $this->validate($request, [
            'presupuesto' => 'required|numeric|min:0'
        ]);

        $ultimoPresupuesto = DB::table('presupuesto')->select('fondos')->latest()->first();

        $newPresupuesto = new Presupuesto;
        $newPresupuesto->fondos = $request->presupuesto;
        $newPresupuesto->presupuestoAnterior = $ultimoPresupuesto->fondos;
        $newPresupuesto->presupuestoActual = $request->presupuesto;
        $newPresupuesto->save();
    }
}
