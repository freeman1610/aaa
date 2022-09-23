$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function mostrarform() {
    // $.post("listar_crear_viaje", function (res) {
    Swal.fire({
        title: '<strong>Crear Viaje</strong>',
        html:
            '<form action="" name="formularioCrearViaje" id="formularioCrearViaje" method="POST">' +
            '<br><label class="d-flex justify-content-between" for="">Codigo(*): <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><input type="text" name="viaje_codigo" placeholder="Codigo" id="viaje_codigo" class="form-control" required>' +
            // '<br><label class="d-flex justify-content-start" for="">Chofer (*):</label>' +
            // '<select class="form-control" required name="viaje_chofer" id="viaje_chofer">' +
            // res.choferes +
            // '</select>' +
            // '<br><label class="d-flex justify-content-start" for="">Chuto (*):</label>' +
            // '<select class="form-control" required name="viaje_chuto" id="viaje_chuto">' +
            // res.chutos +
            // '</select>' +
            // '<br><label class="d-flex justify-content-start" for="">Cava (*):</label>' +
            // '<select class="form-control" required name="viaje_cava" id="viaje_cava">' +
            // res.cavas +
            // '</select>' +

            '<br><label class="d-flex justify-content-start" for="">¿Este Viaje tiene Flete de IDA?</label>' +
            '<select class="form-control" required name="comprobar_flete_ida" id="comprobar_flete_ida">' +
            '<option value="">Seleccione</option>' +
            '<option value="si">Si</option>' +
            '<option value="no">No</option>' +
            '</select>' +

            '<br><label class="d-flex justify-content-start" for="">¿Este Viaje tiene Flete de RETORNO?</label>' +
            '<select class="form-control" required name="comprobar_flete_retorno" id="comprobar_flete_retorno">' +
            '<option value="">Seleccione</option>' +
            '<option value="si">Si</option>' +
            '<option value="no">No</option>' +
            '</select>' +

            // '<br><label class="d-flex justify-content-start" for="">Flete Ida: (*):</label>' +
            // '<select class="form-control" required name="viaje_flete_ida" id="viaje_flete_ida">' +
            // res.fletes_ida +
            // '</select>' +
            // '<br><label class="d-flex justify-content-start" for="">Flete Retorno: (*):</label>' +
            // '<select class="form-control" required name="viaje_flete_retorno" id="viaje_flete_retorno">' +
            // res.fletes_retorn +
            // '</select>' +
            '<br><label class="d-flex justify-content-start" for="">Descripcion de la Carga:</label><input type="text" name="viaje_descripcion" autocomplete="off" placeholder="Descripción Carga" id="viaje_descripcion" class="form-control" required>' +
            '<br><label class="d-flex justify-content-start" for="">Dia de Salida:</label><input type="date" class="form-control" name="viaje_dia_salida" id="viaje_dia_salida"  autocomplete="off">' +
            '<br><label class="d-flex justify-content-start" for="">Dia de Retorno:</label><input type="date" class="form-control" name="viaje_dia_retorno" id="viaje_dia_retorno"  autocomplete="off">' +
            '<br><label class="d-flex justify-content-start" for="">Observacion del Viaje:</label><input type="text" name="viaje_observacion" autocomplete="off" placeholder="Observación Viaje" id="viaje_observacion" class="form-control" required>' +
            '<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" type="submit">' +
            'Guardar' +
            '</button>' +
            '<button class="btn btn-info mt-3 ml-2" onclick="limpiarFormulario()" type="button">' +
            'Limpiar' +
            '</button></div>' +
            '</form>',
        showCloseButton: true,
        showConfirmButton: false,
        showCancelButton: false,
        focusConfirm: false,
    })
    // });

}

document.querySelector("#centro_central").addEventListener("change", ev => {

    if (ev.target.matches('#comprobar_flete_ida')) {

        let estado = document.getElementById('comprobar_flete_ida').value

        switch (estado) {
            case 'si':
                console.log('busco fle ida');
                break;
        }

        // $.post("listar_fletes", function (res) {

        //     document.getElementById('flete_destino_parroquia').innerHTML = res.parroquias
        //     $("#flete_destino_parroquia").prop("disabled", false);

        // });
    }

    if (ev.target.matches('#comprobar_flete_retorno')) {

        let estado = document.getElementById('comprobar_flete_retorno').value

        switch (estado) {
            case 'si':
                console.log('busco fle retorno');
                break;
        }

        // $.post("listar_fletes", function (res) {

        //     document.getElementById('flete_destino_parroquia').innerHTML = res.parroquias
        //     $("#flete_destino_parroquia").prop("disabled", false);

        // });
    }

});

function limpiarFormulario() {
    document.getElementById("formularioCrearViaje").reset();
    document.getElementById('viaje_codigo').focus()
}
var tabla;

//funcion que se ejecuta al inicio
function init() {
    $("#fletes").addClass(" active");

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
            url: 'listar_viajes',
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