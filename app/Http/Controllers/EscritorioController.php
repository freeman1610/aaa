<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chuto;
use App\Models\Empleado;
use App\Models\Viaje;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EscritorioController extends Controller
{
    public function count_items_index()
    {
        $selectViajesCount = Viaje::where('viajes_estado', 0)->count();
        $selectEmpleadoCount = Empleado::count();

        return response()->json([
            'viajes' => $selectViajesCount,
            'empleados' => $selectEmpleadoCount
        ], status: 200);
    }

    // Metodo que trae los chutos mas usados durante el mes 
    public function chutos_mes()
    {
        $selectPlacas = Viaje::whereBetween('viajes.viajes_dia_salida', [date('Y-m-1'), date('Y-m-30')])
            ->join('chutos', 'chutos.chuto_id', '=', 'viajes.viajes_idchuto')
            ->select('chutos.chuto_placa')
            ->get();
        $selectChutos = Chuto::select('chuto_placa')->get();

        $xd = 0;
        $placas = '';
        $numViajes = '';
        foreach ($selectChutos as $placaChuto) {
            foreach ($selectPlacas as $placaViaje) {
                if ($placaViaje->chuto_placa == $placaChuto->chuto_placa) {
                    $xd++;
                }
            }
            $placas = $placas . '"' . $placaChuto->chuto_placa . '",';
            $numViajes = $numViajes . $xd . ',';
            $xd = 0;
        }
        $placas = substr($placas, 0, -1);
        $numViajes = substr($numViajes, 0, -1);
        return response()->json([
            'placas' => $placas,
            'numViajes' => $numViajes
        ], status: 200);
    }

    // Metodo que Trae los estados mas visitados del mes
    public function estados_mes(){
        // $selectEstado = Viaje::whereBetween('viajes.viajes_dia_salida',[date('Y-m-1'),date('Y-m-30')])->join('estados','estados.id_estado','=','viajes.viajes_estado')->select('estados.estado')->get()->toArray();
        $prueba = DB::table('viajes')->select('estado',DB::raw('count(*) as total'))
        ->join('estados','estados.id_estado','=','viajes.viajes_estado')
        ->groupBy('estado')->whereBetween('viajes.viajes_dia_salida',[date('Y-m-1'),date('Y-m-30')])->get()->toArray();
        
        $estados = [];
        $totalEstados = [];

        // usamos un ciclo for para guardar los elemento de interes en un array usando la funcion array_push
        for($i=0; $i<count($prueba);$i++)
        {
            array_push($estados,$prueba[$i]->estado); 
            array_push($totalEstados,$prueba[$i]->total);
        }

        // retornar el arreglo como json para recibirlo con ajax
        return response()->json([
            'estados' => $estados,
            'totalEstados' => $totalEstados
        ],status:200);
       

    }
}
