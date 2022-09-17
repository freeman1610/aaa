<?php

namespace App\Http\Controllers;

use App\Models\Salario;
use Illuminate\Support\Facades\DB;

class SalarioController extends Controller
{
    public function muestra_salario_base()
    {

        $selectSalarioBase = Salario::find(1);

        $numeroConFormato = number_format($selectSalarioBase->salario, 2);

        return response()->json($numeroConFormato, status: 200);
    }
}
