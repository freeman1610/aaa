$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var tabla;

//funcion que se ejecuta al inicio
function init() {
    $("#viajes_comp").addClass("active");
    $("#transporte").addClass("active");
    listar();
}

function detallesViaje(id, text_cod) {
    $.ajax({
        url: 'boton_ver_detalles',
        method: 'POST',
        data: 'viaje_id=' + id,

        success: function (res) {
            let tab = '<table class="table">' +
                '<tbody>' +
                '<tr>' +
                '<td class="align-middle">Chofer:</td>' +
                '<td>' + res.chofer + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="align-middle">Chuto:</td>' +
                '<td>' + res.chuto + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="align-middle">Cava:</td>' +
                '<td>' + res.cava + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="align-middle">Flete Ida:</td>' +
                '<td class="align-middle">' + res.flete_ida + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="align-middle">Flete Retorno:</td>' +
                '<td class="align-middle">' + res.flete_retorno + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="align-middle">Descripción de la Carga:</td>' +
                '<td class="align-middle">' + res.descripcion + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Dia Salida:</td>' +
                '<td>' + res.dia_salida + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Dia Retorno:</td>' +
                '<td>' + res.dia_retorno + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="align-middle">Observaciones:</td>' +
                '<td class="align-middle">' + res.observaciones + '</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>'
            Swal.fire({
                title: 'Detalles del Viaje <span class="text-success">' + text_cod + '</span>',
                html: tab,
                showConfirmButton: false,
                showCloseButton: true
            })
        },

        error: function (err) {
            toastr.error(err.responseJSON.message)
        }

    })
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
            url: 'listar_viaje_completado',
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