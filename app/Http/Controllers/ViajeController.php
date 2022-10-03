<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cava;
use App\Models\Chofer;
use App\Models\Chuto;
use App\Models\Flete;
use App\Models\Viaje;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViajeController extends Controller
{
    public function listar_viajes()
    {
        $selectViajes = Viaje::where('viajes_estado', '=', 0)->get();
        $arrayDatos = [];
        foreach ($selectViajes as $datos) {

            $selectChofer = DB::table('empleado')
                ->join('choferes', 'choferes.chofer_idempleado', '=', 'empleado.id_emp')
                ->select('empleado.nombre', 'empleado.apellido', 'empleado.cedula')
                ->where('choferes.chofer_idempleado', '=', $datos->viajes_idchofer)
                ->get();

            $datosChofer = '<table style="width: 150px;"><tr><td style="border:none;">' . $selectChofer[0]->nombre . ' ' . $selectChofer[0]->apellido . ' <br> C.I: ' . $selectChofer[0]->cedula . '</td></tr></table>';

            $selectChuto = Chuto::find($datos->viajes_idchuto);
            $selectCava = Cava::find($datos->viajes_idcava);

            $datosChuto = 'Placa: ' . $selectChuto->chuto_placa . '<br>Modelo: ' . $selectChuto->chuto_marca . '<br>Marca: ' . $selectChuto->chuto_modelo;

            $datosCava = 'Placa: ' . $selectCava->cava_placa . '<br>Modelo: ' . $selectCava->cava_marca . '<br>Marca: ' . $selectCava->cava_modelo;

            $datosCamion = '<table class="table table-bordered table-striped dtr-inline" style="width: 250px;"><tr><td>Chuto: </td><td>' . $datosChuto . '</td></tr><tr><td>Cava: </td><td>' . $datosCava . '</td></tr></table>';

            if ($datos->viajes_idflete_ida != NULL) {
                $datosDestinoFleteIda = Flete::where('fletes.flete_id', '=', $datos->viajes_idflete_ida)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select(
                        'estados.estado',
                        'municipios.municipio',
                        'parroquias.parroquia'
                    )
                    ->get();

                $destinoIda = $datosDestinoFleteIda[0]->estado . ', ' . $datosDestinoFleteIda[0]->municipio . ', ' . $datosDestinoFleteIda[0]->parroquia;
            } else {
                $destinoIda = '(No Aplica) Solo Retorno';
            }
            if ($datos->viajes_idflete_retorno != NULL) {
                $datosDetinoFleteRetorno = Flete::where('fletes.flete_id', '=', $datos->viajes_idflete_retorno)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select(
                        'estados.estado',
                        'municipios.municipio',
                        'parroquias.parroquia'
                    )
                    ->get();

                $destinoRetorno = $datosDetinoFleteRetorno[0]->estado . ', ' . $datosDetinoFleteRetorno[0]->municipio . ', ' . $datosDetinoFleteRetorno[0]->parroquia;
            } else {
                $destinoRetorno = '(No Aplica) Solo Ida';
            }

            $arrayDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" title="Editar" onclick="mostrarViaje(' . $datos->viajes_id . ')"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $datos->viajes_id . ')"><i class="fa fa-trash"></i></button> <button class="btn btn-success btn-xs" title="Finalizar Viaje" onclick="viajeCompletado(' . $datos->viajes_id . ')"><i class="fa fa-check"></i></button>',
                "1" => $datos->viajes_codigo,
                "2" => $datosChofer,
                "3" => $datosCamion,
                "4" => '<table class="table table-bordered table-striped dtr-inline" style="width: 250px;"><tr><td> Flete Ida: </td><td>' . $destinoIda . '</td></tr><tr><td>Flete Retorno: </td><td>' . $destinoRetorno . '</td></tr></table>',
                "5" => $datos->viajes_descripciondelacargar,
                "6" => '<table class="table table-bordered table-striped dtr-inline" style="width: 250px;"><tr><td> IDA: </td><td> ' . $datos->viajes_dia_salida . '</td></tr><tr><td>RETORNO:</td><td>' . $datos->viajes_dia_retorno . '</td></tr></table>',
                "7" => $datos->viajes_observaciones
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
    public function listar_crear_viaje()
    {
        $selectChoferesDiponibles = DB::table('choferes')
            ->join('empleado', 'empleado.id_emp', '=', 'choferes.chofer_idempleado')
            ->select('empleado.id_emp', 'empleado.nombre', 'empleado.apellido', 'empleado.cedula')
            ->where('choferes.chofer_estado', '=', 0)
            ->get();
        if (count($selectChoferesDiponibles) == 0) {
            return response()->json(['message' => 'No Hay Choferes Disponibles'], status: 422);
        }

        $selectChutosDisponibles = Chuto::where('chuto_asignado', '=', 0)
            ->where('chuto_estado', '=', 'ACTIVO')
            ->select('chuto_id', 'chuto_placa', 'chuto_modelo', 'chuto_marca')
            ->get();

        if (count($selectChutosDisponibles) == 0) {
            return response()->json(['message' => 'No Hay Chutos Disponibles'], status: 422);
        }

        $selectCavasDisponibles = Cava::where('cava_asignada', '=', 0)
            ->where('cava_estado', '=', 'ACTIVO')
            ->select('cava_id', 'cava_placa', 'cava_modelo', 'cava_marca')
            ->get();

        if (count($selectCavasDisponibles) == 0) {
            return response()->json(['message' => 'No Hay Cavas Disponibles'], status: 422);
        }

        // Creo los option's y los envio en el json

        $optionChoferes = '<option value="">Seleccione</option>';
        foreach ($selectChoferesDiponibles as $datos) {
            $optionChoferes = $optionChoferes . '<option value="' . $datos->id_emp . '">' . $datos->nombre . ' ' . $datos->apellido . ' | C.I: ' . $datos->cedula . '</option>';
        }

        $optionChutos = '<option value="">Seleccione</option>';
        foreach ($selectChutosDisponibles as $datos) {
            $optionChutos = $optionChutos . '<option value="' . $datos->chuto_id . '">' . $datos->chuto_placa . ' | ' . $datos->chuto_modelo . ' | ' . $datos->chuto_marca . '</option>';
        }

        $optionCavas = '<option value="">Seleccione</option>';
        foreach ($selectCavasDisponibles as $datos) {
            $optionCavas = $optionCavas . '<option value="' . $datos->cava_id . '">' . $datos->cava_placa . ' | ' . $datos->cava_modelo . ' | ' . $datos->cava_marca . '</option>';
        }
        return response()->json([
            'choferes' => $optionChoferes,
            'chutos' => $optionChutos,
            'cavas' => $optionCavas
        ], status: 200);
    }
    public function listar_fletes_ida(Request $request)
    {
        if (isset($request->flete_no_mostrar)) {
            // El isset($request->id_viaje_actual) es para la vista actualizar Viaje
            // Se crea para mostrar el flete de ida actual y los que esten disponibles
            if (isset($request->id_viaje_actual)) {
                $selectViajeActual = Viaje::where('viajes_id', '=', $request->id_viaje_actual)
                    ->select('viajes_idflete_ida')
                    ->get();
                if ($selectViajeActual[0]->viajes_idflete_ida != NULL) {
                    $selectFleteActual = Flete::where('fletes.flete_id', '=', $selectViajeActual[0]->viajes_idflete_ida)
                        ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                        ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                        ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                        ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                        ->where('fletes.flete_id', 'not like', $request->flete_no_mostrar)
                        ->get();
                }
                $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                    ->where('fletes.flete_id', 'not like', $request->flete_no_mostrar)
                    ->get();

                if ($selectViajeActual[0]->viajes_idflete_ida != NULL) {
                    $optionFletesIda = '<option value="' . $selectFleteActual[0]->flete_id . '">COD: ' . $selectFleteActual[0]->flete_codigo . ' | ' . $selectFleteActual[0]->estado . ', ' . $selectFleteActual[0]->municipio . ', ' . $selectFleteActual[0]->parroquia . '</option>';
                } else {
                    $optionFletesIda = '<option value="">Seleccione</option>';
                }
            } else {
                // Para crear
                $selectFleteActual = Flete::where('fletes.flete_estado', '=', 0)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                    ->where('fletes.flete_id', 'not like', $request->flete_no_mostrar)
                    ->get();

                $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                    ->where('fletes.flete_id', 'not like', $request->flete_no_mostrar)
                    ->get();
                if (count($selectFletesDisponibles) == 0) {
                    return response()->json(['message' => 'No Hay Fletes para Ida Disponibles, registre los Fletes Necesarios en el Modulo de FLetes'], status: 422);
                }
                $optionFletesIda = '<option value="">Seleccione</option>';
            }
        } else {
            // Vista para Actualizar
            if (isset($request->id_viaje_actual)) {
                $selectViajeActual = Viaje::where('viajes_id', '=', $request->id_viaje_actual)
                    ->select('viajes_idflete_ida')
                    ->get();
                if ($selectViajeActual[0]->viajes_idflete_ida != NULL) {
                    $selectFleteActual = Flete::where('fletes.flete_id', '=', $selectViajeActual[0]->viajes_idflete_ida)
                        ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                        ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                        ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                        ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                        ->get();
                }

                $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                    ->get();

                if ($selectViajeActual[0]->viajes_idflete_ida != NULL) {
                    $optionFletesIda = '<option value="' . $selectFleteActual[0]->flete_id . '">COD: ' . $selectFleteActual[0]->flete_codigo . ' | ' . $selectFleteActual[0]->estado . ', ' . $selectFleteActual[0]->municipio . ', ' . $selectFleteActual[0]->parroquia . '</option>';
                } else {
                    $optionFletesIda = '<option value="">Seleccione</option>';
                }
            } else {
                // Vista para Crear
                $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                    ->get();
                if (count($selectFletesDisponibles) == 0) {
                    return response()->json(['message' => 'No Hay Fletes para Ida Disponibles, registre los Fletes Necesarios en el Modulo de FLetes'], status: 422);
                }
                $optionFletesIda = '<option value="">Seleccione</option>';
            }
        }

        foreach ($selectFletesDisponibles as $datos) {
            $optionFletesIda = $optionFletesIda . '<option value="' . $datos->flete_id . '">COD: ' . $datos->flete_codigo . ' | Destino: ' . $datos->estado  . ', ' . $datos->municipio  . ', ' . $datos->parroquia . '</option>';
        }
        return response()->json(['fletes_ida' => $optionFletesIda], status: 200);
    }
    public function listar_fletes_retorno(Request $request)
    {
        if (isset($request->flete_no_mostrar)) {
            // El isset($request->id_viaje_actual) es para la vista actualizar Viaje
            // Se crea para mostrar el flete de ida actual y los que esten disponibles
            if (isset($request->id_viaje_actual)) {
                $selectViajeActual = Viaje::where('viajes_id', '=', $request->id_viaje_actual)
                    ->select('viajes_idflete_retorno')
                    ->get();
                if ($selectViajeActual[0]->viajes_idflete_retorno != NULL) {
                    $selectFleteActual = Flete::where('fletes.flete_id', '=', $selectViajeActual[0]->viajes_idflete_retorno)
                        ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                        ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                        ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                        ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                        ->get();
                }

                $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                    ->where('fletes.flete_id', 'not like', $request->flete_no_mostrar)
                    ->get();

                if ($selectViajeActual[0]->viajes_idflete_retorno != NULL) {
                    $optionFletesRetorno = '<option value="' . $selectFleteActual[0]->flete_id . '">COD: ' . $selectFleteActual[0]->flete_codigo . ' | ' . $selectFleteActual[0]->estado . ', ' . $selectFleteActual[0]->municipio . ', ' . $selectFleteActual[0]->parroquia . '</option>';
                } else {
                    $optionFletesRetorno = '<option value="">Seleccione</option>';
                }
            } else {
                $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                    ->where('fletes.flete_id', 'not like', $request->flete_no_mostrar)
                    ->get();
                if (count($selectFletesDisponibles) == 0) {
                    return response()->json(['message' => 'No Hay Fletes para Retorno Disponibles, registre los Fletes Necesarios en el Modulo de FLetes'], status: 422);
                }
                $optionFletesRetorno = '<option value="">Seleccione</option>';
            }
        } else {
            if (isset($request->id_viaje_actual)) {
                $selectViajeActual = Viaje::where('viajes_id', '=', $request->id_viaje_actual)
                    ->select('viajes_idflete_ida')
                    ->get();
                if ($selectViajeActual[0]->viajes_idflete_retorno != NULL) {
                    $selectFleteActual = Flete::where('fletes.flete_id', '=', $selectViajeActual[0]->viajes_idflete_retorno)
                        ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                        ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                        ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                        ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                        ->get();
                }
                $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                    ->get();
                if ($selectViajeActual[0]->viajes_idflete_retorno != NULL) {
                    $optionFletesRetorno = '<option value="' . $selectFleteActual[0]->flete_id . '">COD: ' . $selectFleteActual[0]->flete_codigo . ' | ' . $selectFleteActual[0]->estado . ', ' . $selectFleteActual[0]->municipio . ', ' . $selectFleteActual[0]->parroquia . '</option>';
                } else {
                    $optionFletesRetorno = '<option value="">Seleccione</option>';
                }
            } else {
                $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                    ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                    ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                    ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                    ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                    ->get();
                if (count($selectFletesDisponibles) == 0) {
                    return response()->json(['message' => 'No Hay Fletes para Retorno Disponibles, registre los Fletes Necesarios en el Modulo de FLetes'], status: 422);
                }
                $optionFletesRetorno = '<option value="">Seleccione</option>';
            }
        }


        foreach ($selectFletesDisponibles as $datos) {
            $optionFletesRetorno = $optionFletesRetorno . '<option value="' . $datos->flete_id . '">COD: ' . $datos->flete_codigo . ' | Destino: ' . $datos->estado  . ', ' . $datos->municipio  . ', ' . $datos->parroquia . '</option>';
        }
        return response()->json(['fletes_retorno' => $optionFletesRetorno], status: 200);
    }
    public function crear_viaje(Request $request)
    {
        // Si el viaje tiene flete de ida y retorno
        if ($request->comprobar_flete_ida == "no" && $request->comprobar_flete_retorno == "no") {
            return response()->json(['message' => 'Tienes que seleccionar un flete ya sea de IDA o de RETORNO'], status: 422);
        }
        if ($request->comprobar_flete_ida == "si" && $request->comprobar_flete_retorno == "si") {

            if ($request->viaje_flete_ida == $request->viaje_flete_retorno) {
                return response()->json(['message' => 'El Flete de Ida no puede ser el Mismo que el Retorno'], status: 422);
            }

            $this->validate($request, [
                'viaje_codigo' => 'required',
                'viaje_chofer' => 'required|numeric',
                'viaje_chuto' => 'required|numeric',
                'viaje_cava' => 'required|numeric',
                'viaje_flete_ida' => 'required|numeric',
                'viaje_flete_retorno' => 'required|numeric',
                'viaje_descripcion' => 'required',
                'viaje_dia_salida' => 'required|date',
                'viaje_dia_retorno' => 'required|date',
                'viaje_observacion' => 'required'
            ]);
            $comprobarCodigo = DB::table('viajes')
                ->select('viajes_codigo')
                ->where('viajes_codigo', $request->viaje_codigo)
                ->get();

            if (isset($comprobarCodigo[0]->viajes_codigo)) {
                return response()->json(['message' => 'El Codigo Ingresado Ya Ha Sido Registrado'], status: 422);
            }

            DB::table('viajes')->insert([
                'viajes_idusuario'     =>   Auth::user()->idusuario,
                'viajes_codigo'   =>   $request->viaje_codigo,
                'viajes_idchofer' => $request->viaje_chofer,
                'viajes_idchuto' => $request->viaje_chuto,
                'viajes_idcava' => $request->viaje_cava,
                'viajes_idflete_ida' => $request->viaje_flete_ida,
                'viajes_idflete_retorno' => $request->viaje_flete_retorno,
                'viajes_descripciondelacargar' => $request->viaje_descripcion,
                'viajes_dia_salida' => $request->viaje_dia_salida,
                'viajes_dia_retorno' => $request->viaje_dia_retorno,
                'viajes_observaciones' => $request->viaje_observacion,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);

            $chofer = Chofer::where('chofer_idempleado', '=', $request->viaje_chofer)->get();
            $chofer[0]->chofer_estado = 1;
            $chofer[0]->save();

            $chuto = Chuto::find($request->viaje_chuto);
            $chuto->chuto_asignado = 1;
            $chuto->save();

            $cava = Cava::find($request->viaje_cava);
            $cava->cava_asignada = 1;
            $cava->save();

            $fleteIda = Flete::find($request->viaje_flete_ida);
            $fleteIda->flete_estado = 1;
            $fleteIda->flete_tipo = 1;
            $fleteIda->save();

            $fleteRetorno = Flete::find($request->viaje_flete_retorno);
            $fleteRetorno->flete_estado = 1;
            $fleteRetorno->flete_tipo = 2;
            $fleteRetorno->save();

            return response()->json('Fino Pa!', status: 200);
        }
        // Si el viaje solo tiene flete de ida
        if ($request->comprobar_flete_ida == "si" && $request->comprobar_flete_retorno == "no") {
            $this->validate($request, [
                'viaje_codigo' => 'required',
                'viaje_chofer' => 'required|numeric',
                'viaje_chuto' => 'required|numeric',
                'viaje_cava' => 'required|numeric',
                'viaje_flete_ida' => 'required|numeric',
                'viaje_descripcion' => 'required',
                'viaje_dia_salida' => 'required|date',
                'viaje_dia_retorno' => 'required|date',
                'viaje_observacion' => 'required'
            ]);

            $comprobarCodigo = DB::table('viajes')
                ->select('viajes_codigo')
                ->where('viajes_codigo', $request->viaje_codigo)
                ->get();

            if (isset($comprobarCodigo[0]->viajes_codigo)) {
                return response()->json(['message' => 'El Codigo Ingresado Ya Ha Sido Registrado'], status: 422);
            }

            DB::table('viajes')->insert([
                'viajes_idusuario'     =>   Auth::user()->idusuario,
                'viajes_codigo'   =>   $request->viaje_codigo,
                'viajes_idchofer' => $request->viaje_chofer,
                'viajes_idchuto' => $request->viaje_chuto,
                'viajes_idcava' => $request->viaje_cava,
                'viajes_idflete_ida' => $request->viaje_flete_ida,
                'viajes_descripciondelacargar' => $request->viaje_descripcion,
                'viajes_dia_salida' => $request->viaje_dia_salida,
                'viajes_dia_retorno' => $request->viaje_dia_retorno,
                'viajes_observaciones' => $request->viaje_observacion,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);

            $chofer = Chofer::where('chofer_idempleado', '=', $request->viaje_chofer)->get();
            $chofer[0]->chofer_estado = 1;
            $chofer[0]->save();

            $chuto = Chuto::find($request->viaje_chuto);
            $chuto->chuto_asignado = 1;
            $chuto->save();

            $cava = Cava::find($request->viaje_cava);
            $cava->cava_asignada = 1;
            $cava->save();

            $fleteIda = Flete::find($request->viaje_flete_ida);
            $fleteIda->flete_estado = 1;
            $fleteIda->flete_tipo = 1;
            $fleteIda->save();

            return response()->json('Fino Pa!', status: 200);
        }
        // Si el viaje solo tiene flete de retorno
        if ($request->comprobar_flete_ida == "no" && $request->comprobar_flete_retorno == "si") {
            $this->validate($request, [
                'viaje_codigo' => 'required',
                'viaje_chofer' => 'required|numeric',
                'viaje_chuto' => 'required|numeric',
                'viaje_cava' => 'required|numeric',
                'viaje_flete_retorno' => 'required|numeric',
                'viaje_descripcion' => 'required',
                'viaje_dia_salida' => 'required|date',
                'viaje_dia_retorno' => 'required|date',
                'viaje_observacion' => 'required'
            ]);

            $comprobarCodigo = DB::table('viajes')
                ->select('viajes_codigo')
                ->where('viajes_codigo', $request->viaje_codigo)
                ->get();

            if (isset($comprobarCodigo[0]->viajes_codigo)) {
                return response()->json(['message' => 'El Codigo Ingresado Ya Ha Sido Registrado'], status: 422);
            }

            DB::table('viajes')->insert([
                'viajes_idusuario'     =>   Auth::user()->idusuario,
                'viajes_codigo'   =>   $request->viaje_codigo,
                'viajes_idchofer' => $request->viaje_chofer,
                'viajes_idchuto' => $request->viaje_chuto,
                'viajes_idcava' => $request->viaje_cava,
                'viajes_idflete_retorno' => $request->viaje_flete_retorno,
                'viajes_descripciondelacargar' => $request->viaje_descripcion,
                'viajes_dia_salida' => $request->viaje_dia_salida,
                'viajes_dia_retorno' => $request->viaje_dia_retorno,
                'viajes_observaciones' => $request->viaje_observacion,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);

            $chofer = Chofer::where('chofer_idempleado', '=', $request->viaje_chofer)->get();
            $chofer[0]->chofer_estado = 1;
            $chofer[0]->save();

            $chuto = Chuto::find($request->viaje_chuto);
            $chuto->chuto_asignado = 1;
            $chuto->save();

            $cava = Cava::find($request->viaje_cava);
            $cava->cava_asignada = 1;
            $cava->save();

            $fleteRetorno = Flete::find($request->viaje_flete_retorno);
            $fleteRetorno->flete_estado = 1;
            $fleteRetorno->flete_tipo = 2;
            $fleteRetorno->save();

            return response()->json('Fino Pa!', status: 200);
        }
    }
    public function mostrar_viaje(Request $request)
    {
        $this->validate($request, [
            'viaje_id' => 'required|numeric',
        ]);
        $viaje = Viaje::find($request->viaje_id);

        $selectChoferActual = DB::table('choferes')
            ->join('empleado', 'empleado.id_emp', '=', 'choferes.chofer_idempleado')
            ->select('empleado.id_emp', 'empleado.nombre', 'empleado.apellido', 'empleado.cedula')
            ->where('choferes.chofer_idempleado', '=', $viaje->viajes_idchofer)
            ->get();

        $selectChoferesDiponibles = DB::table('choferes')
            ->join('empleado', 'empleado.id_emp', '=', 'choferes.chofer_idempleado')
            ->select('empleado.id_emp', 'empleado.nombre', 'empleado.apellido', 'empleado.cedula')
            ->where('choferes.chofer_estado', '=', 0)
            ->get();

        $optionChoferes = '<option value="' . $selectChoferActual[0]->id_emp . '">' . $selectChoferActual[0]->nombre . ' ' . $selectChoferActual[0]->apellido . ' | C.I: ' . $selectChoferActual[0]->cedula . '</option>';

        foreach ($selectChoferesDiponibles as $datos) {
            $optionChoferes = $optionChoferes . '<option value="' . $datos->id_emp . '">' . $datos->nombre . ' ' . $datos->apellido . ' | C.I: ' . $datos->cedula . '</option>';
        }

        $selectChutoActual = Chuto::where('chuto_id', '=', $viaje->viajes_idchuto)
            ->select('chuto_id', 'chuto_placa', 'chuto_modelo', 'chuto_marca')
            ->get();

        $selectChutosDisponibles = Chuto::where('chuto_asignado', '=', 0)
            ->where('chuto_estado', '=', 'ACTIVO')
            ->select('chuto_id', 'chuto_placa', 'chuto_modelo', 'chuto_marca')
            ->get();

        $optionChutos = '<option value="' . $selectChutoActual[0]->chuto_id . '">' . $selectChutoActual[0]->chuto_placa . ' | ' . $selectChutoActual[0]->chuto_modelo . ' | ' . $selectChutoActual[0]->chuto_marca . '</option>';

        foreach ($selectChutosDisponibles as $datos) {
            $optionChutos = $optionChutos . '<option value="' . $datos->chuto_id . '">' . $datos->chuto_placa . ' | ' . $datos->chuto_modelo . ' | ' . $datos->chuto_marca . '</option>';
        }

        $selectCavaActual = Cava::where('cava_id', '=', $viaje->viajes_idcava)
            ->select('cava_id', 'cava_placa', 'cava_modelo', 'cava_marca')
            ->get();

        $selectCavasDisponibles = Cava::where('cava_asignada', '=', 0)
            ->where('cava_estado', '=', 'ACTIVO')
            ->select('cava_id', 'cava_placa', 'cava_modelo', 'cava_marca')
            ->get();

        $optionCavas = '<option value="' . $selectCavaActual[0]->cava_id . '">' . $selectCavaActual[0]->cava_placa . ' | ' . $selectCavaActual[0]->cava_modelo . ' | ' . $selectCavaActual[0]->cava_marca . '</option>';

        foreach ($selectCavasDisponibles as $datos) {
            $optionCavas = $optionCavas . '<option value="' . $datos->cava_id . '">' . $datos->cava_placa . ' | ' . $datos->cava_modelo . ' | ' . $datos->cava_marca . '</option>';
        }

        if ($viaje->viajes_idflete_ida != NULL) {

            $selectFleteIdaActual = Flete::where('fletes.flete_id', '=', $viaje->viajes_idflete_ida)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                ->get();
            $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                ->get();

            $optionFleteIda = '<option value="' . $selectFleteIdaActual[0]->flete_id . '">COD: ' . $selectFleteIdaActual[0]->flete_codigo . ' | ' . $selectFleteIdaActual[0]->estado . ', ' . $selectFleteIdaActual[0]->municipio . ', ' . $selectFleteIdaActual[0]->parroquia . '</option>';

            foreach ($selectFletesDisponibles as $datos) {
                $optionFleteIda = $optionFleteIda . '<option value="' . $datos->flete_id . '">COD: ' . $datos->flete_codigo . ' | ' . $datos->estado . ', ' . $datos->municipio . ', ' . $datos->parroquia . '</option>';
            }
            $preguntaFleteRetorno = '<option class="text-success" value="si">Si</option><option class="text-danger" value="no">No</option>';
        } else {
            $optionFleteIda = NULL;

            $preguntaFleteRetorno = '<option class="text-success" value="si">Si</option><option class="text-danger" value="no">No</option>';
            $preguntaFleteIda = '<option class="text-danger" value="no">No</option><option class="text-success" value="si">Si</option>';
        }

        if ($viaje->viajes_idflete_retorno != NULL) {

            $selectFleteRetornoActual = Flete::where('fletes.flete_id', '=', $viaje->viajes_idflete_retorno)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                ->get();
            $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                ->get();

            $optionFleteRetorno = '<option value="' . $selectFleteRetornoActual[0]->flete_id . '">COD: ' . $selectFleteRetornoActual[0]->flete_codigo . ' | ' . $selectFleteRetornoActual[0]->estado . ', ' . $selectFleteRetornoActual[0]->municipio . ', ' . $selectFleteRetornoActual[0]->parroquia . '</option>';

            foreach ($selectFletesDisponibles as $datos) {
                $optionFleteRetorno = $optionFleteRetorno . '<option value="' . $datos->flete_id . '">COD: ' . $datos->flete_codigo . ' | ' . $datos->estado . ', ' . $datos->municipio . ', ' . $datos->parroquia . '</option>';
            }
            $preguntaFleteIda = '<option class="text-success" value="si">Si</option><option class="text-danger" value="no">No</option>';
        } else {
            $optionFleteRetorno = NULL;

            $preguntaFleteIda = '<option class="text-success" value="si">Si</option><option class="text-danger" value="no">No</option>';
            $preguntaFleteRetorno = '<option class="text-danger" value="no">No</option><option class="text-success" value="si">Si</option>';
        }

        return response()->json([

            'id' => $viaje->viajes_id,

            'codigo' => $viaje->viajes_codigo,
            'choferes' => $optionChoferes,
            'chutos' => $optionChutos,
            'cavas' => $optionCavas,

            'pregunta_ida' => $preguntaFleteIda,
            'flete_ida' => $optionFleteIda,

            'pregunta_retorno' => $preguntaFleteRetorno,
            'flete_retorno' => $optionFleteRetorno,

            'descripcion_carga' => $viaje->viajes_descripciondelacargar,
            'dia_salida' => $viaje->viajes_dia_salida,
            'dia_retorno' => $viaje->viajes_dia_retorno,
            'observacion' => $viaje->viajes_observaciones

        ], status: 200);
    }

    public function update_viaje(Request $request)
    {
        // Para actualizar un viaje hay que verificar de que cada uno de los select del form
        // se hayan cambiado (Chofer, Chuto, Cava, Flete Ida, Flete Retorno)
        // si se han cambiado, hay que actualizar cada unos de itemes mencionados
        // pasando su estado a sin asignar (Disponible)
        // de lo contrario, no se modifica nada

        $this->validate($request, [
            'comprobar_flete_ida' => 'required',
            'comprobar_flete_retorno' => 'required',
            'id_viaje' => 'required|numeric',
            'viaje_codigo' => 'required',
            'viaje_chofer' => 'required|numeric',
            'viaje_chuto' => 'required|numeric',
            'viaje_cava' => 'required|numeric',
            'viaje_descripcion' => 'required',
            'viaje_dia_salida' => 'required|date',
            'viaje_dia_retorno' => 'required|date',
            'viaje_observacion' => 'required'
        ]);

        $selectViaje = Viaje::find($request->id_viaje);
        $cambiosBase = $cambioChofer = $cambioChuto = $cambioCava = $cambioFleteIda = $cambioFleteRetorno  = 0;

        if ($request->viaje_codigo != $selectViaje->viajes_codigo) {
            $selectViaje->viajes_codigo = $request->viaje_codigo;
            $cambiosBase++;
        }
        if ($request->viaje_chofer != $selectViaje->viajes_idchofer) {

            $chofer = Chofer::find($selectViaje->viajes_idchofer);
            $chofer->chofer_estado = 0;

            $selectViaje->viajes_idchofer  = $request->viaje_chofer;

            $choferNuevo = Chofer::find($request->viaje_chofer);
            $choferNuevo->chofer_estado = 1;

            $cambioChofer++;
        }
        if ($request->viaje_chuto != $selectViaje->viajes_idchuto) {

            $chuto = Chuto::find($selectViaje->viajes_idchuto);
            $chuto->chuto_asignado = 0;

            $selectViaje->viajes_idchuto = $request->viaje_chuto;

            $chutoNuevo = Chuto::find($request->viaje_chuto);
            $chutoNuevo->chuto_asignado = 1;

            $cambioChuto++;
        }
        if ($request->viaje_cava != $selectViaje->viajes_idcava) {

            $cava = Cava::find($selectViaje->viajes_idcava);
            $cava->cava_asignada = 0;

            $selectViaje->viajes_idcava = $request->viaje_cava;

            $cavaNueva = Cava::find($request->viaje_cava);
            $cavaNueva->cava_asignada = 1;

            $cambioCava++;
        }
        if ($request->comprobar_flete_ida == "no" && $request->comprobar_flete_retorno == "no") {
            return response()->json(['message' => 'Tienes que seleccionar un flete ya sea de IDA o de RETORNO'], status: 422);
        }
        if ($request->comprobar_flete_ida == "si" && $request->comprobar_flete_retorno == "si") {
            $this->validate($request, [
                'viaje_flete_ida' => 'required|numeric',
                'viaje_flete_retorno' => 'required|numeric'
            ]);
            if ($request->viaje_flete_ida != $selectViaje->viajes_idflete_ida) {
                if ($selectViaje->viajes_idflete_ida != NULL) {
                    $fleteIda = Flete::find($selectViaje->viajes_idflete_ida);
                    $fleteIda->flete_estado = 0;
                    $fleteIda->flete_tipo = 0;
                }

                $selectViaje->viajes_idflete_ida = $request->viaje_flete_ida;

                $fleteIdaNuevo = Flete::find($request->viaje_flete_ida);
                $fleteIdaNuevo->flete_estado = 1;
                $fleteIdaNuevo->flete_tipo = 1;

                $cambioFleteIda++;
            }
            if ($request->viaje_flete_retorno != $selectViaje->viajes_idflete_retorno) {

                if ($selectViaje->viajes_idflete_retorno != NULL) {
                    $fleteRetorno = Flete::find($selectViaje->viajes_idflete_retorno);
                    $fleteRetorno->flete_estado = 0;
                    $fleteRetorno->flete_tipo = 0;
                }

                $selectViaje->viajes_idflete_retorno = $request->viaje_flete_retorno;

                $fleteRetornoNuevo = Flete::find($request->viaje_flete_retorno);
                $fleteRetornoNuevo->flete_estado = 1;
                $fleteRetornoNuevo->flete_tipo = 2;

                $cambioFleteRetorno++;
            }
        }
        if ($request->comprobar_flete_ida == "si" && $request->comprobar_flete_retorno == "no") {
            $this->validate($request, [
                'viaje_flete_ida' => 'required|numeric',
            ]);
            if ($request->viaje_flete_ida != $selectViaje->viajes_idflete_ida) {

                if ($selectViaje->viajes_idflete_ida != NULL) {
                    $fleteIda = Flete::find($selectViaje->viajes_idflete_ida);
                    $fleteIda->flete_estado = 0;
                    $fleteIda->flete_tipo = 0;
                }

                $selectViaje->viajes_idflete_ida = $request->viaje_flete_ida;

                $fleteIdaNuevo = Flete::find($request->viaje_flete_ida);
                $fleteIdaNuevo->flete_estado = 1;
                $fleteIdaNuevo->flete_tipo = 1;

                $cambioFleteIda++;
            }
            if ($selectViaje->viajes_idflete_retorno != NULL) {
                $fleteRetorno = Flete::find($selectViaje->viajes_idflete_retorno);
                $fleteRetorno->flete_estado = 0;
                $fleteRetorno->flete_tipo = 0;

                $selectViaje->viajes_idflete_retorno = NULL;

                $cambioFleteRetorno++;
            }
        }
        if ($request->comprobar_flete_ida == "no" && $request->comprobar_flete_retorno == "si") {
            $this->validate($request, [
                'viaje_flete_retorno' => 'required|numeric'
            ]);
            if ($request->viaje_flete_retorno != $selectViaje->viajes_idflete_retorno) {

                if ($selectViaje->viajes_idflete_retorno != NULL) {
                    $fleteRetorno = Flete::find($selectViaje->viajes_idflete_retorno);
                    $fleteRetorno->flete_estado = 0;
                    $fleteRetorno->flete_tipo = 0;
                }

                $selectViaje->viajes_idflete_retorno = $request->viaje_flete_retorno;

                $fleteRetornoNuevo = Flete::find($request->viaje_flete_retorno);
                $fleteRetornoNuevo->flete_estado = 1;
                $fleteRetornoNuevo->flete_tipo = 2;

                $cambioFleteRetorno++;
            }
            if ($selectViaje->viajes_idflete_ida != NULL) {
                $fleteIda = Flete::find($selectViaje->viajes_idflete_ida);
                $fleteIda->flete_estado = 0;
                $fleteIda->flete_tipo = 0;

                $selectViaje->viajes_idflete_ida = NULL;

                $cambioFleteIda++;
            }
        }
        if ($request->viaje_descripcion != $selectViaje->viajes_descripciondelacargar) {
            $selectViaje->viajes_descripciondelacargar = $request->viaje_descripcion;
            $cambiosBase++;
        }
        if ($request->viaje_dia_salida != $selectViaje->viajes_dia_salida) {
            $selectViaje->viajes_dia_salida = $request->viaje_dia_salida;
            $cambiosBase++;
        }
        if ($request->viaje_dia_retorno != $selectViaje->viajes_dia_retorno) {
            $selectViaje->viajes_dia_retorno = $request->viaje_dia_retorno;
            $cambiosBase++;
        }
        if ($request->viaje_observacion != $selectViaje->viajes_observaciones) {
            $selectViaje->viajes_observaciones = $request->viaje_observacion;
            $cambiosBase++;
        }

        if ($cambioChofer != 0) {
            $chofer->save();
            $choferNuevo->save();
        }

        if ($cambioChuto != 0) {
            $chuto->save();
            $chutoNuevo->save();
        }

        if ($cambioCava != 0) {
            $cava->save();
            $cavaNueva->save();
        }

        if ($cambioFleteIda != 0) {
            if (isset($fleteIda)) {
                $fleteIda->save();
            }
            if (isset($fleteIdaNuevo)) {
                $fleteIdaNuevo->save();
            }
        }

        if ($cambioFleteRetorno != 0) {
            $fleteRetorno->save();
            if (isset($fleteRetornoNuevo)) {
                $fleteRetornoNuevo->save();
            }
        }

        if ($cambiosBase != 0 || $cambioChofer != 0 || $cambioChuto != 0 || $cambioCava != 0 || $cambioFleteIda != 0 || $cambioFleteRetorno != 0) {
            $selectViaje->save();
            return response()->json(['message' => 'Datos Actualizados Correctamente'], status: 200);
        } else {
            return response()->json(['message' => 'No se han detectado cambios'], status: 200);
        }
    }
    public function viaje_completado(Request $request)
    {
        $this->validate($request, [
            'id_viaje' => 'required|numeric'
        ]);
        $viajeCompletado = Viaje::find($request->id_viaje);

        $chofer = Chofer::where('chofer_idempleado', '=', $viajeCompletado->viajes_idchofer)->get();
        $chofer[0]->chofer_estado = 0;

        $chuto = Chuto::find($viajeCompletado->viajes_idchuto);
        $chuto->chuto_asignado = 0;

        $cava = Cava::find($viajeCompletado->viajes_idcava);
        $cava->cava_asignada = 0;

        $fleteIda = $fleteRetorno = false;

        // Compruebo de que en este viaje exista flete ida
        if ($viajeCompletado->viajes_idflete_ida != NULL) {
            $selectFleteIda = Flete::find($viajeCompletado->viajes_idflete_ida);
            // El flete en estado del tipo 2 significa de que ha sido completado
            $selectFleteIda->flete_estado = 2;
            $fleteIda = true;
        }
        if ($viajeCompletado->viajes_idflete_retorno != NULL) {
            $selectFleteRetorno = Flete::find($viajeCompletado->viajes_idflete_retorno);
            // El flete en estado del tipo 2 significa de que ha sido completado
            $selectFleteRetorno->flete_estado = 2;
            $fleteRetorno = true;
        }

        // Viaje esta con el valor de 1 significa que ha sido completado
        $viajeCompletado->viajes_estado = 1;

        $chofer[0]->save();

        $chuto->save();

        $cava->save();

        if ($fleteIda) {
            $selectFleteIda->save();
        }
        if ($fleteRetorno) {
            $selectFleteRetorno->save();
        }

        $viajeCompletado->save();

        // Inserto los datos del viaje en la tabla nomina_choferes
        // Se hace este proceso para optimizar la consulta para luego realizar
        // Tanto el pago como la busqueda datos relacionados a nomina choferes

        DB::table('nomina_choferes')->insert([
            'id_chofer'  => $viajeCompletado->viajes_idchofer,
            'id_viaje'   => $viajeCompletado->viajes_id,
            'pago_total' => 0,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        ]);
        return response()->json('Fino Pa', status: 200);
    }
    public function viaje_delete(Request $request)
    {
        $this->validate($request, [
            'id_viaje' => 'required|numeric'
        ]);

        $viaje = Viaje::find($request->id_viaje);

        if ($viaje->viajes_estado == 1) {
            return response()->json([
                'message' => 'No puedes Eliminar un Viaje Completado'
            ], status: 422);
        }

        $chofer = Chofer::find($viaje->viajes_idchofer);
        $chofer->chofer_estado = 0;

        $chuto = Chuto::find($viaje->viajes_idchuto);
        $chuto->chuto_asignado = 0;

        $cava = Cava::find($viaje->viajes_idcava);
        $cava->cava_asignada = 0;

        // Compruebo de que en este viaje exista flete ida
        if ($viaje->viajes_idflete_ida != NULL) {
            $selectFleteIda = Flete::find($viaje->viajes_idflete_ida);
            $selectFleteIda->flete_estado = 0;
        }
        if ($viaje->viajes_idflete_retorno != NULL) {
            $selectFleteRetorno = Flete::find($viaje->viajes_idflete_retorno);
            $selectFleteRetorno->flete_estado = 0;
        }
        $chofer->save();

        $chuto->save();

        $cava->save();

        Viaje::destroy($request->id_viaje);

        return response()->json('Fino Pa', status: 200);
    }
}
