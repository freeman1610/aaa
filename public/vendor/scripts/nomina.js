$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

function enviarConsultaPDFXfechas() {

	let fecha_inicio = document.getElementById('fecha_inicio').value
	let fecha_fin = document.getElementById('fecha_fin').value
	// Compruebo fechas
	if (fecha_inicio > fecha_fin) {

		toastr.error('No puedes realizar una busqueda desde el ' + fecha_fin + ' al ' + fecha_inicio)

	} else {
		let datos = $('#formGenerarPDFXfechas').serialize();
		$.ajax({
			url: 'generarUrlPDFXfechas',
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

function salarioBase() {
	$.ajax({
		url: 'mostrar_salario',
		method: 'POST',

		success: function (res) {
			Swal.fire({
				title: '<strong>Salario Base</strong>',
				html:
					'<table class="table">' +
					'<tbody>' +
					'<tr>' +
					'<td>Salario Mensual:</td>' +
					'<td> Bs ' + res.salarioMensual + '</td>' +
					'</tr>' +
					'<tr>' +
					'<td>Salario Quincenal:</td>' +
					'<td> Bs ' + res.salarioQuincenal + '</td>' +
					'</tr>' +
					'<tr>' +
					'<td>Salario Diario:</td>' +
					'<td> Bs ' + res.salarioDiario + '</td>' +
					'</tr>' +
					'<tr>' +
					'<td>Salario por Hora:</td>' +
					'<td> Bs ' + res.salarioHora + '</td>' +
					'</tr>' +
					'</tbody>' +
					'</table>',
				preConfirm: () => {
					mostrarFormSalarioBase()
				},
				showCloseButton: true,
				showCancelButton: true,
				confirmButtonText: 'Actualizar Salario',
			})
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});

}

function mostrarFormSalarioBase() {

	$.ajax({
		url: 'mostrar_salario',
		method: 'POST',

		success: function (res) {
			Swal.fire({
				title: '<strong>Actualizar Salario Base</strong>',
				html:
					'<form action="" name="formularioSalarioBase" id="formularioSalarioBase" method="POST">' +
					'<input type="number" required class="form-control" value="' + res.salarioMensual + '" name="salario_base" id="salario_base" step="any">' +
					'<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" type="submit">Guardar</button>' +
					'<button class="btn btn-danger cancel-form-update-salario mt-3" type="button">Cancelar</button></div>' +
					'</form>',
				showCloseButton: true,
				showConfirmButton: false,
				showCancelButton: false,
				focusConfirm: false,
			})
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});


}

function enviarFormCrearUsuario() {

	let datos = $('#formularioCrearNomina').serialize();

	$.ajax({
		url: 'crear_nomina',
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

function updateSalarioBase() {

	let datos = $('#formularioSalarioBase').serialize();

	$.ajax({
		url: 'update_salario_base',
		method: 'POST',
		data: datos,

		success: function () {
			toastr.success('Datos Guardados Correctamente')
			init()
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});
}

function limpiarFormulario() {
	document.getElementById("formularioCrearNomina").reset();
	document.getElementById('id_empleado_a').focus()
}

function clickAgregarNomina() {

	let id_empleado_select = document.getElementById('id_empleado').innerHTML
	let salario_value = document.getElementById('salario').value
	Swal.fire({
		title: '<strong>Pago de Nomina</strong>',
		html:
			'<form action="" name="formularioCrearNomina" id="formularioCrearNomina" method="POST">' +
			'<br><label class="d-flex justify-content-between" for="">Empleado(*): <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><select name="id_empleado_a" id="id_empleado_a" class="form-control select2" required data-Live-search="true" ><option value="">Seleccione</option>' + id_empleado_select + '</select>' +
			'<br><label for="" class="d-flex justify-content-start">Salario Mensual(*):</label><input type="text" class="form-control" value="Bs ' + salario_value + '" readonly>' +
			'<br><label for="" class="d-flex justify-content-start">Tipo de Nómina(*):</label><select name="tipo_nomina_a" id="tipo_nomina_a" class="form-control select2" required data-Live-search="true"><option value="">Seleccione</option>' +
			'<option value="mensual">Mensual</option>' +
			'<option value="quincenal">Quincenal</option>' +
			'</select>' +
			'<br><label for="" class="d-flex justify-content-start">Fecha de pago de Nomina(*)</label><input type="date" required class="form-control" name="inicio_pago_a" id="inicio_pago_a"' +
			'<br><br><label for="" class="d-flex justify-content-start">Dias Laborados(*):</label><input class="form-control" type="text" name="dias_lab_a" id="dias_lab_a" minlength="1" required placeholder="Días Laborados" autocomplete="off" onkeypress="return SoloNumeros(event)" minlength="0" maxlength="2" onkeyup="contarNumsMensual()">' +
			'<br><label for="" class="d-flex justify-content-start">Dia(s) de Descanso Remunerado:(*)</label><input class="form-control" type="text" name="dias_lib_a" id="dias_lib_a" minlength="1" required placeholder="Días de Descanso" autocomplete="off" onkeypress="return SoloNumeros(event)" minlength="0" maxlength="2" onkeyup="contarNumsMensual()">' +
			'<br><label for="" class="d-flex justify-content-start">Horas Extra Diurnas(*):</label><input class="form-control" type="text" name="hora_d_a" id="hora_d_a" minlength="1 required" placeholder="Días de Permiso" autocomplete="off" onkeypress="return SoloNumeros(event)">' +
			'<br><label for="" class="d-flex justify-content-start">Horas Extra Nocturnas(*):</label><input class="form-control" type="text" name="hora_n_a" id="hora_n_a" minlength="1" required placeholder="Días de Permiso" autocomplete="off" onkeypress="return SoloNumeros(event)">' +
			'<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" id="botonSubmitNomina" type="submit">' +
			'Realizar Pago' +
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

	if (ev.target.matches('#formularioCrearNomina')) {
		ev.preventDefault()
		enviarFormCrearUsuario()
	}

	if (ev.target.matches('#formularioSalarioBase')) {
		ev.preventDefault()
		updateSalarioBase()
	}

	if (ev.target.matches('#formGenerarPDFXfechas')) {
		ev.preventDefault()
		enviarConsultaPDFXfechas()
	}

});

document.querySelector("#centro_central").addEventListener("click", ev => {

	if (ev.target.matches('.cancel-form-update-salario')) {
		salarioBase()
	}

});

document.querySelector("#centro_central").addEventListener("change", ev => {

	if (ev.target.matches('#fecha_inicio')) {
		$('#contenidoPDFXdate').html('<button class="btn btn-success" type="submit"><span class="fas fa-file-signature"></span> Generar</button>')
	}
	if (ev.target.matches('#fecha_fin')) {
		$('#contenidoPDFXdate').html('<button class="btn btn-success" type="submit"><span class="fas fa-file-signature"></span> Generar</button>')
	}

});


function contarNumsMensual() {

	if ($('#tipo_nomina_a').val() == 'mensual') {
		let diasLaborados = document.getElementById('dias_lab_a').value
		let diasLibres = document.getElementById('dias_lib_a').value

		if (diasLaborados == '') {
			diasLaborados = 0
		}
		if (diasLibres == '') {
			diasLibres = 0
		}

		suma = parseInt(diasLaborados) + parseInt(diasLibres)

		if (suma <= 30) {
			$("#botonSubmitNomina").prop("disabled", false);
		} else {
			toastr.error('El Total de dias de Labor y Remunerados no debe pasar 30 dias (' + suma + ')');
			$("#botonSubmitNomina").prop("disabled", true);
		}
	}

	if ($('#tipo_nomina_a').val() == 'quincenal') {
		let diasLaborados = document.getElementById('dias_lab_a').value
		let diasLibres = document.getElementById('dias_lib_a').value

		if (diasLaborados == '') {
			diasLaborados = 0
		}
		if (diasLibres == '') {
			diasLibres = 0
		}

		suma = parseInt(diasLaborados) + parseInt(diasLibres)

		if (suma <= 15) {
			$("#botonSubmitNomina").prop("disabled", false);
		} else {
			toastr.error('El Total de dias de Labor y Remunerados no debe pasar 15 dias (' + suma + ')');
			$("#botonSubmitNomina").prop("disabled", true);
		}
	}
}

var tabla;

//funcion que se ejecuta al inicio
function init() {

	$("#nom").addClass("active");
	$("#nom_a").addClass("active");
	listar();

	let select = document.getElementById("id_empleado")

	select.innerHTML = ""

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$.ajax({
		url: 'muestra_empleados_select_nom',
		type: 'POST',

		success: function (res) {

			// console.log(res);
			res.forEach(function (dato) {

				let option = document.createElement('option')

				option.value = dato.id_emp
				option.text = dato.nombre + ' ' + dato.apellido + ' |---|  ' + dato.tipo_documento + ':  ' + dato.cedula + ' |---|  Cargo: ' + dato.cargo
				select.appendChild(option)

			})
		}
	});
	$.ajax({
		url: 'muestra_salario_base',
		type: 'POST',

		success: function (res) {

			let selectInputSalario = document.getElementById("salario")

			selectInputSalario.value = res

		}
	});

}

//funcion limpiar
function limpiar() {
	$("#id_empleado").val("");
	$("#salario").val("");
	$("#dias_lab").val("");
	$("#dias_desc").val("");
	$("#dias_perm").val("");
	$("#salario").select2();
}

//funcion mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (flag) {
		$("#listadoregistros").hide();
		$("#formularioregistros").css("z-index", "0");
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled", false);
		$("#btnagregar").hide();
	} else {
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//cancelar form
function cancelarform() {
	limpiar();
	mostrarform(false);
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
			url: 'listar_nomina',
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



function eliminar(id_nomina) {
	bootbox.confirm("¿Esta seguro de eliminar este dato?", function (result) {
		if (result) {
			$.post("eliminar_nomina", { id_nomina: id_nomina }, function () {
				toastr.success('Datos Eliminados Correctamente');
				tabla.ajax.reload();
			});
		}
	})
}
init();
