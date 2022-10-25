
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

function autUsuairo() {
	$.ajax({
		url: 'listar_usuarios_audt',
		method: 'POST',
		success: function (res) {
			Swal.fire({
				title: 'Auditar Usuario',
				html:
					'<form action="" name="formularioAuditUsuario" id="formularioAuditUsuario" method="POST">' +
					'<br><label class="d-flex justify-content-start" for="">Seleccione el Usuario ha Auditar</label>' +
					'<select name="usuario" id="usuario" class="form-control" required>' + res.usuarios + '</select>' +
					'<div class="d-flex justify-content-around" id="botonUrlUsuario"><button class="btn btn-success mt-3" type="submit">' +
					'Generar PDF' +
					'</button></div>' +
					'</form>',
				showCloseButton: true,
				showConfirmButton: false,
				showCancelButton: false,
				focusConfirm: false
			})
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});
}

function generarUrlPDFUsuario() {

	let datos = $('#formularioAuditUsuario').serialize();

	$.ajax({
		url: 'generar_url_audt_usuario',
		method: 'POST',
		data: datos,
		success: function (res) {
			$('#botonUrlUsuario').html(res.urlPDF)
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});

}

function GenerarPDFXfechas() {
	Swal.fire({
		title: '<strong>Seleccione el rango de Fechas</strong>',
		html:
			'<form name="formGenerarPDFXfechas" id="formGenerarPDFXfechas" method="post">' +
			'<div class="d-flex justify-content-between">' +
			'<div>' +
			'<label for="">Fecha Inicio</label>' +
			'<input type="date" class="form-control" required id="fecha_inicio" name="fecha_inicio">' +
			'</div>' +
			'<div>' +
			'<label for="">Fecha Fin</label>' +
			'<input type="date" class="form-control" required id="fecha_fin" name="fecha_fin">' +
			'</div>' +
			'</div><br>' +
			'<div class="d-flex justify-content-center" id="contenidoPDFXdate"><button class="btn btn-success" type="submit"><span class="fas fa-file-signature"></span> Generar</button></div>' +
			'</form>',
		showCloseButton: true,
		showConfirmButton: false,
		showCancelButton: false,
		focusConfirm: false,
	})

}

function enviarConsultaPDFXfechas() {

	let fecha_inicio = document.getElementById('fecha_inicio').value
	let fecha_fin = document.getElementById('fecha_fin').value
	// Compruebo fechas
	if (fecha_inicio > fecha_fin) {

		toastr.error('No puedes realizar una busqueda desde el ' + fecha_fin + ' al ' + fecha_inicio)

	} else {
		let datos = $('#formGenerarPDFXfechas').serialize();
		$.ajax({
			url: 'generar_url_audt_fechas',
			method: 'POST',
			data: datos,
			success: function (res) {
				$('#contenidoPDFXdate').html(res.contentHMTL)
			},

			error: function (err) {
				toastr.error(err.responseJSON.message)
			}

		});
	}
}

document.querySelector("#centro_central").addEventListener("submit", ev => {

	if (ev.target.matches('#formularioAuditUsuario')) {
		ev.preventDefault()
		generarUrlPDFUsuario()
	}
	if (ev.target.matches('#formGenerarPDFXfechas')) {
		ev.preventDefault()
		enviarConsultaPDFXfechas()
	}
})

document.querySelector("#centro_central").addEventListener("change", ev => {

	if (ev.target.matches('#fecha_inicio')) {
		$('#contenidoPDFXdate').html('<button class="btn btn-success" type="submit"><span class="fas fa-file-signature"></span> Generar</button>')
	}
	if (ev.target.matches('#fecha_fin')) {
		$('#contenidoPDFXdate').html('<button class="btn btn-success" type="submit"><span class="fas fa-file-signature"></span> Generar</button>')
	}

});

var tabla;

//funcion que se ejecuta al inicio
function init() {
	$("#aud").addClass(" active");
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
			'excel'
		],
		"ajax":
		{
			url: 'listar_auditoria',
			type: "get",
			error: function (e) {
				console.log(e.responseText);
			}
		},
		"bDestroy": true,
		"iDisplayLength": 5,//paginacion
		"order": [[0, "desc"]]//ordenar (columna, orden)
	}).DataTable();
}


init();  