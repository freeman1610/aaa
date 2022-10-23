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
        if (!$request->hasValidSignature()) {
            abort(401);
        }
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
                ->select(
                    'fletes.flete_codigo',
                    'fletes.flete_valor_en_carga',
                    'fletes.flete_valor_sin_carga',
                    'estados.estado',
                    'municipios.municipio',
                    'parroquias.parroquia'
                )
                ->get();
        }
        if ($datosViaje[0]->viajes_idflete_retorno != NULL) {
            $fleteRetorno = Flete::where('fletes.flete_id', '=', $datosViaje[0]->viajes_idflete_retorno)
                ->join('estados', 'estados.id_estado', '=', 'fletes.flete_destino_estado')
                ->join('municipios', 'municipios.id_municipio', '=', 'fletes.flete_destino_municipio')
                ->join('parroquias', 'parroquias.id_parroquia', '=', 'fletes.flete_destino_parroquia')
                ->select(
                    'fletes.flete_codigo',
                    'fletes.flete_valor_en_carga',
                    'fletes.flete_valor_sin_carga',
                    'estados.estado',
                    'municipios.municipio',
                    'parroquias.parroquia'
                )
                ->get();
        }

        $fpdf->AddPage();
        $fpdf->SetTitle('Pago Viaje', true);
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

        $codigoHash = random_int(100000, 9999999) . '-' . $selectChofer->cedula . '-' . date_format(new DateTime($nomina->created_at), 'dmY');

        // viajes_codigo


        $fpdf->Cell(190, $textypos, utf8_decode("RECIBO DE PAGO DEL VIAJE: N° ") . $codigoHash, 20, 10, 'C');

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
        $fpdf->Cell(5, $textypos, utf8_decode($selectChofer->apellido . ' ' . $selectChofer->nombre));

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

        $fpdf->setY(70);
        $fpdf->setX(20);
        $fpdf->SetFont('Arial', 'B', 13);
        $fpdf->Cell(5, $textypos, "DATOS DEL VIAJE:");
        $fpdf->SetFont('Arial', 'B', 10);

        $fpdf->setY(75);
        $fpdf->setX(20);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Codigo:");

        $fpdf->setY(75);
        $fpdf->setX(35);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode($datosViaje[0]->viajes_codigo));

        $fpdf->setY(80);
        $fpdf->setX(20);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, utf8_decode("Descripción de la Carga:"));

        $fpdf->setY(80);
        $fpdf->setX(63);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode($datosViaje[0]->viajes_descripciondelacargar));

        $fpdf->setY(85);
        $fpdf->setX(20);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, utf8_decode("Observación del Viaje:"));

        $fpdf->setY(85);
        $fpdf->setX(60);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode($datosViaje[0]->viajes_observaciones));

        $fpdf->setY(90);
        $fpdf->setX(20);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Fecha de Salida:");

        $fpdf->setY(90);
        $fpdf->setX(50);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, date_format(new DateTime($datosViaje[0]->viajes_dia_salida), 'd-m-Y'));


        $fpdf->setY(95);
        $fpdf->setX(20);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, "Fecha de Retorno:");

        $fpdf->setY(95);
        $fpdf->setX(53);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, date_format(new DateTime($datosViaje[0]->viajes_dia_retorno), 'd-m-Y'));

        $fpdf->Line(138, 58, 138, 112); //Linea Vertical Entre Datos del Viaje, Chuto, Cava

        $fpdf->Line(138, 85, 195, 85); //Linea Horizontal Entre Datos del Chuto y Cava

        $fpdf->setY(60);
        $fpdf->setX(140);
        $fpdf->SetFont('Arial', 'B', 13);
        $fpdf->Cell(5, $textypos, "CHUTO:");
        $fpdf->SetFont('Arial', 'B', 10);

        $fpdf->setY(66);
        $fpdf->setX(142);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode("Placa: " . $datosViaje[0]->chuto_placa));

        $fpdf->setY(71);
        $fpdf->setX(142);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode("Marca: " . $datosViaje[0]->chuto_marca));

        $fpdf->setY(77);
        $fpdf->setX(142);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode("Modelo: " . $datosViaje[0]->chuto_modelo));


        $fpdf->setY(86);
        $fpdf->setX(140);
        $fpdf->SetFont('Arial', 'B', 13);
        $fpdf->Cell(5, $textypos, "CAVA:");
        $fpdf->SetFont('Arial', 'B', 10);

        $fpdf->setY(92);
        $fpdf->setX(142);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode("Placa: " . $datosViaje[0]->cava_placa));

        $fpdf->setY(97);
        $fpdf->setX(142);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode("Marca: " . $datosViaje[0]->cava_marca));

        $fpdf->setY(102);
        $fpdf->setX(142);
        $fpdf->SetFont('Arial', '', 10);
        $fpdf->Cell(5, $textypos, utf8_decode("Modelo: " . $datosViaje[0]->cava_modelo));


        $fpdf->Line(15, 112, 195, 112); //Linea Horizontal

        $fpdf->setY(115);
        $fpdf->setX(28);
        $fpdf->SetFont('Arial', 'B', 13);
        $fpdf->Cell(5, $textypos, "DATOS DEL FLETE DE IDA:");

        if ($datosViaje[0]->viajes_idflete_ida != NULL) {
            $fpdf->setY(122);
            $fpdf->setX(20);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Codigo del Flete:");

            $fpdf->setY(122);
            $fpdf->setX(50);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($fleteIda[0]->flete_codigo));

            // CAJA DEL DESTINO FLETE IDA
            // ----------X---Y---X---Y
            $fpdf->Line(18, 128, 18, 148); //Linea Izquierda Vertical

            $fpdf->Line(18, 128, 102, 128); //Linea Superior Horizontal

            $fpdf->Line(102, 128, 102, 148); // Linea Derecha Vertical

            $fpdf->Line(18, 148, 102, 148); //Linea Inferior Horizontal

            $fpdf->setY(128);
            $fpdf->setX(51);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Destino:");

            $fpdf->setY(132);
            $fpdf->setX(20);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Estado:");

            $fpdf->setY(132);
            $fpdf->setX(35);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($fleteIda[0]->estado));

            $fpdf->setY(137);
            $fpdf->setX(20);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Municipio:");

            $fpdf->setY(137);
            $fpdf->setX(40);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($fleteIda[0]->municipio));

            $fpdf->setY(142);
            $fpdf->setX(20);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Parroquia:");

            $fpdf->setY(142);
            $fpdf->setX(40);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($fleteIda[0]->parroquia));

            $fpdf->setY(149);
            $fpdf->setX(20);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Valor en Carga:");

            $fpdf->setY(149);
            $fpdf->setX(50);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, 'VES ' . $fleteIda[0]->flete_valor_en_carga . ',00');

            $fpdf->setY(154);
            $fpdf->setX(20);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Valor Sin Carga:");

            $fpdf->setY(154);
            $fpdf->setX(51);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, 'VES ' . $fleteIda[0]->flete_valor_sin_carga . ',00');
        } else {
            $fpdf->setY(135);
            $fpdf->setX(27.5);
            $fpdf->SetFont('Arial', 'B', 15);
            $fpdf->Cell(5, $textypos, "No Aplica, Solo Retorno");
        }



        $fpdf->Line(105, 112, 105, 163); //Linea Vertical entre Datos Flete Ida y Retorno

        $fpdf->setY(115);
        $fpdf->setX(111);
        $fpdf->SetFont('Arial', 'B', 13);
        $fpdf->Cell(5, $textypos, "DATOS DEL FLETE DE RETORNO:");

        if ($datosViaje[0]->viajes_idflete_retorno != NULL) {
            $fpdf->setY(122);
            $fpdf->setX(111);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Codigo del Flete:");

            $fpdf->setY(122);
            $fpdf->setX(141);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($fleteRetorno[0]->flete_codigo));

            // CAJA DEL DESTINO FLETE IDA
            // ----------X---Y---X---Y
            $fpdf->Line(108, 128, 108, 148); //Linea Izquierda Vertical

            $fpdf->Line(108, 128, 190, 128); //Linea Superior Horizontal

            $fpdf->Line(190, 128, 190, 148); // Linea Derecha Vertical

            $fpdf->Line(108, 148, 190, 148); //Linea Inferior Horizontal

            $fpdf->setY(128);
            $fpdf->setX(141);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Destino:");

            $fpdf->setY(132);
            $fpdf->setX(111);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Estado:");

            $fpdf->setY(132);
            $fpdf->setX(126);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($fleteRetorno[0]->estado));

            $fpdf->setY(137);
            $fpdf->setX(111);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Municipio:");

            $fpdf->setY(137);
            $fpdf->setX(131);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($fleteRetorno[0]->municipio));

            $fpdf->setY(142);
            $fpdf->setX(111);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Parroquia:");

            $fpdf->setY(142);
            $fpdf->setX(131);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, utf8_decode($fleteRetorno[0]->parroquia));

            $fpdf->setY(149);
            $fpdf->setX(111);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Valor en Carga:");

            $fpdf->setY(149);
            $fpdf->setX(139);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, 'VES ' . $fleteRetorno[0]->flete_valor_en_carga . ',00');

            $fpdf->setY(154);
            $fpdf->setX(111);
            $fpdf->SetFont('Arial', 'B', 10);
            $fpdf->Cell(5, $textypos, "Valor Sin Carga:");

            $fpdf->setY(154);
            $fpdf->setX(140);
            $fpdf->SetFont('Arial', '', 10);
            $fpdf->Cell(5, $textypos, 'VES ' . $fleteRetorno[0]->flete_valor_sin_carga . ',00');
        } else {
            $fpdf->setY(138);
            $fpdf->setX(123);
            $fpdf->SetFont('Arial', 'B', 15);
            $fpdf->Cell(5, $textypos, "No Aplica, Solo Ida");
        }




        // Lineas de cajas 
        $fpdf->Line(15, 23, 15, 240); //Linea Izquierda Vertical

        $fpdf->Line(15, 23, 195, 23); //Linea Superior Horizontal

        $fpdf->Line(15, 163, 195, 163); //Linea Medio Horizontal

        $fpdf->Line(195, 240, 195, 23); //Linea Derecha Vertical

        $fpdf->Line(15, 240, 195, 240); //Linea Inferior Horizontal

        // Huella XD

        $fpdf->Line(35, 190, 35, 220);
        $fpdf->Line(35, 190, 65, 190);

        $fpdf->setY(204);
        $fpdf->setX(44);
        $fpdf->SetFont('Arial', 'B', 10);
        $fpdf->Cell(5, $textypos, 'Huella');

        $fpdf->Line(65, 220, 65, 190);
        $fpdf->Line(35, 220, 65, 220);

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

        $fpdf->output("pago-nomina-chofer-" . $codigoHash . '.pdf', 'I');
        exit;
    }
}
