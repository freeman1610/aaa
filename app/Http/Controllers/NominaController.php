<?php

namespace App\Http\Controllers;

use App\Models\AsignacionNomina;
use App\Models\DeduccionNomina;
use App\Models\Empleado;
use App\Models\Nomina;
use App\Models\Salario;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NominaController extends Controller
{
    public function guardar_update_nomina(Request $request)
    {
        $this->validate($request, [
            'id_nomina' => 'required',
            'id_empleado_a' => 'required',
            'salario_a' => 'required',
            'tipo_nomina_a' => 'required',
            'inicio_pago_a' => 'required',
            'dias_lab_a' => 'required',
            'dias_lib_a' => 'required',
            'hora_d_a' => 'required',
            'hora_n_a' => 'required'
        ]);

        // $selectEmpleado = Empleado::find($request->id_emp);

        // return $request->all();
    }

    public function crear_nomina(Request $request)
    {
        $this->validate($request, [
            'id_empleado_a' => 'required',
            'tipo_nomina_a' => 'required',
            'inicio_pago_a' => 'required',
            'dias_lab_a' => 'required|numeric|min:0',
            'dias_lib_a' => 'required|numeric|min:0',
            'hora_d_a' => 'required|numeric|min:0',
            'hora_n_a' => 'required|numeric|min:0'
        ]);

        // Convertimos los valores a Numericos

        $traerSalario = Salario::find(1, ['salario']);
        $salario_mensual = floatval($traerSalario->salario);
        $dias_laborados = intval($request->dias_lab_a);
        $dias_libres = intval($request->dias_lib_a);
        $horasD = intval($request->hora_d_a);
        $horasN = intval($request->hora_n_a);
        $inicioP = $request->inicio_pago_a;

        $tipo_nomina = $request->tipo_nomina_a;
        $inicio_pago = date("Y-m-d", strtotime($inicioP));

        // usamos la funcion number_format para pasar solo 2 decimales ejmp 456,23

        $salario_diario = $salario_mensual / 30;
        $salario_hora = $salario_diario / 8;

        // Calculos de Asignaciones de ley Nomina
        $pago_diasLab = $dias_laborados * $salario_diario;
        $pago_diasLib = $dias_libres * $salario_diario;
        $pago_hora_extraD = ($salario_hora * 1.5) * $horasD;
        $pago_hora_extraN = ($salario_hora * 1.8) * $horasN;
        $subtotalAsignaciones = floatval($pago_diasLab + $pago_diasLib + $pago_hora_extraD + $pago_hora_extraN);
        $subtotalAsignacion = round($subtotalAsignaciones, 2);
        // Verifico el tipo de nomina enviado por el request
        switch ($tipo_nomina) {
            case 'quincenal':
                //sumo 15 día
                $fin_pago = date("Y-m-d", strtotime($inicio_pago . "+ 15 days"));
                $sSo = ($salario_mensual * 12) / 52 * (0.04 * 2);
                $lph = ($salario_mensual / 100) / 2;
                $paro_forzoso = ($salario_mensual * 12) / 52 * (0.005 * 2);
                $subTotalDeducciones = floatval($sSo + $paro_forzoso + $lph);
                $subTotalDeduccion = round($subTotalDeducciones, 2);
                //Total a Pagar
                $total_pago = ($subtotalAsignacion - $subTotalDeduccion) / 2;
                $tipo_nomina = 'Quincenal';
                break;

            case 'mensual':
                //sumo 30 día
                $fin_pago = date("Y-m-d", strtotime($inicio_pago . "+ 30 days"));
                $sSo = ($salario_mensual * 12) / 52 * (0.04 * 4);
                $lph = $salario_mensual / 100;
                $paro_forzoso = ($salario_mensual * 12) / 52 * (0.005 * 4);
                $subTotalDeducciones = floatval($sSo + $paro_forzoso + $lph);
                $subTotalDeduccion = round($subTotalDeducciones, 2);
                //Total a Pagar
                $total_pago = $subtotalAsignacion - $subTotalDeduccion;
                $tipo_nomina = 'Mensual';
                break;

            default:
                return response()->json('El tipo nomina ingresado no coincide con ninguno registrado', status: 422);
                break;
        }

        //Total a Pagar
        $total_pago = $subtotalAsignacion - $subTotalDeduccion;

        DB::insert(
            'insert into pago_nomina (id_empleado,id_usuario,salario_mensual,tipo_nomina,inicio_pago,fin_pago,total_asignaciones,total_deducciones,total_pago,fecha_nomina,created_at,updated_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->id_empleado_a,
                Auth::user()->idusuario,
                $salario_mensual,
                $tipo_nomina,
                $inicio_pago,
                $fin_pago,
                $subtotalAsignacion,
                $subTotalDeduccion,
                $total_pago,
                new DateTime(),
                new DateTime(),
                new DateTime()
            ]
        );

        // Luego de realizar el pago de nomina (insert en pago_nomina) se procede a hacer insercion
        // en la tabla asignacion_nomina y deduccion_nomina

        $return_id_pago_nomina = DB::table('pago_nomina')->select('id_nomina')->latest()->first();

        DB::insert(
            'insert into asignacion_nomina (id_nomina,dias_lab,pagos_diasLab,dias_libres,pagos_DiaLib,horas_extra_diurna,pago_hr_extraD,horas_extra_noc,pago_hr_extra_noc,created_at,updated_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $return_id_pago_nomina->id_nomina,
                $dias_laborados,
                $pago_diasLab,
                $dias_libres,
                $pago_diasLib,
                $horasD,
                $pago_hora_extraD,
                $horasN,
                $pago_hora_extraN,
                new DateTime(),
                new DateTime()
            ]
        );

        DB::insert(
            'insert into deduccion_nomina (id_nomina,sso,paro_forzoso,lph,subtotal,created_at,updated_at) values (?, ?, ?, ?, ?, ?, ?)',
            [
                $return_id_pago_nomina->id_nomina,
                $sSo,
                $paro_forzoso,
                $lph,
                $subTotalDeduccion,
                new DateTime(),
                new DateTime()
            ]
        );
    }

    public function listar_nomina()
    {
        $selecNomina = DB::table('pago_nomina')
            ->join('empleado', 'pago_nomina.id_empleado', '=', 'empleado.id_emp')
            ->select('pago_nomina.*', 'empleado.nombre', 'empleado.apellido')
            ->get();

        $arrayDeDatos = [];

        foreach ($selecNomina as $dato) {
            $arrayDeDatos[] = [
                "0" => '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $dato->id_nomina . ')"><i class="fa fa-trash"></i></button><a target="_blank" href="pagoNominaPDF?idNomina=' . $dato->id_nomina . '" title="Generar PDF"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>',
                "1" => $dato->nombre . ' ' . $dato->apellido,
                "2" => 'VES ' . $dato->salario_mensual,
                "3" => $dato->tipo_nomina,
                "4" => $dato->inicio_pago,
                "5" => $dato->fin_pago,
                "6" => $dato->total_asignaciones,
                "7" => '-' . $dato->total_deducciones,
                "8" => $dato->total_pago
            ];
        }

        $results = [
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($arrayDeDatos), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($arrayDeDatos), //enviamos el total de registros a visualizar
            "aaData" => $arrayDeDatos
        ];

        return response()->json($results, status: 200);
    }
    public function mostrar_salario()
    {
        // El find 1 es para trabajar con el salario base
        $selectSalario = Salario::find(1);

        $salarioMensual = number_format($selectSalario->salario, 2);

        $salarioQuincenal = number_format($salarioMensual / 2, 2);

        $salarioDiario = number_format($salarioMensual / 30, 2);

        $salarioHora = number_format($salarioDiario / 8, 2);

        $res = [
            'salarioMensual' => $salarioMensual,
            'salarioQuincenal' => $salarioQuincenal,
            'salarioDiario' => $salarioDiario,
            'salarioHora' => $salarioHora
        ];

        return response()->json($res, status: 200);
    }

    public function mostrar_salario_update()
    {
        // El find 1 es para trabajar con el salario base
        $selectSalario = Salario::find(1);

        $salarioMensual = number_format($selectSalario->salario, 2);

        $res = [
            'salarioMensual' => $salarioMensual
        ];

        return response()->json($res, status: 200);
    }

    public function update_salario_base(Request $request)
    {
        $this->validate($request, [
            'salario_base' => 'required|numeric|min:1'
        ]);

        $selectSalarioBaseActual = Salario::find(1);

        $selectSalarioBaseActual->salario = $request->salario_base;

        $selectSalarioBaseActual->save();
    }

    public function pagoNominaPDF(Request $request, Fpdf $fpdf)
    {

        $this->validate($request, [
            'idNomina' => 'required|numeric',
        ]);

        $selectPagoNomina = Nomina::find($request->idNomina);

        $selectEmpleado = Empleado::find($selectPagoNomina->id_empleado);

        $selectAsignacionNomina = AsignacionNomina::where('id_nomina', '=', $selectPagoNomina->id_nomina)
            ->get();

        $selectDeduccionNomina = DeduccionNomina::where('id_nomina', '=', $selectPagoNomina->id_nomina)
            ->get();

        $selectSalario = Salario::find(1);

        $salarioMensual = number_format($selectSalario->salario, 2);

        $salarioQuincenal = number_format($salarioMensual / 2, 2);

        $salarioDiario = number_format($salarioMensual / 30, 2);



        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 20);
        $textypos = 5;
        $fpdf->Image(asset('vendor/images/lagarra.png'), 45, 8, -800);
        $fpdf->setY(12);
        $fpdf->setX(60);



        // Agregamos los datos de la empresa
        $fpdf->Cell(5, $textypos, "Transporte La Garra C.A");
        $fpdf->SetFont('Arial', 'B', 8);
        $fpdf->setY(13);
        $fpdf->setX(145);
        $fpdf->Cell(5, $textypos, "RIF: J-13698756-1");

        $espacioIzquierda = 60;

        $espaciadoLetrasDerecha = 105;

        // Agregamos los datos del cliente
        $fpdf->SetFont('Arial', 'B', 15);
        $fpdf->setY(25);
        $fpdf->setX(65);
        $fpdf->Cell(5, $textypos, "RECIBO DE PAGO DE SALARIO");
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->setY(35);
        $fpdf->setX($espacioIzquierda);
        $fpdf->Cell(5, $textypos, "PERIODO LABORADO:");

        $fpdf->setY(35);
        $fpdf->setX($espaciadoLetrasDerecha);
        $fpdf->Cell(5, $textypos, "DEL " . date_format(new DateTime($selectPagoNomina->inicio_pago), 'Y/m/d') . "  AL " . date_format(new DateTime($selectPagoNomina->fin_pago), 'Y/m/d'));

        $fpdf->setY(45);
        $fpdf->setX($espacioIzquierda);
        $fpdf->Cell(5, $textypos, "Apellidos y Nombres:");

        $fpdf->setY(45);
        $fpdf->setX($espaciadoLetrasDerecha);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode($selectEmpleado->nombre . ' ' . $selectEmpleado->apellido));

        $fpdf->setY(55);
        $fpdf->setX($espacioIzquierda);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Cedula de Identidad:");

        $fpdf->setY(55);
        $fpdf->setX($espaciadoLetrasDerecha);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, $selectEmpleado->cedula);

        $fpdf->setY(65);
        $fpdf->setX($espacioIzquierda);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Sueldo Mensual:");

        $fpdf->setY(65);
        $fpdf->setX($espaciadoLetrasDerecha);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, "VES " . $salarioMensual);

        $fpdf->setY(75);
        $fpdf->setX($espacioIzquierda);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Sueldo Quincenal");

        $fpdf->setY(75);
        $fpdf->setX($espaciadoLetrasDerecha);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, "VES " . $salarioQuincenal);

        $fpdf->setY(85);
        $fpdf->setX($espacioIzquierda);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Sueldo Diario:");

        $fpdf->setY(85);
        $fpdf->setX($espaciadoLetrasDerecha);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, "VES " . $salarioDiario);

        $fpdf->setY(95);
        $fpdf->setX($espacioIzquierda);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Fecha de Pago:");

        $fpdf->setY(95);
        $fpdf->setX($espaciadoLetrasDerecha);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, date_format(new DateTime($selectPagoNomina->fecha_nomina), 'd-m-Y'));

        $fpdf->setY(105);
        $fpdf->setX($espacioIzquierda);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Cargo:");

        $fpdf->setY(105);
        $fpdf->setX($espaciadoLetrasDerecha);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode($selectEmpleado->cargo));

        $fpdf->setY(115);
        $fpdf->setX($espacioIzquierda);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Fecha de Ingreso:");

        $fpdf->setY(115);
        $fpdf->setX($espaciadoLetrasDerecha);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, date_format(new DateTime($selectEmpleado->fecha_ingreso), 'd-m-Y'));
        // ------------------------------------------------------------Conceptos
        $fpdf->setY(130);
        $fpdf->setX(58);
        $fpdf->SetFont('Arial', 'B', 7);
        $fpdf->Cell(5, $textypos, "Conceptos");

        $fpdf->setY(137);
        $fpdf->setX(30);
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->Cell(5, $textypos, $selectAsignacionNomina[0]->dias_lab . " Dia(s) laborados Diurnos en la Semana");

        $fpdf->setY(142);
        $fpdf->setX(30);
        $fpdf->Cell(5, $textypos, $selectAsignacionNomina[0]->dias_libres . " Dia(s) de Descanso Remunerado");

        $fpdf->setY(147);
        $fpdf->setX(30);
        $fpdf->Cell(5, $textypos, $selectAsignacionNomina[0]->horas_extra_diurna . " Horas Extras Diurnas");

        $fpdf->setY(152);
        $fpdf->setX(30);
        $fpdf->Cell(5, $textypos, $selectAsignacionNomina[0]->horas_extra_noc . " Horas Extras Nocturnas");

        $fpdf->setY(157);
        $fpdf->setX(30);
        $fpdf->Cell(5, $textypos, "Aporte Seguro Social Obligatorio (sSo)");

        $fpdf->setY(162);
        $fpdf->setX(30);
        $fpdf->Cell(5, $textypos, "Aporte Perdida Involuntaria de Empleo");

        $fpdf->setY(167);
        $fpdf->setX(30);
        $fpdf->Cell(5, $textypos, "Aporte Fondo de Ahorro Obligatorio para la Vivienda (iph)");

        // Lineas de cajas
        $fpdf->Line(15, 23, 15, 240); //Linea Izquierda Vertical

        $fpdf->Line(15, 23, 195, 23); //Linea Superior Horizontal

        $fpdf->Line(15, 175, 195, 175); //Linea Medio Horizontal

        $fpdf->Line(195, 240, 195, 23); //Linea Derecha Vertical

        $fpdf->Line(15, 240, 195, 240); //Linea Inferior Horizontal


        $fpdf->Line(15, 128, 195, 128);
        $fpdf->Line(15, 136, 195, 136);
        $fpdf->Line(110, 128, 110, 175);
        $fpdf->Line(155, 128, 155, 175);

        $fpdf->setY(130);
        $fpdf->setX(123);
        $fpdf->SetFont('Arial', 'B', 7);
        $fpdf->Cell(5, $textypos, "Asignaciones");

        $fpdf->setY(137);
        $fpdf->setX(123);
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectAsignacionNomina[0]->pagos_diasLab, 2));

        $fpdf->setY(142);
        $fpdf->setX(123);
        $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectAsignacionNomina[0]->pagos_DiaLib, 2));

        $fpdf->setY(147);
        $fpdf->setX(123);
        $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectAsignacionNomina[0]->pago_hr_extraD, 2));

        $fpdf->setY(152);
        $fpdf->setX(123);
        $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectAsignacionNomina[0]->pago_hr_extra_noc, 2));

        $fpdf->setY(130);
        $fpdf->setX(167);
        $fpdf->SetFont('Arial', 'B', 7);
        $fpdf->Cell(5, $textypos, "Deducciones");

        $fpdf->setY(157);
        $fpdf->setX(167);
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->Cell(5, $textypos, "VES " . number_format($selectDeduccionNomina[0]->sso, 2));

        $fpdf->setY(162);
        $fpdf->setX(167);
        $fpdf->Cell(5, $textypos, "VES " . number_format($selectDeduccionNomina[0]->paro_forzoso, 2));

        $fpdf->setY(167);
        $fpdf->setX(167);
        $fpdf->Cell(5, $textypos, "VES " . number_format($selectDeduccionNomina[0]->lph, 2));

        $fpdf->setY(176);
        $fpdf->setX(70);
        $fpdf->SetFont('Arial', '', 9);
        $fpdf->Cell(5, $textypos, "Total");

        $fpdf->setY(176);
        $fpdf->setX(123);
        $fpdf->SetFont('Arial', '', 9);
        $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectPagoNomina->total_asignaciones, 2));

        $fpdf->setY(176);
        $fpdf->setX(167);
        $fpdf->SetFont('Arial', '', 9);
        $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectPagoNomina->total_deducciones, 2));

        // Huella XD

        $fpdf->Line(35, 200, 35, 230);
        $fpdf->Line(35, 200, 65, 200);

        $fpdf->setY(213);
        $fpdf->setX(45);
        $fpdf->Cell(5, $textypos, 'Huella');

        $fpdf->Line(65, 230, 65, 200);
        $fpdf->Line(35, 230, 65, 230);

        // Que Wuebo Hacer estas linas

        $fpdf->setY(201);
        $fpdf->setX(80);
        $fpdf->SetFont('Arial', 'B', 13);
        $fpdf->Cell(5, $textypos, 'Total Neto a Pagar');

        $fpdf->setY(201);
        $fpdf->setX(140);
        $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectPagoNomina->total_pago, 2));

        $fpdf->Line(90, 225, 150, 225);

        $fpdf->setY(227);
        $fpdf->setX(107);
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->Cell(5, $textypos, 'Recibe Conforme');

        $fpdf->setY(230);
        $fpdf->setX(110);
        $fpdf->SetFont('Arial', '', 7);
        $fpdf->Cell(5, $textypos, utf8_decode($selectEmpleado->nombre . ' ' . $selectEmpleado->apellido));


        $fpdf->setY(241);
        $fpdf->setX(15);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode("Dirección: Madre Juana - San Cristóbal, Venezuela - Edo. Táchira"));
        $fpdf->setY(245);
        $fpdf->setX(15);
        $fpdf->Cell(5, $textypos, "Telf: (0276) 3462518");


        $fpdf->setY(260);
        $fpdf->setX(15);
        $fpdf->SetFont('Arial', 'B', 10);

        $codigoHash = random_int(100000, 9999999) . '-' . $selectEmpleado->cedula . '-' . date_format(new DateTime($selectPagoNomina->inicio_pago), 'dmY') . '-' . date_format(new DateTime($selectEmpleado->fin_pago), 'dmY');

        $fpdf->Cell(5, $textypos, "COD: " . $codigoHash);

        $fpdf->output("pago-nomina-" . $codigoHash . '.pdf', 'I');
        exit;
    }
    // funcion que Imprime Todos Los PDF --
    public function generarPDFXfechas(Request $request, Fpdf $fpdf)
    {

        $this->validate($request, [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);

        if ($request->fecha_inicio > $request->fecha_fin) {
            return response()->json(['message' => 'Error de Fechas'], status: 422);
        }

        $selectPagos = Nomina::all()
            ->whereBetween('inicio_pago', [$request->fecha_inicio, $request->fecha_fin]);

        $i = 0;
        foreach ($selectPagos as $datos) {

            $selectEmpleado = Empleado::find($datos->id_empleado);

            $selectAsignacionNomina = AsignacionNomina::where('id_nomina', '=', $datos->id_nomina)
                ->get();

            $selectDeduccionNomina = DeduccionNomina::where('id_nomina', '=', $datos->id_nomina)
                ->get();

            $salarioMensual = number_format($datos->salario_mensual, 2);

            $salarioQuincenal = number_format($salarioMensual / 2, 2);

            $salarioDiario = number_format($salarioMensual / 30, 2);

            $fpdf->AddPage();
            $fpdf->SetFont('Arial', 'B', 20);
            $textypos = 5;
            $fpdf->Image(asset('vendor/images/lagarra.png'), 45, 8, -800);
            $fpdf->setY(12);
            $fpdf->setX(60);



            // Agregamos los datos de la empresa
            $fpdf->Cell(5, $textypos, "Transporte La Garra C.A");
            $fpdf->SetFont('Arial', 'B', 8);
            $fpdf->setY(13);
            $fpdf->setX(145);
            $fpdf->Cell(5, $textypos, "RIF: J-13698756-1");

            $espacioIzquierda = 60;

            $espaciadoLetrasDerecha = 105;

            // Agregamos los datos del cliente
            $fpdf->SetFont('Arial', 'B', 15);
            $fpdf->setY(25);
            $fpdf->setX(65);
            $fpdf->Cell(5, $textypos, "RECIBO DE PAGO DE SALARIO");
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->setY(35);
            $fpdf->setX($espacioIzquierda);
            $fpdf->Cell(5, $textypos, "PERIODO LABORADO:");

            $fpdf->setY(35);
            $fpdf->setX($espaciadoLetrasDerecha);
            $fpdf->Cell(5, $textypos, "DEL " . date_format(new DateTime($datos->inicio_pago), 'Y/m/d') . "  AL " . date_format(new DateTime($datos->fin_pago), 'Y/m/d'));

            $fpdf->setY(45);
            $fpdf->setX($espacioIzquierda);
            $fpdf->Cell(5, $textypos, "Apellidos y Nombres:");

            $fpdf->setY(45);
            $fpdf->setX($espaciadoLetrasDerecha);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($selectEmpleado->nombre . ' ' . $selectEmpleado->apellido));

            $fpdf->setY(55);
            $fpdf->setX($espacioIzquierda);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Cedula de Identidad:");

            $fpdf->setY(55);
            $fpdf->setX($espaciadoLetrasDerecha);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, $selectEmpleado->cedula);

            $fpdf->setY(65);
            $fpdf->setX($espacioIzquierda);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Sueldo Mensual:");

            $fpdf->setY(65);
            $fpdf->setX($espaciadoLetrasDerecha);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, "VES " . $selectEmpleado->salario_mensual);

            $fpdf->setY(75);
            $fpdf->setX($espacioIzquierda);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Sueldo Quincenal");

            $fpdf->setY(75);
            $fpdf->setX($espaciadoLetrasDerecha);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, "VES " . $salarioQuincenal);

            $fpdf->setY(85);
            $fpdf->setX($espacioIzquierda);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Sueldo Diario:");

            $fpdf->setY(85);
            $fpdf->setX($espaciadoLetrasDerecha);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, "VES " . $salarioDiario);

            $fpdf->setY(95);
            $fpdf->setX($espacioIzquierda);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Fecha de Pago:");

            $fpdf->setY(95);
            $fpdf->setX($espaciadoLetrasDerecha);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, date_format(new DateTime($datos->fecha_nomina), 'd-m-Y'));

            $fpdf->setY(105);
            $fpdf->setX($espacioIzquierda);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Cargo:");

            $fpdf->setY(105);
            $fpdf->setX($espaciadoLetrasDerecha);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($selectEmpleado->cargo));

            $fpdf->setY(115);
            $fpdf->setX($espacioIzquierda);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Fecha de Ingreso:");

            $fpdf->setY(115);
            $fpdf->setX($espaciadoLetrasDerecha);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, date_format(new DateTime($selectEmpleado->fecha_ingreso), 'd-m-Y'));
            // ------------------------------------------------------------Conceptos
            $fpdf->setY(130);
            $fpdf->setX(58);
            $fpdf->SetFont('Arial', 'B', 7);
            $fpdf->Cell(5, $textypos, "Conceptos");

            $fpdf->setY(137);
            $fpdf->setX(30);
            $fpdf->SetFont('Arial', '', 8);
            $fpdf->Cell(5, $textypos, $selectAsignacionNomina[0]->dias_lab . " Dia(s) laborados Diurnos en la Semana");

            $fpdf->setY(142);
            $fpdf->setX(30);
            $fpdf->Cell(5, $textypos, $selectAsignacionNomina[0]->dias_libres . " Dia(s) de Descanso Remunerado");

            $fpdf->setY(147);
            $fpdf->setX(30);
            $fpdf->Cell(5, $textypos, $selectAsignacionNomina[0]->horas_extra_diurna . " Horas Extras Diurnas");

            $fpdf->setY(152);
            $fpdf->setX(30);
            $fpdf->Cell(5, $textypos, $selectAsignacionNomina[0]->horas_extra_noc . " Horas Extras Nocturnas");

            $fpdf->setY(157);
            $fpdf->setX(30);
            $fpdf->Cell(5, $textypos, "Aporte Seguro Social Obligatorio (sSo)");

            $fpdf->setY(162);
            $fpdf->setX(30);
            $fpdf->Cell(5, $textypos, "Aporte Perdida Involuntaria de Empleo");

            $fpdf->setY(167);
            $fpdf->setX(30);
            $fpdf->Cell(5, $textypos, "Aporte Fondo de Ahorro Obligatorio para la Vivienda (iph)");

            // Lineas de cajas
            $fpdf->Line(15, 23, 15, 240); //Linea Izquierda Vertical

            $fpdf->Line(15, 23, 195, 23); //Linea Superior Horizontal

            $fpdf->Line(15, 175, 195, 175); //Linea Medio Horizontal

            $fpdf->Line(195, 240, 195, 23); //Linea Derecha Vertical

            $fpdf->Line(15, 240, 195, 240); //Linea Inferior Horizontal


            $fpdf->Line(15, 128, 195, 128);
            $fpdf->Line(15, 136, 195, 136);
            $fpdf->Line(110, 128, 110, 175);
            $fpdf->Line(155, 128, 155, 175);

            $fpdf->setY(130);
            $fpdf->setX(123);
            $fpdf->SetFont('Arial', 'B', 7);
            $fpdf->Cell(5, $textypos, "Asignaciones");

            $fpdf->setY(137);
            $fpdf->setX(123);
            $fpdf->SetFont('Arial', '', 8);
            $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectAsignacionNomina[0]->pagos_diasLab, 2));

            $fpdf->setY(142);
            $fpdf->setX(123);
            $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectAsignacionNomina[0]->pagos_DiaLib, 2));

            $fpdf->setY(147);
            $fpdf->setX(123);
            $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectAsignacionNomina[0]->pago_hr_extraD, 2));

            $fpdf->setY(152);
            $fpdf->setX(123);
            $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectAsignacionNomina[0]->pago_hr_extra_noc, 2));

            $fpdf->setY(130);
            $fpdf->setX(167);
            $fpdf->SetFont('Arial', 'B', 7);
            $fpdf->Cell(5, $textypos, "Deducciones");

            $fpdf->setY(157);
            $fpdf->setX(167);
            $fpdf->SetFont('Arial', '', 8);
            $fpdf->Cell(5, $textypos, "VES " . number_format($selectDeduccionNomina[0]->sso, 2));

            $fpdf->setY(162);
            $fpdf->setX(167);
            $fpdf->Cell(5, $textypos, "VES " . number_format($selectDeduccionNomina[0]->paro_forzoso, 2));

            $fpdf->setY(167);
            $fpdf->setX(167);
            $fpdf->Cell(5, $textypos, "VES " . number_format($selectDeduccionNomina[0]->lph, 2));

            // --------------------- Total ----------------------------------

            $fpdf->setY(176);
            $fpdf->setX(70);
            $fpdf->SetFont('Arial', '', 9);
            $fpdf->Cell(5, $textypos, "Total");

            // -------------------- Total Asignaciones --------------------------------

            $fpdf->setY(176);
            $fpdf->setX(123);
            $fpdf->SetFont('Arial', '', 9);
            $fpdf->Cell(5, $textypos, 'VES ' . number_format($datos->total_asignaciones, 2));

            // ---------------- Total Deducciones --------------------------------------------

            $fpdf->setY(176);
            $fpdf->setX(167);
            $fpdf->SetFont('Arial', '', 9);
            $fpdf->Cell(5, $textypos, 'VES ' . number_format($selectDeduccionNomina[0]->subtotal, 2));

            // Huella XD

            $fpdf->Line(35, 200, 35, 230);
            $fpdf->Line(35, 200, 65, 200);

            $fpdf->setY(213);
            $fpdf->setX(45);
            $fpdf->Cell(5, $textypos, 'Huella');

            $fpdf->Line(65, 230, 65, 200);
            $fpdf->Line(35, 230, 65, 230);

            // Que Wuebo Hacer estas linas

            // ------------------- Total de Pago ---------------------------------

            $fpdf->setY(201);
            $fpdf->setX(80);
            $fpdf->SetFont('Arial', 'B', 13);
            $fpdf->Cell(5, $textypos, 'Total Neto a Pagar');

            $fpdf->setY(201);
            $fpdf->setX(140);
            $fpdf->Cell(5, $textypos, 'VES ' . number_format($datos->total_pago, 2));

            $fpdf->Line(90, 225, 150, 225);

            $fpdf->setY(227);
            $fpdf->setX(107);
            $fpdf->SetFont('Arial', '', 8);
            $fpdf->Cell(5, $textypos, 'Recibe Conforme');

            $fpdf->setY(230);
            $fpdf->setX(110);
            $fpdf->SetFont('Arial', '', 7);
            $fpdf->Cell(5, $textypos, utf8_decode($selectEmpleado->nombre . ' ' . $selectEmpleado->apellido));


            $fpdf->setY(241);
            $fpdf->setX(15);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode("Dirección: Madre Juana - San Cristóbal, Venezuela - Edo. Táchira"));
            $fpdf->setY(245);
            $fpdf->setX(15);
            $fpdf->Cell(5, $textypos, "Telf: (0276) 3462518");


            $fpdf->setY(260);
            $fpdf->setX(15);
            $fpdf->SetFont('Arial', 'B', 10);

            $codigoHash = random_int(100000, 9999999) . '-' . $selectEmpleado->cedula . '-' . date_format(new DateTime($datos->inicio_pago), 'dmY') . '-' . date_format(new DateTime($datos->fin_pago), 'dmY') .  '-' . date_format(new DateTime($selectEmpleado->fin_pago), 'dmY');
            // $codigoHash = random_int(100000, 9999999) . '-' . count($selectPagos);

            $fpdf->Cell(5, $textypos, "COD: " . $codigoHash);
        }
        $fpdf->output("pago-nomina-" . $codigoHash . '.pdf', 'I');
        exit;
    }
}
