
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});


function enviarFormRegistrarDepartamento() {

	let datos = $('#formularioRegistrarDepartamento').serialize();

	$.ajax({

		url: 'registrar_departamento',
		method: 'POST',
		data: datos,

		success: function (res) {
			toastr.success('Datos Guardados Correctamente')
			tabla.ajax.reload();
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});
}

function enviarFormActualizarDepartamento() {

	let datos = $('#formularioActulizarDepartamento').serialize();

	$.ajax({

		url: 'update_departamento',
		method: 'POST',
		data: datos,

		success: function (res) {
			toastr.success('Datos Actualizados Correctamente')
			tabla.ajax.reload();
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});
}

function limpiarFormulario() {
	document.getElementById("formularioRegistrarDepartamento").reset();
	document.getElementById('nombre').focus()
}

function mostrarformNew() {
	Swal.fire({
		title: 'Registrar Departamento',
		html:
			'<form action="" name="formularioRegistrarDepartamento" id="formularioRegistrarDepartamento" method="POST">' +
			'<br><label class="d-flex justify-content-start" for="">Nombre:</label><input type="text" autocomplete="off" placeholder="Nombre" name="nombre" id="nombre" class="form-control" required>' +
			'<br><label class="d-flex justify-content-start" for="">Descripción:</label><input type="text" name="descripcion" autocomplete="off" placeholder="Descripción" id="descripcion" class="form-control" required>' +
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
		focusConfirm: false
	})
}

function updateDepartamento(id) {
	$.post("mostrar_departamento_update", { id_departamento: id }, function (res) {
		Swal.fire({
			title: 'Actualizar Departamento: ' + res.nombre,
			html:
				'<form action="" name="formularioActulizarDepartamento" id="formularioActulizarDepartamento" method="POST">' +
				'<input type="hidden" name="id_departamento" id="id_departamento" value="' + res.iddepartamento + '">' +
				'<br><label class="d-flex justify-content-start" for="">Nombre:</label><input type="text" autocomplete="off" placeholder="Nombre" name="nombre" id="nombre" class="form-control" value="' + res.nombre + '" required>' +
				'<br><label class="d-flex justify-content-start" for="">Descripción:</label><input type="text" name="descripcion" autocomplete="off" placeholder="Descripción" id="descripcion" class="form-control" value="' + res.descripcion + '" required>' +
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
			focusConfirm: false
		})
	});
}

document.querySelector("#centro_central").addEventListener("submit", ev => {
	if (ev.target.matches('#formularioRegistrarDepartamento')) {
		ev.preventDefault()
		enviarFormRegistrarDepartamento()
	}
	if (ev.target.matches('#formularioActulizarDepartamento')) {
		ev.preventDefault()
		enviarFormActualizarDepartamento()
	}
})


var tabla;
//funcion que se ejecuta al inicio
function init() {
	$("#dep").addClass("active");
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
			url: 'listar_departamentos',
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

//funcion para desactivar activar y eliminar
function desactivar(iddepartamento) {
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function (result) {
		if (result) {
			$.post("desactivar_departamento", { iddepartamento: iddepartamento }, function (e) {
				toastr.success('Datos Desactivados Correctamente')
				tabla.ajax.reload();
			});
		}
	})
}

function activar(iddepartamento) {
	bootbox.confirm("¿Esta seguro de activar este dato?", function (result) {
		if (result) {
			$.post("activar_departamento", { iddepartamento: iddepartamento }, function (e) {
				toastr.success('Datos Activados Correctamente')
				tabla.ajax.reload();
			});
		}
	})
}

function eliminar(iddepartamento) {
	bootbox.confirm("¿Esta seguro de eliminar este dato?", function (result) {
		if (result) {
			$.post("eliminar_departamento", { iddepartamento: iddepartamento }, function (e) {
				toastr.success('Datos Eliminados Correctamente')
				tabla.ajax.reload();
			});
		}
	})
}
init();