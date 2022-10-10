<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
{
    public function listar_almacen()
    {
        $selectAlmacen = Almacen::all();

        $returnDatos = array();

        foreach ($selectAlmacen as $datos) {

            $returnDatos[] = [
                "0" => '<button class="btn btn-primary btn-xs" onclick="updateArticulo(' . $datos->idalmacen . ')"><i class="fa fa-edit"></i></button> <button class="btn btn-warning btn-xs" onclick="eliminar(' . $datos->idalmacen . ')"><i class="fa fa-trash"></i></button>',
                "1" => $datos->codigo,
                "2" => $datos->marca,
                "3" => $datos->nombre,
                "4" => $datos->stock,
                "5" => $datos->descripcion,
                "6" => date_format($datos->created_at, 'd-m-Y'),
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
        $selectArticulo->marca = $request->marca;
        $selectArticulo->nombre = $request->nombre;
        $selectArticulo->stock = $request->stock;
        $selectArticulo->descripcion = $request->descripcion;

        $selectArticulo->save();

        return response()->json('Fino Pa', status: 200);
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
