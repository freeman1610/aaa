$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function generarPago() {
    $.ajax({
        url: 'mostrar_pagos_disponibles',
        type: 'POST',
        success: function (res) {
            if (res.error == 1) {
                return toastr.info(res.message)
            }
            let ht = '<form action="" name="formularioPagoNominaChofer" id="formularioPagoNominaChofer" method="POST">' +
                '<br><label class="d-flex justify-content-start" for="">Codigo Del Viaje (*):</label>' +
                '<select class="form-control" required name="viaje_id" id="viaje_id">' +
                res.viajes +
                '</select>' +
                '<table class="table d-none" id="tablaValores">' +
                '<tbody>' +
                '<tr>' +
                '<td class="align-middle">Chofer:</td>' +
                '<td id="datosChofer"></td>' +
                '</tr>' +
                '<tr>' +
                '<td>Flete Ida:</td>' +
                '<td id="cod_flete_ida"></td>' +
                '</tr>' +
                '<tr>' +
                '<td>Flete Retorno:</td>' +
                '<td id="cod_flete_retorno"></td>' +
                '</tr>' +
                '<tr>' +
                '<td>Suma del Valor de Ambos Fletes:</td>' +
                '<td id="suma_valores_fletes"></td>' +
                '</tr>' +
                '<tr>' +
                '<td>Total a Pagar al Chofer:</td>' +
                '<td id="total_chofer"></td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '<div class="d-flex justify-content-center"><button class="btn btn-success mt-3" type="submit" id="boton_submit">' +
                'Realizar Pago' +
                '</button>' +
                '</div>' +
                '</form>'
            Swal.fire({
                title: 'Pago Nomina Chofer',
                html: ht,
                showConfirmButton: false,
                showCloseButton: true
            })
        },
        error: function (err) {
            toastr.error(err.responseJSON.message)
        }
    });
}

document.querySelector("#centro_central").addEventListener("change", ev => {
    if (ev.target.matches('#viaje_id')) {
        if ($("#viaje_id").val() == '') {
            return
        }
        $.ajax({
            url: 'listar_datos_viaje',
            method: 'POST',
            data: 'viaje_id=' + $("#viaje_id").val(),

            success: function (res) {
                $("#datosChofer").html(res.datosChofer)
                $("#cod_flete_ida").text(res.cod_flete_ida)
                $("#cod_flete_retorno").text(res.cod_flete_retorno)
                $("#suma_valores_fletes").text(res.suma_valores_fletes)
                $("#total_chofer").text(res.total_chofer)
                $("#tablaValores").removeClass('d-none')
            },

            error: function (err) {
                toastr.error(err.responseJSON.message);
            }

        });
    }
})


var tabla;

//funcion que se ejecuta al inicio
function init() {
    $("#nom_chofer").addClass("active");
    $("#nom").addClass("active");
    listar();
}

//funcion listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,//activamos el procedimiento del datatable
        "aServerSide": true,//paginacion y filrado realizados por el server
        "responsive": true, "lengthChange": false, "autoWidth": false,
        dom: 'Bfrtip',//definimos los elementos del control de la tabla
        buttons: [
            'copy',
            'excel',
            'pdf',
            'print',
            'colvis'
        ],
        "ajax":
        {
            url: 'listar_nomina_chofer',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10,//paginacion
        "order": [[0, "desc"]]//ordenar (columna, orden)
    }).DataTable();
}
init();