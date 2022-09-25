<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cava;
use App\Models\Chofer;
use App\Models\Chuto;
use App\Models\Empleado;
use App\Models\Estado;
use App\Models\Flete;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Viaje;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViajeController extends Controller
{
    public function listar_viajes()
    {
        $selectViajes = Viaje::all();
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
                $fleteIda = Flete::find($datos->viajes_idflete_ida);

                $selectEstado = Estado::find($fleteIda->flete_destino_estado);
                $selectMunicipio = Municipio::find($fleteIda->flete_destino_municipio);
                $selectParroquia = Parroquia::find($fleteIda->flete_destino_parroquia);

                $destinoIda = $selectEstado->estado . ', ' . $selectMunicipio->municipio . ', ' . $selectParroquia->parroquia;
            } else {
                $destinoIda = '(No Aplica) Solo Retorno';
            }
            if ($datos->viajes_idflete_retorno != NULL) {
                $fleteRetorno = Flete::find($datos->viajes_idflete_retorno);

                $selectEstado = Estado::find($fleteRetorno->flete_destino_estado);
                $selectMunicipio = Municipio::find($fleteRetorno->flete_destino_municipio);
                $selectParroquia = Parroquia::find($fleteRetorno->flete_destino_parroquia);

                $destinoRetorno = $selectEstado->estado . ', ' . $selectMunicipio->municipio . ', ' . $selectParroquia->parroquia;
            } else {
                $destinoRetorno = '(No Aplica) Solo Ida';
            }

            $arrayDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" title="Editar" onclick="mostrarViaje(' . $datos->viajes_id . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $datos->viajes_id . ')"><i class="fa fa-trash"></i></button>',
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
        } else {
            $selectFletesDisponibles = Flete::where('fletes.flete_estado', '=', 0)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select('fletes.flete_id', 'fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                ->get();
            if (count($selectFletesDisponibles) == 0) {
                return response()->json(['message' => 'No Hay Fletes para Ida Disponibles, registre los Fletes Necesarios en el Modulo de FLetes'], status: 422);
            }
        }

        $optionFletesIda = '<option value="">Seleccione</option>';
        foreach ($selectFletesDisponibles as $datos) {
            $optionFletesIda = $optionFletesIda . '<option value="' . $datos->flete_id . '">COD: ' . $datos->flete_codigo . ' | Destino: ' . $datos->estado  . ', ' . $datos->municipio  . ', ' . $datos->parroquia . '</option>';
        }
        return response()->json(['fletes_ida' => $optionFletesIda], status: 200);
    }
    public function listar_fletes_retorno(Request $request)
    {
        if (isset($request->flete_no_mostrar)) {
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
        }

        $optionFletesRetorno = '<option value="">Seleccione</option>';
        foreach ($selectFletesDisponibles as $datos) {
            $optionFletesRetorno = $optionFletesRetorno . '<option value="' . $datos->flete_id . '">COD: ' . $datos->flete_codigo . ' | Destino: ' . $datos->estado  . ', ' . $datos->municipio  . ', ' . $datos->parroquia . '</option>';
        }
        return response()->json(['fletes_retorno' => $optionFletesRetorno], status: 200);
    }
    public function crear_viaje(Request $request)
    {
        // Si el viaje tiene flete de ida y retorno
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
            $preguntaFleteRetorno = '<option class="text-danger" value="no">No</option><option class="text-success" value="si">Si</option>';
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
            $preguntaFleteIda = '<option class="text-danger" value="no">No</option><option class="text-success" value="si">Si</option>';
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
        # code...
    }
}
