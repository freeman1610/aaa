
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

function enviarFormRegistrarCava() {

	let datos = $('#formularioRegistrarCava').serialize();

	$.ajax({
		url: 'registrar_cava',
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

function updateCava(id) {

	$.post("mostrar_cava", { cava_id: id }, function (res) {
		Swal.fire({
			title: 'Actualizar Cava',
			html:
				'<form action="" name="formularioActulizarCava" id="formularioActulizarCava" method="POST">' +
				'<input type="hidden" name="cava_id" id="cava_id" value="' + res[0].cava_id + '">' +
				'<br><label class="d-flex justify-content-between" for="">Placa: </label><input type="text" autocomplete="off" name="cava_placa" placeholder="Placa" maxlength="100" id="cava_placa" class="form-control" value="' + res[0].cava_placa + '" required>' +
				'<br><label class="d-flex justify-content-start" for="">Modelo:</label><input type="text" autocomplete="off" placeholder="Modelo" name="cava_modelo" id="cava_modelo" class="form-control" value="' + res[0].cava_modelo + '" required>' +
				'<br><label class="d-flex justify-content-start" for="">Marca:</label><input type="text" autocomplete="off" placeholder="Marca" name="cava_marca" id="cava_marca" class="form-control" value="' + res[0].cava_marca + '" required>' +
				'<br><label class="d-flex justify-content-start" for="">Estado del Cava</label>' +
				'<select name="cava_estado" id="cava_estado" class="form-control" required>' + res[1] + '</select>' +
				'<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" type="submit">' +
				'Guardar' +
				'</button>' +
				'</form>',
			showCloseButton: true,
			showConfirmButton: false,
			showCancelButton: false,
			focusConfirm: false
		})
	});
}

function enviarFormActualizarCava() {
	let datos = $('#formularioActulizarCava').serialize();
	$.ajax({
		url: 'actualizar_cava',
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
	document.getElementById("formularioRegistrarCava").reset();
	document.getElementById('codigo').focus()
}

function mostrarformNew() {
	Swal.fire({
		title: 'Registrar Cava',
		html:
			'<form action="" name="formularioRegistrarCava" id="formularioRegistrarCava" method="POST">' +
			'<br><label class="d-flex justify-content-between" for="">Placa: <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><input type="text" autocomplete="off" name="cava_placa" placeholder="Placa" maxlength="100" id="cava_placa" class="form-control" required>' +
			'<br><label class="d-flex justify-content-start" for="">Modelo:</label><input type="text" autocomplete="off" placeholder="Modelo" name="cava_modelo" id="cava_modelo" class="form-control" required>' +
			'<br><label class="d-flex justify-content-start" for="">Marca:</label><input type="text" autocomplete="off" placeholder="Marca" name="cava_marca" id="cava_marca" class="form-control" required>' +
			'<br><label class="d-flex justify-content-start" for="">Estado del Cava</label>' +
			'<select name="cava_estado" id="cava_estado" class="form-control" required>' +
			'<option value="">Seleccione</option>' +
			'<option value="ACTIVO">ACTIVO</option>' +
			'<option value="TALLER">TALLER</option>' +
			'<option value="FUERA DE SERVICIO">FUERA DE SERVICIO</option>' +
			'</select>' +
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
document.querySelector("#centro_central").addEventListener("submit", ev => {
	if (ev.target.matches('#formularioRegistrarCava')) {
		ev.preventDefault()
		enviarFormRegistrarCava()
	}
	if (ev.target.matches('#formularioActulizarCava')) {
		ev.preventDefault()
		enviarFormActualizarCava()
	}
})


var tabla;

//funcion que se ejecuta al inicio
function init() {
	$("#transporte").addClass("active");
	$("#cavas").addClass("active");
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
			url: 'listar_cavas',
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


function eliminar(cava_id) {
	bootbox.confirm("¿Esta seguro de eliminar este dato?", function (result) {
		if (result) {
			$.post("eliminar_cava", { cava_id: cava_id }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
init();