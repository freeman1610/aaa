
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function registrarNewReplies() {
    let ht = '<form id="form_insert_chat_bot" name="form_insert_chat_bot">' +
        '<br><label class="d-flex justify-content-between" for="">Pregunta: <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><input type="text" name="pregunta" autocomplete="off" placeholder="Pregunta" id="pregunta" class="form-control" required>' +
        '<br><label class="d-flex justify-content-start" for="">Respuesta:</label><input type="text" name="respuesta" autocomplete="off" placeholder="Respuesta" id="respuesta" class="form-control" required>' +
        '<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" type="submit">' +
        'Guardar' +
        '</button></div>' +
        '</form>'

    Swal.fire({
        title: 'Registrar Datos',
        html: ht,
        showConfirmButton: false,
        showCloseButton: true
    })

}

function enviarFormInsert() {
    let datos = $('#form_insert_chat_bot').serialize()
    $.ajax({
        url: 'update_chat_bot',
        type: 'POST',
        data: datos,
        success: function () {
            toastr.success('Datos Registrados Correctamente');
            tabla.ajax.reload();
        },
        error: function (err) {
            toastr.error(err.responseJSON.message);
        }
    })
}

function updateChatBot(id) {

    $.post('mostrar_chat_bot', { id: id }, function (res) {

        let ht = '<form id="form_update_chat_bot" name="form_update_chat_bot">' +
            '<input type="hidden" id="id" name="id" value="' + res.id + '">' +
            '<br><label class="d-flex justify-content-start" for="">Pregunta:</label><input type="text" name="pregunta" autocomplete="off" placeholder="Pregunta" id="pregunta" class="form-control" required value="' + res.queries + '">' +
            '<br><label class="d-flex justify-content-start" for="">Respuesta:</label><input type="text" name="respuesta" autocomplete="off" placeholder="Respuesta" id="respuesta" class="form-control" required value="' + res.replies + '">' +
            '<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" type="submit">' +
            'Guardar' +
            '</button></div>' +
            '</form>'

        Swal.fire({
            title: 'Actualizar Datos',
            html: ht,
            showConfirmButton: false,
            showCloseButton: true
        })

    })

}

function enviarFormUpdate() {
    let datos = $('#form_update_chat_bot').serialize()
    $.ajax({
        url: 'update_chat_bot',
        type: 'POST',
        data: datos,
        success: function () {
            toastr.success('Datos Actulizados Correctamente');
            tabla.ajax.reload();
        },
        error: function (err) {
            toastr.error(err.responseJSON.message);
        }
    })
}

document.querySelector("#centro_central").addEventListener("submit", ev => {
    if (ev.target.matches('#form_update_chat_bot')) {
        ev.preventDefault()
        enviarFormUpdate()
    }

    if (ev.target.matches('#form_insert_chat_bot')) {
        ev.preventDefault()
        enviarFormInsert()
    }
})

function limpiarFormulario() {
    document.getElementById("form_insert_chat_bot").reset();
    document.getElementById('pregunta').focus()
}

var tabla;

//funcion que se ejecuta al inicio
function init() {
    $('#acc').addClass('active');
    $('#chat_bot').addClass('active');
    listar();
}

//funcion listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        'aProcessing': true,//activamos el procedimiento del datatable
        'aServerSide': true,//paginacion y filrado realizados por el server
        'responsive': true, 'lengthChange': false, 'autoWidth': false,
        dom: 'Bfrtip',//definimos los elementos del control de la tabla
        buttons: [
            'copy',
            'excel',
            'pdf',
            'print',
            'colvis'
        ],
        'ajax':
        {
            url: 'list_chat_bot',
            type: 'post',
            dataType: 'json',
            error: function (e) {
                console.log(e.responseText);
            }
        },
        'bDestroy': true,
        'iDisplayLength': 10,//paginacion
        'order': [[0, 'desc']]//ordenar (columna, orden)
    }).DataTable();
}

function eliminar(id) {
    bootbox.confirm('¿Esta seguro de eliminar este dato?', function (result) {
        if (result) {
            $.post('delete_chat_bot', { id: id }, function (e) {
                toastr.success('Datos Eliminados Correctamente');
                tabla.ajax.reload();
            });
        }
    })
}
init();