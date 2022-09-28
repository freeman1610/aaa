<?php

namespace App\Http\Controllers;

use App\Models\Chofer;
use App\Models\Empleado;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadosController extends Controller
{
    public function listar_empleados()
    {
        $selecEmpleados = DB::table('empleado')->select()->get();

        $arrayDeDatos = array();

        foreach ($selecEmpleados as $dato) {
            $arrayDeDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" title="Editar" onclick="mostrar(' . $dato->id_emp . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $dato->id_emp . ')"><i class="fa fa-trash"></i></button>',
                "1" => $dato->nombre . " " . $dato->apellido,
                "2" => $dato->cedula,
                "3" => $dato->fecha_ingreso,
                "4" => $dato->telefono,
                "5" => $dato->direccion,
                "6" => $dato->cargo
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

    public function mostrar_empleado(Request $request)
    {

        $selectEmpleado = Empleado::find($request->id_emp);

        return $selectEmpleado;
    }

    public function muestra_empleados_select()
    {
        $selectAllEmpleados = Empleado::all();
        return $selectAllEmpleados;
    }

    public function guardar_update_empleado(Request $request)
    {

        $this->validate($request, [
            'id_emp' => 'required',
            'iddepartamento' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'tipo_documento' => 'required',
            'cedula' => 'required',
            'telefono' => 'required',
            'fecha_nac' => 'required',
            'fecha_ingreso' => 'required',
            'cargo' => 'required',
            'direccion' => 'required'
        ]);

        $selectEmpleado = Empleado::find($request->id_emp);

        $selectEmpleado->nombre = $request->nombre;
        $selectEmpleado->apellido = $request->apellido;
        $selectEmpleado->tipo_documento = $request->tipo_documento;
        $selectEmpleado->cedula = $request->cedula;
        $selectEmpleado->fecha_nac = $request->fecha_nac;
        $selectEmpleado->iddepartamento = $request->iddepartamento;
        $selectEmpleado->cargo = $request->cargo;
        $selectEmpleado->telefono = $request->telefono;
        $selectEmpleado->direccion = $request->direccion;
        $selectEmpleado->fecha_ingreso = $request->fecha_ingreso;

        $selectEmpleado->save();

        if ($request->iddepartamento != 8) {
            $comprobarSiEraChofer = Chofer::where('chofer_idempleado', '=', $request->id_emp)->get();
            if (!empty($comprobarSiEraChofer[0]->chofer_idempleado)) {
                Chofer::destroy($comprobarSiEraChofer[0]->chofer_id);
            }
        }
        if ($request->iddepartamento == 8) {
            $comprobarSiEraChofer = Chofer::where('chofer_idempleado', '=', $request->id_emp)->get();
            if (empty($comprobarSiEraChofer[0]->chofer_idempleado)) {
                DB::insert(
                    'insert into choferes (chofer_idempleado, created_at ,updated_at) values (?, ?, ?)',
                    [
                        $request->id_emp,
                        new DateTime(),
                        new DateTime()
                    ]
                );
            }
        }
    }

    public function crear_empleado(Request $request)
    {
        $this->validate($request, [
            'iddepartamento_a' => 'required',
            'nombre_a' => 'required',
            'apellido_a' => 'required',
            'tipo_documento_a' => 'required',
            'num_documento_a' => 'required',
            'telefono_a' => 'required',
            'fecha_nac' => 'required',
            'fecha_ingreso' => 'required',
            'cargo_a' => 'required',
            'direccion_a' => 'required'
        ]);

        DB::insert(
            'insert into empleado (nombre,apellido,tipo_documento,cedula,fecha_nac,iddepartamento,cargo,telefono,direccion,fecha_ingreso,created_at,updated_at) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->nombre_a,
                $request->apellido_a,
                $request->tipo_documento_a,
                $request->num_documento_a,
                $request->fecha_nac,
                $request->iddepartamento_a,
                $request->cargo_a,
                $request->telefono_a,
                $request->direccion_a,
                $request->fecha_ingreso,
                new DateTime(),
                new DateTime()
            ]
        );

        if ($request->iddepartamento_a == 8) {
            $selectUltimoEmpleado = DB::table('empleado')->select('id_emp')->latest()->first();
            DB::insert(
                'insert into choferes (chofer_idempleado, created_at ,updated_at) values (?, ?, ?)',
                [
                    $selectUltimoEmpleado->id_emp,
                    new DateTime(),
                    new DateTime()
                ]
            );
        }
    }

    public function eliminar_empleado(Request $request)
    {
        $this->validate($request, [
            'id_emp' => 'required'
        ]);

        $borrarEmpleado = DB::table('empleado')->where('id_emp', $request->id_emp)->delete();
    }
}
