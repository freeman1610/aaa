<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Flete;
use App\Models\Municipio;
use App\Models\Parroquia;
use Illuminate\Http\Request;

class FleteController extends Controller
{
    public function listar_fletes()
    {
        $selectFletes = Flete::all();
        $arrayDatos = [];
        foreach ($selectFletes as $datos) {
            $selectEstado = Estado::find($datos->flete_destino_estado);
            $selectMunicipio = Municipio::find($datos->flete_destino_municipio);
            $selectParroquia = Parroquia::find($datos->flete_destino_parroquia);
            $strDestino = $selectEstado->estado . ', ' . $selectMunicipio->municipio . ', ' . $selectParroquia->parroquia;
            $arrayDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" title="Editar" onclick="mostrar(' . $datos->flete_id . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $datos->flete_id . ')"><i class="fa fa-trash"></i></button>',
                "1" => $datos->flete_codigo,
                "2" => $strDestino,
                "3" => $datos->flete_kilometros,
                "4" => $datos->flete_valor_en_carga,
                "5" => $datos->flete_valor_sin_carga
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
    public function listar_estados()
    {
        $selectEstados = Estado::all();
        $optionEstados = '<option value="">Seleccione</option>';
        foreach ($selectEstados as $datos) {
            $optionEstados = $optionEstados . '<option value="' . $datos->id_estado . '">' . $datos->estado . '</option>';
        }
        return response()->json(['estados' => $optionEstados], status: 200);
    }
    public function listar_municipios(Request $request)
    {
        $this->validate($request, [
            'id_estado' => 'required|numeric'
        ]);
        $selectMunicipios = Municipio::where('id_estado', '=', $request->id_estado)
            ->get();
        $optionMunicipios = '<option value="">Seleccione</option>';
        foreach ($selectMunicipios as $datos) {
            $optionMunicipios = $optionMunicipios . '<option value="' . $datos->id_municipio . '">' . $datos->municipio . '</option>';
        }
        return response()->json(['municipios' => $optionMunicipios], status: 200);
    }
    public function listar_parroquias(Request $request)
    {
        $this->validate($request, [
            'id_municipio' => 'required|numeric'
        ]);
        $selectParroquias = Parroquia::where('id_municipio', '=', $request->id_municipio)
            ->get();
        $optionParroquias = '<option value="">Seleccione</option>';
        foreach ($selectParroquias as $datos) {
            $optionParroquias = $optionParroquias . '<option value="' . $datos->id_parroquia . '">' . $datos->parroquia . '</option>';
        }
        return response()->json(['parroquias' => $optionParroquias], status: 200);
    }
    public function registrar_flete(Request $request)
    {
        // $this->validate($request, [
        //     'id_municipio' => 'required|numeric'
        // ]);
        return $request->all();
    }
}
