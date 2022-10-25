<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Auditoria;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Usuario;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class PdfAuditoriaController extends Controller
{

    public function listar_usuarios_audt()
    {
        $selectUsuario = Usuario::select('idusuario', 'login', 'num_documento')
            ->get();

        $option = '<option value="">Seleccione</option>';

        foreach ($selectUsuario as $datos) {
            $option = $option . '<option value="' . $datos->idusuario . '">' . $datos->login . ' | C.I: ' . $datos->num_documento . '</option>';
        }

        return response()->json(['usuarios' => $option], status: 200);
    }

    public function generar_url_audt_usuario(Request $request)
    {
        $this->validate($request, [
            'usuario' => 'required|numeric'
        ]);
        $urlToken = URL::signedRoute('pdf_audit_usuario', ['id' => $request->usuario]);

        $href = '<a href="' . $urlToken . '" class="btn btn-success" target="_blank">Ver PDF</a>';

        return response()->json(['urlPDF' => $href], status: 200);
    }

    public function generar_url_audt_fechas(Request $request)
    {
        $this->validate($request, [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);

        if ($request->fecha_inicio > $request->fecha_fin) {
            return response()->json(['message' => 'Error de Fechas'], status: 422);
        }
        $urlToken = URL::signedRoute('pdf_audit_fechas', ['fecha_inicio' => $request->fecha_inicio, 'fecha_fin' => $request->fecha_fin]);

        $contentHTML = '<a href="' . $urlToken . '" class="btn btn-info" target="_blank"><span class="fas fa-print"></span> Imprimir</a>';

        return response()->json(['contentHMTL' => $contentHTML], status: 200);
    }

    public function pdf_audit_usuario(Request $request, Fpdf $fpdf)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }

        $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        $selectUsuario = Usuario::where('usuarios.idusuario',  $request->id)
            ->join('departamento', 'departamento.iddepartamento', '=', 'usuarios.iddepartamento')
            ->join('tipousuario', 'tipousuario.idtipousuario', '=', 'usuarios.idtipousuario')
            ->select(
                'usuarios.nombre',
                'usuarios.apellido',
                'usuarios.num_documento',
                'usuarios.login',
                'usuarios.cargo',
                'usuarios.created_at',
                'departamento.nombre AS nom_dp',
                'tipousuario.nombre_t'
            )

            ->get();
        $selectAuditoria = Auditoria::where('user_id', $request->id)->get();

        foreach ($selectAuditoria as $datosAudit) {
            $fpdf->AddPage();
            $fpdf->SetTitle('Auditoria', true);
            $fpdf->SetFont('Arial', 'B', 20);
            $textypos = 5;
            $fpdf->Image(asset('vendor/images/lagarra.png'), 45, 8, -800);
            $fpdf->setY(12);
            $fpdf->setX(60);


            // Lineas de cajas
            $fpdf->Line(15, 23, 15, 248); //Linea Izquierda Vertical

            $fpdf->Line(80, 32, 80, 47.7); //Linea Vertical Primera caja

            $fpdf->Line(118, 72, 118, 62); //Linea Vertical Primera caja Datos auditoria

            $fpdf->Line(15, 23, 195, 23); //Linea Superior Horizontal

            $fpdf->Line(15, 32, 195, 32); //Linea Superior Horizontal 2da

            $fpdf->Line(15, 37.7, 195, 37.7); //Linea Horizontal 3ra

            $fpdf->Line(15, 42.7, 195, 42.7); //Linea Horizontal 4ta

            $fpdf->Line(15, 47.7, 195, 47.7); //Linea Horizontal 5ta

            $fpdf->Line(15, 52.7, 195, 52.7); //Linea Horizontal 6ta

            $fpdf->Line(15, 62, 195, 62); //Linea Horizontal 7ma

            $fpdf->Line(15, 72, 195, 72); //Linea Horizontal 8va

            $fpdf->Line(15, 123, 195, 123); //Linea Horizontal 9na

            $fpdf->Line(15, 218, 195, 218); //Linea Horizontal 10ma

            $fpdf->Line(15, 226.5, 195, 226.5); //Linea Horizontal 11va

            $fpdf->Line(15, 242, 195, 242); //Linea Horizontal 12va

            $fpdf->Line(15, 175, 195, 175); //Linea Medio Horizontal

            $fpdf->Line(195, 248, 195, 23); //Linea Derecha Vertical

            $fpdf->Line(15, 248, 195, 248); //Linea Inferior Horizontal


            // Agregamos los datos de la empresa
            $fpdf->Cell(5, $textypos, "Transporte La Garra C.A");
            $fpdf->SetFont('Arial', 'B', 8);
            $fpdf->setY(13);
            $fpdf->setX(145);
            $fpdf->Cell(5, $textypos, "RIF: J-13698756-1");

            $espacioIzquierda = 60;

            $espaciadoLetrasDerecha = 105;

            $cod = date('dmY-siH');

            // Agregamos los datos del cliente
            $fpdf->SetFont('Arial', 'B', 15);
            $fpdf->setY(25);
            $fpdf->Cell(190, $textypos, utf8_decode("AUDITORIA N°: ") . $cod, 20, 10, 'C');
            $fpdf->SetFont('Arial', 'B', 10);


            $fpdf->setY(33);
            $fpdf->setX(18);
            $fpdf->Cell(5, $textypos, "TIPO DE AUDITORIA: USUARIO");

            $fpdf->setY(38);
            $fpdf->setX(18);
            $fpdf->Cell(5, $textypos, "USUARIO AUDITADO: ");

            $fpdf->setY(38);
            $fpdf->setX(56);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($selectUsuario[0]->login));

            $fpdf->setY(43);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "USUARIO AUDITOR: ");

            $fpdf->setY(43);
            $fpdf->setX(54);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode(Auth::user()->login));

            $fpdf->setY(48);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "DEPARTAMENTO DEL USUARIO: ");


            $fpdf->setY(48);
            $fpdf->setX(77);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($selectUsuario[0]->nom_dp));

            $fpdf->setY(33);
            $fpdf->setX(83);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "FECHA DE LA AUDITORIA: ");

            $fpdf->setY(33);
            $fpdf->setX(130);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, date('d-m-Y'));

            $fpdf->setY(38);
            $fpdf->setX(83);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "TIPO DE USUARIO: ");

            $fpdf->setY(38);
            $fpdf->setX(118);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($selectUsuario[0]->nombre_t));

            $fpdf->setY(43);
            $fpdf->setX(83);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "FECHA DEL REGISTRO DEL USUARIO:");

            $fpdf->setY(43);
            $fpdf->setX(151);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($selectUsuario[0]->created_at));

            $fpdf->SetFont('Arial', 'B', 13);
            $fpdf->setY(55);
            $fpdf->setX(104);
            $fpdf->Cell(5, $textypos, utf8_decode("DATOS DE LA AUDITORIA"), 20, 10, 'C');

            $fpdf->setY(65);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "MODELO AFECTADO:");

            $fpdf->setY(65);
            $fpdf->setX(58);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($datosAudit->auditable_type));

            $fpdf->setY(65);
            $fpdf->setX(120);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "TIPO DE EVENTO:");


            $fpdf->setY(65);
            $fpdf->setX(152);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($datosAudit->event));


            $fpdf->setY(71);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(20, 10, utf8_decode("DATOS VIEJOS: "));


            $fpdf->setY(78);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->old_values));

            $fpdf->setY(122);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(20, 10, utf8_decode("DATOS NUEVOS: "));

            $fpdf->setY(130);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->new_values));

            $fpdf->setY(177);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, utf8_decode("URL DE LA ACCIÓN: "));


            $fpdf->setY(182);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->url));

            $fpdf->setY(220);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, utf8_decode("DIRECCIÓN IP: "));

            $fpdf->setY(220);
            $fpdf->setX(45);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->ip_address));

            $fpdf->setY(228);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, utf8_decode("PLATAFORMA DE ACCESO: "));

            $fpdf->setY(232);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->user_agent));

            $fpdf->setY(242.5);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "FECHA DEL EVENTO: ");

            $fpdf->setY(242.5);
            $fpdf->setX(58);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, $datosAudit->created_at);

            $fpdf->setY(250);
            $fpdf->setX(15);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode("Dirección: Madre Juana - San Cristóbal, Venezuela - Edo. Táchira"));
            $fpdf->setY(254);
            $fpdf->setX(15);
            $fpdf->Cell(5, $textypos, "Telf: (0276) 3462518");


            $fpdf->setY(260);
            $fpdf->setX(15);
            $fpdf->SetFont('Arial', 'B', 10);
        }
        $fpdf->output('auditoria-' . $cod  . '.pdf', 'I');
        exit;
    }

    public function pdf_audit_fechas(Request $request, Fpdf $fpdf)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }

        $selectAuditoria = Auditoria::all()
            ->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);

        if (count($selectAuditoria) == 0) {
            return abort(404);
        }

        foreach ($selectAuditoria as $datosAudit) {

            $selectUsuario = Usuario::where('usuarios.idusuario',  $datosAudit->user_id)
                ->join('departamento', 'departamento.iddepartamento', '=', 'usuarios.iddepartamento')
                ->join('tipousuario', 'tipousuario.idtipousuario', '=', 'usuarios.idtipousuario')
                ->select(
                    'usuarios.nombre',
                    'usuarios.apellido',
                    'usuarios.num_documento',
                    'usuarios.login',
                    'usuarios.cargo',
                    'usuarios.created_at',
                    'departamento.nombre AS nom_dp',
                    'tipousuario.nombre_t'
                )
                ->get();


            $fpdf->AddPage();
            $fpdf->SetTitle('Auditoria', true);
            $fpdf->SetFont('Arial', 'B', 20);
            $textypos = 5;
            $fpdf->Image(asset('vendor/images/lagarra.png'), 45, 8, -800);
            $fpdf->setY(12);
            $fpdf->setX(60);


            // Lineas de cajas
            $fpdf->Line(15, 23, 15, 248); //Linea Izquierda Vertical

            $fpdf->Line(80, 37.9, 80, 47.7); //Linea Vertical Primera caja

            $fpdf->Line(125, 32, 125, 37.5); //Linea Vertical Primera caja 2da

            $fpdf->Line(118, 72, 118, 62); //Linea Vertical Primera caja Datos auditoria

            $fpdf->Line(15, 23, 195, 23); //Linea Superior Horizontal

            $fpdf->Line(15, 32, 195, 32); //Linea Superior Horizontal 2da

            $fpdf->Line(15, 37.7, 195, 37.7); //Linea Horizontal 3ra

            $fpdf->Line(15, 42.7, 195, 42.7); //Linea Horizontal 4ta

            $fpdf->Line(15, 47.7, 195, 47.7); //Linea Horizontal 5ta

            $fpdf->Line(15, 52.7, 195, 52.7); //Linea Horizontal 6ta

            $fpdf->Line(15, 62, 195, 62); //Linea Horizontal 7ma

            $fpdf->Line(15, 72, 195, 72); //Linea Horizontal 8va

            $fpdf->Line(15, 123, 195, 123); //Linea Horizontal 9na

            $fpdf->Line(15, 218, 195, 218); //Linea Horizontal 10ma

            $fpdf->Line(15, 226.5, 195, 226.5); //Linea Horizontal 11va

            $fpdf->Line(15, 242, 195, 242); //Linea Horizontal 12va

            $fpdf->Line(15, 175, 195, 175); //Linea Medio Horizontal

            $fpdf->Line(195, 248, 195, 23); //Linea Derecha Vertical

            $fpdf->Line(15, 248, 195, 248); //Linea Inferior Horizontal


            // Agregamos los datos de la empresa
            $fpdf->Cell(5, $textypos, "Transporte La Garra C.A");
            $fpdf->SetFont('Arial', 'B', 8);
            $fpdf->setY(13);
            $fpdf->setX(145);
            $fpdf->Cell(5, $textypos, "RIF: J-13698756-1");

            $espacioIzquierda = 60;

            $espaciadoLetrasDerecha = 105;

            $cod = date('dmY-siH');

            // Agregamos los datos del cliente
            $fpdf->SetFont('Arial', 'B', 15);
            $fpdf->setY(25);
            $fpdf->Cell(190, $textypos, utf8_decode("AUDITORIA N°: ") . $cod, 20, 10, 'C');
            $fpdf->SetFont('Arial', 'B', 10);


            $fpdf->setY(33);
            $fpdf->setX(18);
            $fpdf->Cell(5, $textypos, "TIPO DE AUDITORIA: POR FECHAS");

            $fpdf->setY(33);
            $fpdf->setX(80);
            $fpdf->SetFont('Arial', '', 8);
            $fpdf->MultiCell(175, $textypos, 'DEL ' . date_format(new DateTime($request->fecha_inicio), 'd-m-Y')  . ' AL ' . date_format(new DateTime($request->fecha_fin), 'd-m-Y'));

            $fpdf->setY(38);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "USUARIO AUDITADO: ");

            $fpdf->setY(38);
            $fpdf->setX(56);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($selectUsuario[0]->login));

            $fpdf->setY(43);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "USUARIO AUDITOR: ");

            $fpdf->setY(43);
            $fpdf->setX(54);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode(Auth::user()->login));

            $fpdf->setY(48);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "DEPARTAMENTO DEL USUARIO: ");


            $fpdf->setY(48);
            $fpdf->setX(77);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($selectUsuario[0]->nom_dp));

            $fpdf->setY(33);
            $fpdf->setX(128);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "FECHA DE LA AUDITORIA: ");

            $fpdf->setY(33);
            $fpdf->setX(175);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, date('d-m-Y'));

            $fpdf->setY(38);
            $fpdf->setX(83);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "TIPO DE USUARIO: ");

            $fpdf->setY(38);
            $fpdf->setX(118);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($selectUsuario[0]->nombre_t));

            $fpdf->setY(43);
            $fpdf->setX(83);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "FECHA DEL REGISTRO DEL USUARIO:");

            $fpdf->setY(43);
            $fpdf->setX(151);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($selectUsuario[0]->created_at));

            $fpdf->SetFont('Arial', 'B', 13);
            $fpdf->setY(55);
            $fpdf->setX(104);
            $fpdf->Cell(5, $textypos, utf8_decode("DATOS DE LA AUDITORIA"), 20, 10, 'C');

            $fpdf->setY(65);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "MODELO AFECTADO:");

            $fpdf->setY(65);
            $fpdf->setX(58);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($datosAudit->auditable_type));

            $fpdf->setY(65);
            $fpdf->setX(120);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "TIPO DE EVENTO:");


            $fpdf->setY(65);
            $fpdf->setX(152);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($datosAudit->event));


            $fpdf->setY(71);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(20, 10, utf8_decode("DATOS VIEJOS: "));


            $fpdf->setY(78);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->old_values));

            $fpdf->setY(122);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(20, 10, utf8_decode("DATOS NUEVOS: "));

            $fpdf->setY(130);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->new_values));

            $fpdf->setY(177);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, utf8_decode("URL DE LA ACCIÓN: "));


            $fpdf->setY(182);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->url));

            $fpdf->setY(220);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, utf8_decode("DIRECCIÓN IP: "));

            $fpdf->setY(220);
            $fpdf->setX(45);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->ip_address));

            $fpdf->setY(228);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, utf8_decode("PLATAFORMA DE ACCESO: "));

            $fpdf->setY(232);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, utf8_decode($datosAudit->user_agent));

            $fpdf->setY(242.5);
            $fpdf->setX(18);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "FECHA DEL EVENTO: ");

            $fpdf->setY(242.5);
            $fpdf->setX(58);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->MultiCell(175, $textypos, $datosAudit->created_at);

            $fpdf->setY(250);
            $fpdf->setX(15);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode("Dirección: Madre Juana - San Cristóbal, Venezuela - Edo. Táchira"));
            $fpdf->setY(254);
            $fpdf->setX(15);
            $fpdf->Cell(5, $textypos, "Telf: (0276) 3462518");


            $fpdf->setY(260);
            $fpdf->setX(15);
            $fpdf->SetFont('Arial', 'B', 10);
        }
        $fpdf->output('auditoria-' . $cod  . '.pdf', 'I');
        exit;
    }
}
