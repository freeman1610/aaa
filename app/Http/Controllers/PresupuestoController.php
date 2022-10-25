<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\PresupuestoRequest;
use App\Models\Presupuesto;
use Illuminate\Support\Facades\DB;

class PresupuestoController extends Controller
{
    public function listar_pre()
    {
        $selecPresupuesto = DB::table('presupuesto')->select('fondos','administrador', 'created_at', 'presupuestoAnterior', 'presupuestoActual')->orderBy('created_at', 'desc')->get();

        $arrayDeDatos = [];

        foreach ($selecPresupuesto as $dato) {


            $arrayDeDatos[] = [
                "0" => $dato->administrador,
                "1" => $dato->fondos,
                "2" => $dato->presupuestoAnterior,
                "3" => $dato->presupuestoActual,
                "4" => $dato->created_at
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

    public function insertar_pre(PresupuestoRequest $request)
    {

        $ultimoPresupuesto = DB::table('presupuesto')->select('fondos')->latest()->first();

        $newPresupuesto = new Presupuesto;
        $newPresupuesto->fondos = $request->presupuesto;
        $newPresupuesto->presupuestoAnterior = $ultimoPresupuesto->fondos;
        $newPresupuesto->presupuestoActual = ($request->presupuesto + $ultimoPresupuesto->fondos);
        $newPresupuesto->administrador = Auth::user()->nombre.' '.Auth::user()->apellido;
        $newPresupuesto->cedula = Auth::user()->num_documento;
        $newPresupuesto->save();
    }
}
