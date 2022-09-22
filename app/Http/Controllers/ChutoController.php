<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chuto;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChutoController extends Controller
{
    public function listar_chutos()
    {
        $selectChutos = Chuto::all();
        $arrayDatos = array();
        foreach ($selectChutos as $datos) {
            $arrayDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" title="Editar" onclick="updateChuto(' . $datos->chuto_id . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $datos->chuto_id . ')"><i class="fa fa-trash"></i></button>',
                "1" => $datos->chuto_placa,
                "2" => $datos->chuto_modelo,
                "3" => $datos->chuto_marca,
                "4" => $datos->chuto_estado
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

    public function registrar_chuto(Request $request)
    {
        $this->validate($request, [
            'chuto_placa' => 'required',
            'chuto_modelo' => 'required',
            'chuto_marca' => 'required',
            'chuto_estado' => 'required'
        ]);
        $comprobarPlaca = DB::table('chutos')
            ->select('chuto_placa')
            ->where('chuto_placa', $request->chuto_placa)
            ->get();

        if (isset($comprobarPlaca[0]->chuto_placa)) {
            return response()->json(['message' => 'La Placa Ingresado Ya Ha Sido Registrado'], status: 422);
        }
        DB::insert('insert into chutos (chuto_idusuario, chuto_placa, chuto_modelo, chuto_marca, chuto_estado, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?)', [
            Auth::user()->idusuario,
            $request->chuto_placa,
            $request->chuto_modelo,
            $request->chuto_marca,
            $request->chuto_estado,
            new DateTime(),
            new DateTime()
        ]);
    }
    public function mostrar_chuto(Request $request)
    {
        $this->validate($request, [
            'chuto_id' => 'required|numeric'
        ]);
        $selectChuto = Chuto::find($request->chuto_id);
        $option = '';
        switch ($selectChuto->chuto_estado) {
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
    public function actualizar_chuto(Request $request)
    {
        $this->validate($request, [
            'chuto_id' => 'required|numeric',
            'chuto_placa' => 'required',
            'chuto_modelo' => 'required',
            'chuto_marca' => 'required',
            'chuto_estado' => 'required'
        ]);
        $selectChuto = Chuto::find($request->chuto_id);

        $selectChuto->chuto_placa = $request->chuto_placa;
        $selectChuto->chuto_modelo = $request->chuto_modelo;
        $selectChuto->chuto_marca = $request->chuto_marca;
        $selectChuto->chuto_estado = $request->chuto_estado;

        $selectChuto->save();

        return response()->json('Fino Pa', status: 200);
    }
    public function eliminar_chuto(Request $request)
    {
        $this->validate($request, [
            'chuto_id' => 'required|numeric'
        ]);
        Chuto::destroy($request->chuto_id);
        return response()->json('Fino Pa', status: 200);
    }
}
