<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\Flete;
use App\Models\NominaChofer;
use App\Models\Viaje;
use Illuminate\Http\Request;

class NominaChoferesController extends Controller
{
    public function listar_nomina_chofer()
    {
        $selectNominaChofer = NominaChofer::where('estado', '=', 1)->get();

        $arrayDatos = [];

        foreach ($selectNominaChofer as $datos) {
            $selectChofer = Empleado::find($datos->id_chofer);
            $datosChofer = 'Nombre: ' . $selectChofer->nombre . '<br>Apellido: ' . $selectChofer->apellido . '<br>Cedula: ' . $selectChofer->cedula;
            $selectCodViaje = Viaje::where('viajes_id', '=', $datos->id_viaje)
                ->select('viajes_codigo')
                ->get();
            $viaje = 'Codigo del Viaje: <span class="text-warning">' . $selectCodViaje[0]->viajes_codigo . '</span><hr class="border-primary"><div class="d-flex justify-content-center"><button class="btn btn-primary" onclick="verViaje(' . $datos->id_viaje . ')">Ver Viaje</button></div>';
            $arrayDatos[] = [
                '0' => 'Icons',
                '1' => $datosChofer,
                '2' => $viaje,
                '3' => 'VES ' . $datos->pago_total
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
    public function mostrar_pagos_disponibles()
    {
        $selectPagosPendientes = NominaChofer::where('estado', '=', 0)
            ->select('id_viaje')
            ->get();
        if (count($selectPagosPendientes) == 0) {
            return response()->json([
                'error' => '1',
                'message' => 'No hay Pagos Pendientes'
            ], status: 200);
        }
        $optionViajesPendientes = '<option value="">Seleccione</option>';
        foreach ($selectPagosPendientes as $datos) {
            $selectViaje = Viaje::where('viajes_id', '=', $datos->id_viaje)
                ->select('viajes_codigo')
                ->get();
            $optionViajesPendientes = $optionViajesPendientes . '<option value="' . $datos->id_viaje . '">' . $selectViaje[0]->viajes_codigo . '</option>';
        }
        return response()->json(['viajes' => $optionViajesPendientes], status: 200);
    }
    public function listar_datos_viaje(Request $request)
    {
        $this->validate($request, [
            'viaje_id' => 'required|numeric'
        ]);
        $selectViaje = Viaje::where('viajes_id', '=', $request->viaje_id)
            ->select('viajes_idchofer', 'viajes_idflete_ida', 'viajes_idflete_retorno')
            ->get();
        if ($selectViaje[0]->viajes_idflete_ida != NULL) {
            $fleteIda = Flete::find($selectViaje[0]->viajes_idflete_ida);
            $fleteIdaCod = $fleteIda->flete_codigo;
            $sumaFleteIda = number_format($fleteIda->flete_valor_en_carga + $fleteIda->flete_valor_sin_carga, 3, '.', '');
        } else {
            $fleteIdaCod = 'No Aplica';
            $sumaFleteIda = 0;
        }
        if ($selectViaje[0]->viajes_idflete_retorno != NULL) {
            $fleteRetorno = Flete::find($selectViaje[0]->viajes_idflete_retorno);
            $fleteRetornoCod = $fleteRetorno->flete_codigo;
            $sumaFleteRetorno = number_format($fleteRetorno->flete_valor_en_carga + $fleteRetorno->flete_valor_sin_carga, 3, '.', '');
        } else {
            $fleteRetornoCod = 'No Aplica';
            $sumaFleteRetorno = 0;
        }

        $sumaTotal = number_format($sumaFleteIda + $sumaFleteRetorno, 3, '.', '');
        $totalChofer = number_format($sumaTotal * 0.15, 3, '.', '');
        // Chofer
        $selectChofer = Empleado::where('id_emp', '=', $selectViaje[0]->viajes_idchofer)
            ->select('nombre', 'apellido', 'cedula')
            ->get();
        $idNomina = NominaChofer::where('id_viaje', '=', $request->viaje_id)
            ->select('id_nomina_chofer')
            ->get();
        return response()->json([
            'idNomina' => $idNomina[0]->id_nomina_chofer,
            'datosChofer' => $selectChofer[0]->nombre . ' ' . $selectChofer[0]->apellido . '<br> C.I: ' . $selectChofer[0]->cedula,
            'cod_flete_ida' => $fleteIdaCod,
            'cod_flete_retorno' => $fleteRetornoCod,
            'suma_valores_fletes' => $sumaTotal,
            'total_chofer' => $totalChofer
        ], status: 200);
    }
    public function crear_pago_nomina_chofer(Request $request)
    {
        $this->validate($request, [
            'viaje_id' => 'required|numeric',
            'id_nomina' => 'required|numeric',
            'value_pago_chofer' => 'required'
        ]);
        $selectPagoNominaChofer = NominaChofer::find($request->id_nomina);
        $selectPagoNominaChofer->pago_total = $request->value_pago_chofer;
        $selectPagoNominaChofer->estado = 1;
        $selectPagoNominaChofer->save();
        return response()->json('Fino Pa', status: 200);
    }
}
