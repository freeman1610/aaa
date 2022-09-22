$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
function mostrarform() {
	$.post("listar_estados", function (res) {
		Swal.fire({
			title: '<strong>Crear Flete</strong>',
			html:
				'<form action="" name="formularioCrearFlete" id="formularioCrearFlete" method="POST">' +
				'<br><label class="d-flex justify-content-start" for="">Codigo(*):</label><input type="text" name="flete_codigo" placeholder="Codigo" id="flete_codigo" class="form-control" required>' +
				'<br><label class="d-flex justify-content-start" for="">Destino: ESTADO(*):</label>' +
				'<select class="form-control" required name="flete_destino_estado" id="flete_destino_estado">' +
				res.estados +
				'</select>' +
				'<br><label class="d-flex justify-content-start" for="">Destino: MUNICIPIO(*):</label>' +
				'<select class="form-control" required name="flete_destino_municipio" id="flete_destino_municipio" disabled></select>' +
				'<br><label class="d-flex justify-content-start" for="">Destino: PARROQUIA(*):</label>' +
				'<select class="form-control" required name="flete_destino_parroquia" id="flete_destino_parroquia" disabled></select>' +
				'<br><label class="d-flex justify-content-start" for="">Kilometros:</label><input type="text" name="flete_kilometros" placeholder="Kilometros del Flete" onkeypress="return SoloNumeros(event)" maxlength="10" id="flete_kilometros" class="form-control" required onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))">' +
				'<br><label class="d-flex justify-content-start" for="">Valor en Carga:</label><input type="text" class="form-control" name="flete_valor_en_carga" id="flete_valor_en_carga" placeholder="Valor Carga" maxlength="10" autocomplete="off" onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))">' +
				'<br><label class="d-flex justify-content-start" for="">Valor Sin Carga:</label><input type="text" class="form-control" name="flete_valor_sin_carga" id="flete_valor_sin_carga" placeholder="Valor Sin Carga" maxlength="10" autocomplete="off" onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))">' +
				'<button class="btn btn-success mt-3" type="submit">' +
				'Guardar Usuario' +
				'</button>' +
				'</form>',
			showCloseButton: true,
			showConfirmButton: false,
			showCancelButton: false,
			focusConfirm: false,
		})
	});

}
document.querySelector("#centro_central").addEventListener("change", ev => {

	if (ev.target.matches('#flete_destino_estado')) {

		let id = document.getElementById('flete_destino_estado').value

		$.post("listar_municipios", { id_estado: id }, function (res) {

			document.getElementById('flete_destino_municipio').innerHTML = res.municipios
			$("#flete_destino_municipio").prop("disabled", false);
			document.getElementById("flete_destino_parroquia").innerHTML = ""
			$("#flete_destino_parroquia").prop("disabled", true);

		});
	}
	if (ev.target.matches('#flete_destino_municipio')) {

		let id = document.getElementById('flete_destino_municipio').value

		$.post("listar_parroquias", { id_municipio: id }, function (res) {

			document.getElementById('flete_destino_parroquia').innerHTML = res.parroquias
			$("#flete_destino_parroquia").prop("disabled", false);

		});
	}

});

function registrarFlete() {

	let datos = $('#formularioCrearFlete').serialize();

	$.ajax({
		url: 'registrar_flete',
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

function mostrarFlete(flete_id) {
	$.post("mostrar_flete", { flete_id: flete_id }, function (res) {
		Swal.fire({
			title: '<strong>Actualizar Flete</strong>',
			html:
				'<form action="" name="formularioUpdateFlete" id="formularioUpdateFlete" method="POST">' +
				'<input type="hidden" name="flete_id" id=flete_id"" value="' + res['flete'].flete_id + '">' +
				'<br><label class="d-flex justify-content-start" for="">Codigo(*):</label><input type="text" name="flete_codigo" placeholder="Codigo" id="flete_codigo" class="form-control" value="' + res['flete'].flete_codigo + '" required>' +
				'<br><label class="d-flex justify-content-start" for="">Destino: ESTADO(*):</label>' +
				'<select class="form-control" required name="flete_destino_estado" id="flete_destino_estado">' +
				res['estados'] +
				'</select>' +
				'<br><label class="d-flex justify-content-start" for="">Destino: MUNICIPIO(*):</label>' +
				'<select class="form-control" required name="flete_destino_municipio" id="flete_destino_municipio">' + res['municipios'] + '</select>' +
				'<br><label class="d-flex justify-content-start" for="">Destino: PARROQUIA(*):</label>' +
				'<select class="form-control" required name="flete_destino_parroquia" id="flete_destino_parroquia">' + res['parroquias'] + '</select>' +
				'<br><label class="d-flex justify-content-start" for="">Kilometros:</label><input type="text" name="flete_kilometros" placeholder="Kilometros del Flete" onkeypress="return SoloNumeros(event)" maxlength="10" id="flete_kilometros" class="form-control" value="' + res['flete'].flete_kilometros + '" required onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))">' +
				'<br><label class="d-flex justify-content-start" for="">Valor en Carga:</label><input type="text" class="form-control" name="flete_valor_en_carga" id="flete_valor_en_carga" placeholder="Valor Carga" maxlength="10" value="' + res['flete'].flete_valor_en_carga + '" autocomplete="off" required onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))">' +
				'<br><label class="d-flex justify-content-start" for="">Valor Sin Carga:</label><input type="text" class="form-control" name="flete_valor_sin_carga" id="flete_valor_sin_carga" placeholder="Valor Sin Carga" value="' + res['flete'].flete_valor_sin_carga + '" required maxlength="10" autocomplete="off" onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))">' +
				'<button class="btn btn-success mt-3" type="submit">' +
				'Guardar Usuario' +
				'</button>' +
				'</form>',
			showCloseButton: true,
			showConfirmButton: false,
			showCancelButton: false,
			focusConfirm: false,
		})
	});
}
function updateFlete() {

	let datos = $('#formularioUpdateFlete').serialize();

	$.ajax({
		url: 'update_flete',
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
document.querySelector("#centro_central").addEventListener("submit", ev => {

	if (ev.target.matches('#formularioCrearFlete')) {
		ev.preventDefault()
		registrarFlete()
	}
	if (ev.target.matches('#formularioUpdateFlete')) {
		ev.preventDefault()
		updateFlete()
	}

});

function numeracionDeMil(donde, caracter) {
	pat = /[\*,\+,\(,\),\?,\,$,\[,\],\^]/
	valor = donde.value
	largo = valor.length
	crtr = true
	if (isNaN(caracter) || pat.test(caracter) == true) {

		if (pat.test(caracter) == true) {
			caracter = "'\'" + caracter
		}
		carcter = new RegExp(caracter, "g")
		valor = valor.replace(carcter, "")

		valor = valor.substr(0, largo - 1)
		donde.value = valor
		crtr = false
	}
	else {
		var nums = new Array()
		cont = 0
		for (m = 0; m < largo; m++) {
			if (valor.charAt(m) == "." || valor.charAt(m) == " ") { continue; }
			else {
				nums[cont] = valor.charAt(m)
				cont++
			}
		}
	}
	var cad1 = "", cad2 = "", tres = 0
	if (largo > 3 && crtr == true) {
		for (k = nums.length - 1; k >= 0; k--) {
			cad1 = nums[k]
			cad2 = cad1 + cad2
			tres++
			if ((tres % 3) == 0) {
				if (k != 0) {
					cad2 = "." + cad2
				}
			}
		}
		donde.value = cad2
	}
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
			url: 'listar_fletes',
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

function mostrar(flete_id) {
	$.post("../controlador/fletes.php?op=mostrar", { flete_id: flete_id },
		function (data, status) {
			data = JSON.parse(data);
			mostrarform(true);

			$("#flete_id").val(data.flete_id);
			$("#flete_destino").val(data.flete_destino);
			$("#flete_kilometros").val(data.flete_kilometros);
			$("#flete_valor_en_carga").val(data.flete_valor_en_carga);
			$("#flete_valor_sin_carga").val(data.flete_valor_sin_carga);
		})
}


function eliminar(flete_id) {
	bootbox.confirm("¿Esta seguro de eliminar este dato?", function (result) {
		if (result) {
			$.post("../controlador/fletes.php?op=eliminar", { flete_id: flete_id }, function (e) {
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
init();