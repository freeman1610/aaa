<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Flete;
use App\Models\NominaChofer;
use App\Models\Viaje;
use Illuminate\Http\Request;

class ViajeCompletadoController extends Controller
{
    public function listar_viaje_completado()
    {
        $selectViajesCompletados = Viaje::where('viajes_estado', '=', 1)
            ->select('viajes_id', 'viajes_codigo', 'viajes_idchofer')
            ->get();

        $arrayDatos = [];
        foreach ($selectViajesCompletados as $datos) {
            $comprobarPagoChofer = NominaChofer::where('id_viaje', '=', $datos->viajes_id)
                ->select('estado')
                ->get();
            // return $comprobarPagoChofer;
            if (isset($comprobarPagoChofer[0])) {
                if ($comprobarPagoChofer[0]->estado == 1) {
                    $pago = '<div class="d-flex justify-content-center"><span class="btn btn-success">Cancelado</span></div>';
                }
                if ($comprobarPagoChofer[0]->estado == 0) {
                    $pago = '<div class="d-flex justify-content-center"><span class="btn btn-warning">Sin Cancelar</span></div>';
                }
            }

            // $botonVerDetalles = '<button class="btn btn-primary btn-xs" title="Detalles" onclick="detallesViaje(' . $datos->viajes_id . ')"><i class="fa fa-edit"></i></button>';
            $botonVerDetalles = '<div class="d-flex justify-content-center"><button class="btn btn-primary" title="Detalles" onclick="detallesViaje(' . $datos->viajes_id . ', `' . $datos->viajes_codigo . '`)"><i class="fas fa-eye"></i> Ver Detalles</button></div>';
            $botonPDF = '<button class="btn btn-primary btn-xs" title="Imprimir PDF" onclick="pdfViajeCompletado(' . $datos->viajes_id . ')"><i class="fas fa-file-pdf"></i></button>';

            $arrayDatos[] = [
                "0" => $botonPDF,
                "1" => $datos->viajes_codigo,
                "2" => $botonVerDetalles,
                "3" => $pago

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
    // ------------------------------
    public function detalle_viaje_completado(Request $request)
    {
        $this->validate($request, [
            'id_viaje' => 'required|numeric'
        ]);
        $selectViajesCompletados = Viaje::where('viajes.viajes_id', '=', $request->id_viaje)
            ->where('viajes_estado', '=', 1)
            ->join('empleado', 'empleado.id_emp', '=', 'viajes.viajes_idchofer')
            ->join('chutos', 'chutos.chuto_id', '=', 'viajes.viajes_idchuto')
            ->join('cavas', 'cavas.cava_id', '=', 'viajes.viajes_idcava')
            ->select(
                'viajes.viajes_codigo',
                'empleado.nombre',
                'empleado.apellido',
                'empleado.cedula',
                'chutos.chuto_placa',
                'chutos.chuto_modelo',
                'chutos.chuto_marca',
                'cavas.cava_placa',
                'cavas.cava_modelo',
                'cavas.cava_marca',
                'viajes.viajes_descripciondelacargar',
                'viajes.viajes_dia_salida',
                'viajes.viajes_dia_retorno',
                'viajes.viajes_observaciones'
            )
            ->get();
        // Compruebo de que la consulta no venga vacia, si viene vacia
        // significa que en teoria el viaje no ha sido completado
        if (!isset($selectViajesCompletados[0])) {
            return response()->json(['message' => 'Error: Este viaje no ha sido completado'], status: 200);
        }
        // Compruebdo si existe fleete de ida

        $fleteIda = $fleteRetorno = Viaje::find($request->id_viaje);
        if ($fleteIda->viajes_idflete_ida != NULL) {
            $seletFleteIda = Flete::where('fletes.flete_id', '=', $fleteIda->viajes_idflete_ida)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select(
                    'fletes.flete_codigo',
                    'fletes.flete_valor_en_carga',
                    'fletes.flete_valor_sin_carga',
                    'estados.estado',
                    'municipios.municipio',
                    'parroquias.parroquia'
                )
                ->get();
        } else {
            $seletFleteIda = NULL;
        }

        if ($fleteRetorno->viajes_idflete_retorno != NULL) {
            $seletFleteRetorno = Flete::where('fletes.flete_id', '=', $fleteRetorno->viajes_idflete_retorno)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select(
                    'fletes.flete_codigo',
                    'fletes.flete_valor_en_carga',
                    'fletes.flete_valor_sin_carga',
                    'estados.estado',
                    'municipios.municipio',
                    'parroquias.parroquia'
                )
                ->get();
        } else {
            $seletFleteRetorno = NULL;
        }

        return response()->json([
            'datos-principales' => $selectViajesCompletados[0],
            'flete-ida' => $seletFleteIda,
            'flete-retorno' => $seletFleteRetorno
        ], status: 200);
    }
}
