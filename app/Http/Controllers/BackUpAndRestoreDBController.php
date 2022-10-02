<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackUpAndRestoreDBController extends Controller
{
    public function backupsql()
    {
        $ruta = '';
        if (file_exists('c:\xampp\mysql\bin\mysqldump.exe')) {
            $ruta = 'c:\xampp\mysql\bin\mysqldump';
        }

        if ($ruta == '') {
            return response()->json(['message' => 'No hay rutas para respaldo, el Administrador del Sistema debe configurar una nueva ruta'], status: 422);
        }

        $fecha = date("Ymd");

        $bd = "la_garra_predefensa";

        $out_sql = $bd . "_" . $fecha . ".sql";

        $dump = $ruta . ' --user="root" --password="" ' . $bd . ' > ' . $out_sql;

        system($dump);

        $boton = '<a class="btn btn-primary" href="' . asset($out_sql) . '" style="text-decoration:none;" onclick="limpiarBackUp()">Descargar Respaldo</a>';


        return response()->json(['boton' => $boton], status: 200);
    }

    // public function restore_db(Request $request)
    // {
    //     $ruta = '';
    //     if (file_exists('c:\xampp\mysql\bin\mysql.exe')) {
    //         $ruta = 'c:\xampp\mysql\bin\mysql';
    //     }

    //     if ($ruta == '') {
    //         return response()->json(['message' => 'No hay rutas para respaldo, el Administrador del Sistema debe configurar una nueva ruta'], status: 422);
    //     }
    //     $this->validate($request, [
    //         'newSql' => 'required'
    //     ]);
    //     $archivo_sql = $request->file('newSql');

    //     $request->file('newSql')->move('', $archivo_sql->getClientOriginalName());

    //     $dump = $ruta . '--user="root" --password="" pruebadb < C:\xampp\htdocs\primera prueba git\laGarra1\public ' . $archivo_sql->getClientOriginalName();

    //     system($dump);

    //     return response()->json('Fino Pa', status: 200);
    // }

    public function limpieza_backup_db()
    {
        $fecha = date("Ymd");
        $bd = "la_garra_predefensa";
        $out_sql = $bd . "_" . $fecha . ".sql";
        File::delete($out_sql);
    }
}
