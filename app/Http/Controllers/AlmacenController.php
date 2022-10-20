<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\AsignacionAlmacen;
use App\Models\Empleado;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
{
    public function listar_almacen()
    {
        $selectAlmacen = Almacen::orderBy('created_at', 'desc')->get();

        $returnDatos = array();

        foreach ($selectAlmacen as $datos) {

            if ($datos->estado != 'En Deposito') {
                $articuloAsignado = AsignacionAlmacen::where('id_articulo', '=', $datos->idalmacen)
                    ->select('id')
                    ->get();
                $botonAsignacion = '<button class="btn btn-primary" onclick="verAsignacion(' . $articuloAsignado[0]->id . ')"><i class="fa fa-eye"></i> Asignado</button>';
            } else {
                $botonAsignacion = '<span class="btn btn-success">' . $datos->estado . '</span>';
            }

            $returnDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" onclick="updateArticulo(' . $datos->idalmacen . ')"><i class="fa fa-edit"></i></button> <button class="btn btn-info btn-xs" title="Asignar" onclick="listarEmpleados(`' . $datos->nombre . '`,' . $datos->idalmacen . ')"><i class="fas fa-file-export"></i></button> <button class="btn btn-warning btn-xs" onclick="eliminar(' . $datos->idalmacen . ')"><i class="fa fa-trash"></i></button>',
                "1" => $botonAsignacion,
                "2" => $datos->codigo,
                "3" => $datos->proveedor,
                "4" => $datos->marca,
                "5" => $datos->nombre,
                "6" => $datos->stock,
                "7" => $datos->descripcion,
                "8" => date_format($datos->created_at, 'd-m-Y'),
            ];
        }

        $results = [
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($returnDatos), //enviamos el total de registros al returnDatostable
            "iTotalDisplayRecords" => count($returnDatos), //enviamos el total de registros a visualizar
            "aaData" => $returnDatos
        ];

        return response()->json($results, status: 200);
    }

    public function registrar_articulo(Request $request)
    {
        $this->validate($request, [
            'codigo' => 'required',
            'proveedor' => 'required',
            'marca' => 'required',
            'nombre' => 'required',
            'stock' => 'required|numeric',
            'descripcion' => 'required'
        ]);

        $comprobarCodigo = DB::table('almacen')
            ->select('codigo')
            ->where('codigo', $request->codigo)
            ->get();

        if (isset($comprobarCodigo[0]->codigo)) {
            return response()->json(['message' => 'El Codigo Ingresado Ya Ha Sido Registrado'], status: 422);
        }

        $newAlmacen = new Almacen;
        $newAlmacen->idusuario = Auth::user()->idusuario;
        $newAlmacen->codigo = $request->codigo;
        $newAlmacen->proveedor = $request->proveedor;
        $newAlmacen->marca =  $request->marca;
        $newAlmacen->nombre = $request->nombre;
        $newAlmacen->stock = $request->stock;
        $newAlmacen->descripcion = $request->descripcion;
        $newAlmacen->save();
    }

    public function mostrar_articulo_update(Request $request)
    {
        $this->validate($request, [
            'idarticulo' => 'required|numeric'
        ]);

        $selectArticulo = Almacen::find($request->idarticulo);

        return response()->json($selectArticulo, status: 200);
    }

    public function update_articulo(Request $request)
    {
        $this->validate($request, [
            'id_articulo' => 'required|numeric',
            'codigo' => 'required',
            'marca' => 'required',
            'nombre' => 'required',
            'stock' => 'required|numeric',
            'descripcion' => 'required'
        ]);

        $selectArticulo = Almacen::find($request->id_articulo);

        $selectArticulo->codigo = $request->codigo;
        $selectArticulo->proveedor = $request->proveedor;
        $selectArticulo->marca = $request->marca;
        $selectArticulo->nombre = $request->nombre;
        $selectArticulo->stock = $request->stock;
        $selectArticulo->descripcion = $request->descripcion;

        $selectArticulo->save();

        return response()->json('Fino Pa', status: 200);
    }

    public function listar_empleados_asig_art()
    {
        $selectEmpleados = Empleado::select(
            'id_emp',
            'nombre',
            'apellido',
            'cedula'
        )
            ->get();

        $option = '<option value="">Seleccione</option>';

        foreach ($selectEmpleados as $datos) {
            $option = $option . '<option value="' . $datos->id_emp . '">' . $datos->nombre . ' ' . $datos->apellido . ' | C.I: ' . $datos->cedula . '</option>';
        }
        return response()->json(['empleados' => $option], status: 200);
    }

    public function asignar_articulo(Request $request)
    {
        $this->validate($request, [
            'id_articulo' => 'required|numeric',
            'id_emp' => 'required|numeric'
        ]);

        $articulo = Almacen::find($request->id_articulo);

        if ($articulo->estado = "Asignado") {
            return response()->json(['message' => 'Este Articulo ya ha sido Asignado'], status: 422);
        }

        $articulo->estado = "Asignado";

        $newAsinacion = new AsignacionAlmacen;

        $newAsinacion->id_usuario = Auth::user()->idusuario;
        $newAsinacion->id_emp = $request->id_emp;
        $newAsinacion->id_articulo = $request->id_articulo;

        $articulo->save();
        $newAsinacion->save();

        return response()->json('Cool', status: 200);
    }

    public function desasignar_articulo(Request $request)
    {
        $this->validate($request, [
            'id_articulo' => 'required|numeric'
        ]);

        $id = AsignacionAlmacen::find($request->id_articulo);

        $articulo = Almacen::find($id->id_articulo);

        $articulo->estado = "En Deposito";

        $articulo->save();

        AsignacionAlmacen::destroy($request->id_articulo);

        return response()->json('Cool', status: 200);
    }


    public function ver_asignacion(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        $selectAsignacion = AsignacionAlmacen::find($request->id);
        $selectEmpleado = Empleado::where('id_emp', $selectAsignacion->id_emp)
            ->select('nombre', 'apellido', 'cedula')
            ->get();
        $selectArticulo = Almacen::where('idalmacen', $selectAsignacion->id_articulo)
            ->select('codigo', 'marca', 'nombre')
            ->get();

        return response()->json([
            'id' => $selectAsignacion->id,
            'empleado' => $selectEmpleado[0],
            'articulo' => $selectArticulo[0],
            'fecha' =>  date_format($selectAsignacion->created_at, 'd-m-Y, H:i:s')
        ], status: 200);
    }


    public function eliminar_articulo(Request $request)
    {
        $this->validate($request, [
            'idarticulo' => 'required|numeric'
        ]);
        Almacen::destroy($request->idarticulo);
        return response()->json('Fino Pa', status: 200);
    }
}
