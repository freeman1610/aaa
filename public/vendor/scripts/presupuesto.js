$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

//funcion que se ejecuta al inicio
function init() {

    $("#nom").addClass("active");
    $("#nom_a").addClass("active");
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
            url: 'listar_pre',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5,//paginacion
        "order": [[0, "desc"]]//ordenar (columna, orden)
    }).DataTable();
}

function limpiarFormulario() {
	document.getElementById("formularioCrearPre").reset();
	document.getElementById('presupuesto').focus()
}

function enviarFormCrearPresupuesto() {

	let datos = $('#formularioCrearPre').serialize();

	$.ajax({
		url: 'insertar_pre',
		method: 'POST',
		data: datos,

		success: function () {
			toastr.success('Datos Guardados Correctamente')
			tabla.ajax.reload();
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});
}

$("#btnPresupuesto").click(function(){
    clickAgregarPre();
});

function clickAgregarPre() {
    Swal.fire({
        title: '<strong>Asignación de Presupuesto</strong>',
        html:
            '<form action="" name="formularioCrearPre" id="formularioCrearPre" method="POST">' +
            '<br><label for="" class="d-flex justify-content-start">Asignar Presupuesto(*):</label><input class="form-control" type="text" name="presupuesto" id="presupuesto" minlength="1" required placeholder="Nuevo Presupuesto" autocomplete="off" onkeypress="return SoloNumeros(event)">' +
            '<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" id="botonSubmitNomina" type="submit">' +
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
}

document.querySelector("#centro_central").addEventListener("submit", ev => {

	if (ev.target.matches('#formularioCrearPre')) {
		ev.preventDefault()
		enviarFormCrearPresupuesto()
	}

});


init();
