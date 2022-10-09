<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cava;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CavaController extends Controller
{
    public function listar_cavas()
    {
        $selectCavas = Cava::all();
        $arrayDatos = array();
        foreach ($selectCavas as $datos) {
            $arrayDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" title="Editar" onclick="updateCava(' . $datos->cava_id . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $datos->cava_id . ')"><i class="fa fa-trash"></i></button>',
                "1" => $datos->cava_placa,
                "2" => $datos->cava_modelo,
                "3" => $datos->cava_marca,
                "4" => $datos->cava_estado
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

    public function registrar_cava(Request $request)
    {
        $this->validate($request, [
            'cava_placa' => 'required',
            'cava_modelo' => 'required',
            'cava_marca' => 'required',
            'cava_estado' => 'required'
        ]);
        $comprobarPlaca = DB::table('cavas')
            ->select('cava_placa')
            ->where('cava_placa', $request->cava_placa)
            ->get();

        if (isset($comprobarPlaca[0]->cava_placa)) {
            return response()->json(['message' => 'La Placa Ingresado Ya Ha Sido Registrado'], status: 422);
        }

        $newCava = new Cava;
        $newCava->cava_idusuario =  Auth::user()->idusuario;
        $newCava->cava_placa = $request->cava_placa;
        $newCava->cava_modelo = $request->cava_modelo;
        $newCava->cava_marca = $request->cava_marca;
        $newCava->cava_estado = $request->cava_estado;
        $newCava->save();
    }
    public function mostrar_cava(Request $request)
    {
        $this->validate($request, [
            'cava_id' => 'required|numeric'
        ]);
        $selectChuto = Cava::find($request->cava_id);
        $option = '';
        switch ($selectChuto->cava_estado) {
            case 'ACTIVO':
                $option = '<option value="ACTIVO">ACTIVO</option><option value="TALLER">TALLER</option><option value="FUERA DE SERVICIO">FUERA DE SERVICIO</option>';
                break;
            case 'TALLER':
                $option = '<option value="TALLER">TALLER</option><option value="ACTIVO">ACTIVO</option><option value="FUERA DE SERVICIO">FUERA DE SERVICIO</option>';
                break;
            case 'FUERA DE SERVICIO':
                $option = '<option value="FUERA DE SERVICIO">FUERA DE SERVICIO</option><option value="ACTIVO">ACTIVO</option><option value="TALLER">TALLER</option>';
                break;
        };

        return response()->json([$selectChuto, $option], status: 200);
    }
    public function actualizar_cava(Request $request)
    {
        $this->validate($request, [
            'cava_id' => 'required|numeric',
            'cava_placa' => 'required',
            'cava_modelo' => 'required',
            'cava_marca' => 'required',
            'cava_estado' => 'required'
        ]);
        $selectChuto = Cava::find($request->cava_id);

        $selectChuto->cava_placa = $request->cava_placa;
        $selectChuto->cava_modelo = $request->cava_modelo;
        $selectChuto->cava_marca = $request->cava_marca;
        $selectChuto->cava_estado = $request->cava_estado;

        $selectChuto->save();

        return response()->json('Fino Pa', status: 200);
    }
    public function eliminar_cava(Request $request)
    {
        $this->validate($request, [
            'cava_id' => 'required|numeric'
        ]);
        Cava::destroy($request->cava_id);
        return response()->json('Fino Pa', status: 200);
    }
}
