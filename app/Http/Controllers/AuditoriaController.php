<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Auditoria;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    public function listar_auditoria()
    {
        $selectAuditoria = Auditoria::join('usuarios', 'usuarios.idusuario', '=', 'audits.user_id')
            ->select(
                'usuarios.nombre',
                'usuarios.apellido',
                'usuarios.login',
                'audits.event',
                'audits.auditable_type',
                'audits.old_values',
                'audits.new_values',
                'audits.created_at'
            )
            ->get();

        $returnDatos = array();

        foreach ($selectAuditoria as $datos) {

            // dd($datos->old_values);

            $usuario = '<div style="width: 180px;">Usuario: ' . $datos->login . '<br> Nombre y Apellido: ' . $datos->nombre . ' ' . $datos->apellido . '</div>';
            $returnDatos[] = [
                "0" => $usuario,
                "1" => $datos->event,
                '2' => '<div style="">' . $datos->auditable_type . '</div>',
                "3" => '<div style="width: 150px;">' . $datos->old_values . '</div>',
                "4" => '<div style="width: 150px;">' . $datos->new_values . '</div>',
                "5" => date_format($datos->created_at, 'd-m-Y h:m:s')
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
}
