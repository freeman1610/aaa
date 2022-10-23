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


            $selectCantidadDespachado = AsignacionAlmacen::where('id_articulo', $datos->idalmacen)
                ->get();

            $disponibilidad = $datos->stock;
            if (count($selectCantidadDespachado) > 0) {

                $cantidadEnAlmacen = $datos->stock;
                $contadoArticulos = 0;

                foreach ($selectCantidadDespachado as $datosddd) {
                    $contadoArticulos = $contadoArticulos + $datosddd->cantidad;
                }

                if ($contadoArticulos >= $cantidadEnAlmacen) {
                    $disponibilidad = 0;
                } else {
                    $disponibilidad = $cantidadEnAlmacen - $contadoArticulos;
                }
            }

            if ($datos->estado != 'En Deposito') {
                $botonAsignacion = '<button class="btn btn-primary" style="width: 140px;" onclick="verAsignacion(' . $datos->idalmacen . ',`' . $datos->nombre . '`)">Despachado <i class="fa fa-eye"></i></button>';
            } else {
                $botonAsignacion = '<span class="btn btn-success">' . $datos->estado . '</span>';
            }

            $divDisponibilidad = '<div style="width: 140px;"> ' . $datos->stock . ' / Diponibles: ' . $disponibilidad . '</div>';

            $returnDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" onclick="updateArticulo(' . $datos->idalmacen . ')"><i class="fa fa-edit"></i></button> <button class="btn btn-info btn-xs" title="Despachar" onclick="listarEmpleados(`' . $datos->nombre . '`,' . $datos->idalmacen . ')"><i class="fas fa-file-export"></i></button> <button class="btn btn-warning btn-xs" onclick="eliminar(' . $datos->idalmacen . ')"><i class="fa fa-trash"></i></button>',
                "1" => $botonAsignacion,
                "2" => $datos->codigo,
                "3" => $datos->proveedor,
                "4" => 'VES ' . $datos->costo,
                "5" => $datos->marca,
                "6" => $datos->nombre,
                "7" => $divDisponibilidad,
                "8" => $datos->descripcion,
                "9" => date_format($datos->created_at, 'd-m-Y'),
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
            'costo' => 'required',
            'marca' => 'required',
            'nombre' => 'required',
            'stock' => 'required|numeric',
            'descripcion' => 'required'
        ]);

        if ($request->stock < 1) {
            return response()->json(['message' => 'El Stock no Puede ser de 0 (Cero)'], status: 422);
        }

        $comprobarCodigo = Almacen::select('codigo')
            ->where('codigo', $request->codigo)
            ->get();

        if (isset($comprobarCodigo[0]->codigo)) {
            return response()->json(['message' => 'El Codigo Ingresado Ya Ha Sido Registrado'], status: 422);
        }

        $newAlmacen = new Almacen;
        $newAlmacen->idusuario = Auth::user()->idusuario;
        $newAlmacen->codigo = $request->codigo;
        $newAlmacen->proveedor = $request->proveedor;
        $newAlmacen->costo = $request->costo;
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
            'proveedor' => 'required',
            'costo' => 'required',
            'nombre' => 'required',
            'stock' => 'required|numeric',
            'descripcion' => 'required'
        ]);

        if ($request->stock < 1) {
            return response()->json(['message' => 'El Stock no Puede ser de 0 (Cero)'], status: 422);
        }

        $selectArticulo = Almacen::find($request->id_articulo);

        $selectArticulo->codigo = $request->codigo;
        $selectArticulo->proveedor = $request->proveedor;
        $selectArticulo->costo = $request->costo;
        $selectArticulo->marca = $request->marca;
        $selectArticulo->nombre = $request->nombre;
        $selectArticulo->stock = $request->stock;
        $selectArticulo->descripcion = $request->descripcion;

        $selectArticulo->save();

        return response()->json('Fino Pa', status: 200);
    }

    public function listar_empleados_asig_art(Request $request)
    {
        $this->validate($request, [
            'articulo' => 'required|numeric'
        ]);

        $selectCantidadAlmacen = Almacen::find($request->articulo);

        $selectCantidadDespachado = AsignacionAlmacen::where('id_articulo', $request->articulo)
            ->get();

        $disponibilidad = $selectCantidadAlmacen->stock;
        if (count($selectCantidadDespachado) > 0) {

            $cantidadEnAlmacen = $selectCantidadAlmacen->stock;
            $contadoArticulos = 0;

            foreach ($selectCantidadDespachado as $datos) {
                $contadoArticulos = $contadoArticulos + $datos->cantidad;
            }

            if ($contadoArticulos >= $cantidadEnAlmacen) {
                $disponibilidad = 0;
            } else {
                $disponibilidad = $cantidadEnAlmacen - $contadoArticulos;
            }
        }

        $option = '<option value="">Seleccione</option>';

        if ($disponibilidad != 0) {

            $selectEmpleados = Empleado::select(
                'id_emp',
                'nombre',
                'apellido',
                'cedula'
            )
                ->get();
            foreach ($selectEmpleados as $datos) {
                $option = $option . '<option value="' . $datos->id_emp . '">' . $datos->nombre . ' ' . $datos->apellido . ' | C.I: ' . $datos->cedula . '</option>';
            }
        }

        return response()->json([
            'empleados' => $option,
            'cantidad_art' => $disponibilidad
        ], status: 200);
    }

    public function asignar_articulo(Request $request)
    {
        $this->validate($request, [
            'id_articulo' => 'required|numeric',
            'id_emp' => 'required|numeric',
            'cantidad' => 'required|numeric'
        ]);

        $articulo = Almacen::find($request->id_articulo);

        $selectCantidadDespachado = AsignacionAlmacen::where('id_articulo', $request->id_articulo)
            ->get();

        if (count($selectCantidadDespachado) > 0) {

            $cantidadEnAlmacen = $articulo->stock;
            $contadoArticulos = 0;

            foreach ($selectCantidadDespachado as $datos) {
                $contadoArticulos = $contadoArticulos + $datos->cantidad;
            }

            if ($contadoArticulos >= $cantidadEnAlmacen) {
                return response()->json(['message' => 'No hay disponibilidad de este articulo'], status: 422);
            }
        }

        $newAsinacion = new AsignacionAlmacen;

        $newAsinacion->id_usuario = Auth::user()->idusuario;
        $newAsinacion->id_emp = $request->id_emp;
        $newAsinacion->id_articulo = $request->id_articulo;
        $newAsinacion->cantidad = $request->cantidad;

        $newAsinacion->save();

        if ($articulo->estado != "Despachado") {
            $articulo->estado = "Despachado";
            $articulo->save();
        }

        return response()->json('Cool', status: 200);
    }

    public function desasignar_articulo(Request $request)
    {
        $this->validate($request, [
            'id_articulo' => 'required|numeric'
        ]);

        $articuloAsignado = AsignacionAlmacen::find($request->id_articulo);

        AsignacionAlmacen::destroy($request->id_articulo);

        $comprovarMasAsignaciones = AsignacionAlmacen::where('id_articulo', $articuloAsignado->id_articulo)->get();

        if (count($comprovarMasAsignaciones) == 0) {
            $articulo = Almacen::find($articuloAsignado->id_articulo);

            $articulo->estado = "En Deposito";

            $articulo->save();
        }

        return response()->json(count($comprovarMasAsignaciones), status: 200);
    }


    public function ver_asignacion(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);
        $selectAsignacion = AsignacionAlmacen::where('id_articulo', $request->id)->get();

        $tabla = '';
        foreach ($selectAsignacion as $datos) {
            $selectEmpleado = Empleado::where('id_emp', $datos->id_emp)
                ->select('nombre', 'apellido', 'cedula')
                ->get();
            $selectArticulo = Almacen::where('idalmacen', $datos->id_articulo)
                ->select('codigo', 'marca', 'nombre')
                ->get();

            $tabla = $tabla . '<tr><td>' . $selectEmpleado[0]->nombre . ' ' . $selectEmpleado[0]->apellido . ', C.I: ' . $selectEmpleado[0]->cedula . '</td><td>' . $datos->cantidad . '</td><td>' . date_format($datos->created_at, 'd-m-Y, H:i:s') . '</td><td><button class="btn btn-warning" onclick="desasignarArticulo(' . $datos->id . ')" title="Regresar Articulos"><i class="fas fa-file-export"></i></button></td></tr>';
        }

        return response()->json(['tabla' => $tabla], status: 200);
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
