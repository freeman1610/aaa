<?php

namespace App\Http\Controllers;


use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Empleado;
use App\Models\Salario;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NominaPerController extends Controller
{
    protected $fpdf;

    public function select_empleado()
    {
        $selectEmpleados = DB::table('empleado')->select('id_emp', 'nombre', 'apellido', 'cedula', 'cargo', 'tipo_documento')->get();

        return response()->json($selectEmpleados, status: 200);
    }

    public function listar_nomina_per()
    {
        $listaEmpleados = DB::table('nomina_per')
            ->join('empleado', 'nomina_per.id_empleado', '=', 'empleado.id_emp')
            ->select('empleado.nombre', 'empleado.apellido', 'empleado.cedula', 'empleado.cargo', 'empleado.fecha_ingreso', 'nomina_per.id_nomina', 'nomina_per.sSo', 'nomina_per.paro_forzoso', 'nomina_per.iPh', 'nomina_per.tot_deducciones', 'nomina_per.tot_bruto', 'nomina_per.fecha_registro')
            ->get();

        $arrayAntiguedad = array();

        foreach ($listaEmpleados as $dato) {
            $fecha_ingreso = new DateTime(date('Y/m/d', strtotime($dato->fecha_ingreso))); // Creo un objeto DateTime de la fecha ingresada
            $fecha_hoy =  new DateTime(date('Y/m/d', time())); // Creo un objeto DateTime de la fecha de hoy
            $antigueadad = date_diff($fecha_hoy, $fecha_ingreso); // La funcion ayuda a calcular la diferencia, esto seria un objeto

            $texto = "{$antigueadad->format('%Y')} Años, {$antigueadad->format('%m')} Meses y {$antigueadad->format('%d')} Dias";
            array_push($arrayAntiguedad, $texto);
        }
        $i = 0;
        $listaEmp = array();
        foreach ($listaEmpleados as $datoss) {
            $url = '#';
            $listaEmp[] = array(
                "0" => '<button class="btn btn-warning btn-xs" title="Mostrar Detalles" onclick="mostrar(' . $datoss->id_nomina . ')"><i class="fa fa-eye"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $datoss->id_nomina . ')"><i class="fa fa-trash"></i></button>' . '<a target="_blank" href="' . $url . $datoss->id_nomina . '"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>',
                "1" => $datoss->nombre . " " . $datoss->apellido,
                "2" => $datoss->cedula,
                "3" => $datoss->sSo,
                "4" => $datoss->paro_forzoso,
                "5" => $datoss->iPh,
                "6" => $datoss->tot_deducciones,
                "7" => $datoss->tot_bruto,
                "8" => $datoss->fecha_registro,
                "9" => $arrayAntiguedad[$i]

            );
            $i++;
        }

        $results = array(
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($listaEmp), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($listaEmp), //enviamos el total de registros a visualizar
            "aaData" => $listaEmp
        );

        return response()->json($results, status: 200);
    }

    public function guardar_nomina_per(Request $request)
    {
        $this->validate($request, [
            'dias_lab' => 'required|max:2'
        ]);

        $diasLaborados = $request->dias_lab;
        $diasPermiso = $request->dias_perm;
        $diasDescanso = $request->dias_desc;

        $sumadDias = $diasPermiso + $diasLaborados + $diasDescanso;

        if ($sumadDias <= 30) {
            return 'si';
        } else {
            return 'El Total de dias de Laborados, Permisos, Descanso, no debe pasar 30 dias';
        }


        // return $request->all();
    }

    public function mostrar_salario()
    {
        // El find 1 es para trabajar con el salario base
        $selectSalario = Salario::find(1);

        $salarioMensual = number_format($selectSalario->salario, 2);

        $salarioQuincenal = number_format($salarioMensual / 15, 2);

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
            'salarioBaseForm' => 'required'
        ]);

        return $request->all();

        // $selectUsuario = Salario::find($request->idusuario);

        // $updateSalarioBase =  DB::insert('insert into usuario_permiso (idusuario, idpermiso) values (?, ?)', [$request->idusuario]);
    }


    public function pdfff(Request $request, Fpdf $fpdf)
    {

        $fpdf->AddPage();
        $fpdf->SetFont('Courier', 'B', 18);
        $fpdf->Cell(50, 25, 'Hello World!');
        $fpdf->Output();
        exit;
    }
}
