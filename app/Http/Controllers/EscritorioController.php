<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chuto;
use App\Models\Empleado;
use App\Models\Viaje;
use Illuminate\Http\Request;

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
}
