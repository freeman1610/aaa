<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Empleado;
use App\Models\Flete;
use App\Models\NominaChofer;
use App\Models\Viaje;
use Codedge\Fpdf\Fpdf\Fpdf;
use DateTime;
use Illuminate\Http\Request;

class PdfNominaChoferController extends Controller
{
    public function pdfNominaChofer(Request $request, Fpdf $fpdf)
    {
        $this->validate($request, [
            'id' => 'required|numeric'
        ]);

        $nomina = NominaChofer::find($request->id);

        $selectChofer = Empleado::find($nomina->id_chofer);

        $datosViaje = Viaje::where('viajes.viajes_id', '=', $nomina->id_viaje)
            ->join('chutos', 'chutos.chuto_id', '=', 'viajes.viajes_idchuto')
            ->join('cavas', 'cavas.cava_id', '=', 'viajes.viajes_idcava')
            ->select(
                'viajes.viajes_codigo',

                'chutos.chuto_placa',
                'chutos.chuto_modelo',
                'chutos.chuto_marca',

                'cavas.cava_placa',
                'cavas.cava_modelo',
                'cavas.cava_marca',

                'viajes.viajes_idflete_ida',
                'viajes.viajes_idflete_retorno',

                'viajes.viajes_descripciondelacargar',
                'viajes.viajes_dia_salida',
                'viajes.viajes_dia_retorno',
                'viajes.viajes_observaciones'
            )
            ->get();

        if ($datosViaje[0]->viajes_idflete_ida != NULL) {
            $fleteIda = Flete::where('fletes.flete_id', '=', $datosViaje[0]->viajes_idflete_ida)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select('fletes.flete_codigo', 'estados.estado', 'municipios.municipio', 'parroquias.parroquia')
                ->get();
        }
        if ($datosViaje[0]->viajes_idflete_retorno != NULL) {
            $fleteRetorno = Flete::where('fletes.flete_id', '=', $datosViaje[0]->viajes_idflete_retorno)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select(
                    'fletes.flete_codigo',
                    'estados.estado',
                    'municipios.municipio',
                    'parroquias.parroquia'
                )
                ->get();
        }

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

        // Agregamos los datos del cliente
        $fpdf->SetFont('Arial', 'B', 15);
        $fpdf->setY(25);
        $fpdf->setX(50);
        $fpdf->Cell(5, $textypos, "RECIBO DE PAGO DEL VIAJE: XXXXXX");

        $fpdf->Line(15, 32, 195, 32); //Linea Horizontal

        $fpdf->setY(35);
        $fpdf->setX(75);
        $fpdf->SetFont('Arial', 'B', 13);
        $fpdf->Cell(5, $textypos, "DATOS DEL CHOFER:");
        $fpdf->SetFont('Arial', 'B', 10);


        $fpdf->Line(15, 58, 195, 58); //Linea Horizontal



        $fpdf->setY(45);
        $fpdf->setX(20);
        $fpdf->Cell(5, $textypos, "Apellidos y Nombres:");

        $fpdf->setY(50);
        $fpdf->setX(21);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode($selectChofer->nombre . ' ' . $selectChofer->apellido));

        $fpdf->setY(45);
        $fpdf->setX(80);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Cedula de Identidad:");

        $fpdf->setY(45);
        $fpdf->setX(117);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, $selectChofer->cedula);

        $fpdf->setY(50);
        $fpdf->setX(80);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Fecha de Pago:");

        $fpdf->setY(50);
        $fpdf->setX(108);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, date_format(new DateTime($nomina->created_at), 'd-m-Y'));

        $fpdf->setY(45);
        $fpdf->setX(135);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Cargo:");

        $fpdf->setY(45);
        $fpdf->setX(148);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode($selectChofer->cargo));

        $fpdf->setY(50);
        $fpdf->setX(135);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Fecha de Ingreso:");

        $fpdf->setY(50);
        $fpdf->setX(167);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, date_format(new DateTime($selectChofer->fecha_ingreso), 'd-m-Y'));

        $fpdf->setY(60);
        $fpdf->setX(75);
        $fpdf->SetFont('Arial', 'B', 13);
        $fpdf->Cell(5, $textypos, "DATOS DEL VIAJE:");
        $fpdf->SetFont('Arial', 'B', 10);

        $fpdf->setY(70);
        $fpdf->setX(20);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Codigo del Viaje:");

        $fpdf->setY(70);
        $fpdf->setX(50);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode($datosViaje[0]->viajes_codigo));

        // Lineas de cajas
        $fpdf->Line(15, 23, 15, 240); //Linea Izquierda Vertical

        $fpdf->Line(15, 23, 195, 23); //Linea Superior Horizontal

        $fpdf->Line(15, 175, 195, 175); //Linea Medio Horizontal

        $fpdf->Line(195, 240, 195, 23); //Linea Derecha Vertical

        $fpdf->Line(15, 240, 195, 240); //Linea Inferior Horizontal

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
        $fpdf->Cell(5, $textypos, 'VES ' . number_format($nomina->pago_total, 3) . ',00');

        $fpdf->Line(90, 225, 150, 225);

        $fpdf->setY(227);
        $fpdf->setX(107);
        $fpdf->SetFont('Arial', '', 8);
        $fpdf->Cell(5, $textypos, 'Recibe Conforme');

        $fpdf->setY(230);
        $fpdf->setX(110);
        $fpdf->SetFont('Arial', '', 7);
        $fpdf->Cell(5, $textypos, utf8_decode($selectChofer->nombre . ' ' . $selectChofer->apellido));


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

        $codigoHash = random_int(100000, 9999999) . '-' . $selectChofer->cedula . '-' . date_format(new DateTime($nomina->created_at), 'dmY');

        $fpdf->Cell(5, $textypos, "COD: " . $codigoHash);

        $fpdf->output("pago-nomina-" . $codigoHash . '.pdf', 'I');
        exit;
    }
}
