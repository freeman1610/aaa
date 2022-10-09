<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartamentoController extends Controller
{
    public function listar_departamentos()
    {
        $selectDepartamentos = Departamento::all();

        $arrayDeDatos = array();

        foreach ($selectDepartamentos as $dato) {
            $arrayDeDatos[] = [
                "0" => ($dato->estadod) ? '<button class="btn btn-primary btn-xs" title="Editar" onclick="updateDepartamento(' . $dato->iddepartamento . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Desactivar" onclick="desactivar(' . $dato->iddepartamento . ')"><i class="fa fa-times"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $dato->iddepartamento . ')"><i class="fa fa-trash"></i></button>' : '<button class="btn btn-primary btn-xs" title="Editar" onclick="updateDepartamento(' . $dato->iddepartamento . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-success btn-xs" onclick="activar(' . $dato->iddepartamento . ')"><i class="fa fa-check"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $dato->iddepartamento . ')"><i class="fa fa-trash"></i></button>',
                "1" => $dato->nombre,
                "2" => $dato->descripcion,
                "3" => date_format($dato->created_at, 'd-m-Y'),
                "4" => ($dato->estadod) ? '<span class="label bg-blue">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
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

    public function mostrar_departamento_update(Request $request)
    {
        $this->validate($request, [
            'id_departamento' => 'required|numeric'
        ]);

        $selectDepartamento = Departamento::find($request->id_departamento);

        return response()->json($selectDepartamento, status: 200);
    }

    public function registrar_departamento(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        $newDepartamento = new Departamento;
        $newDepartamento->nombre = $request->nombre;
        $newDepartamento->descripcion = $request->descripcion;
        $newDepartamento->idusuario = Auth::user()->idusuario;
        $newDepartamento->save();
    }
    public function update_departamento(Request $request)
    {
        $this->validate($request, [
            'id_departamento' => 'required|numeric',
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);
        $selectDepartamento = Departamento::find($request->id_departamento);
        $selectDepartamento->nombre = $request->nombre;
        $selectDepartamento->descripcion = $request->descripcion;
        $selectDepartamento->save();
        return response()->json('Fino Pa', status: 200);
    }
    public function desactivar_departamento(Request $request)
    {
        $this->validate($request, [
            'iddepartamento' => 'required|numeric'
        ]);
        $selectDepartamento = Departamento::find($request->iddepartamento);
        $selectDepartamento->estadod = 0;
        $selectDepartamento->save();
        return response()->json('Fino Pa', status: 200);
    }
    public function activar_departamento(Request $request)
    {
        $this->validate($request, [
            'iddepartamento' => 'required|numeric'
        ]);
        $selectDepartamento = Departamento::find($request->iddepartamento);
        $selectDepartamento->estadod = 1;
        $selectDepartamento->save();
        return response()->json('Fino Pa', status: 200);
    }
    public function eliminar_departamento(Request $request)
    {
        $this->validate($request, [
            'iddepartamento' => 'required|numeric'
        ]);
        Departamento::destroy($request->iddepartamento);
        return response()->json('Fino Pa', status: 200);
    }
}
