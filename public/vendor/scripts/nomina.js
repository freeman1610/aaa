function contarNumsMensual() {

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
		toastr.error('El Total de dias de Labor, Permisos, Descanso, no debe pasar 30 dias (' + suma + ')');
		$("#botonSubmitNomina").prop("disabled", true);
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
		url: 'muestra_empleados_select',
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
			$.post("../controlador/empleados.php?op=eliminar", { id_nomina: id_nomina }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
init();
