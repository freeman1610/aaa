
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

function enviarFormRegistrarArticulo() {

	let datos = $('#formularioRegistrarArticulo').serialize();

	$.ajax({
		url: 'registrar_articulo',
		method: 'POST',
		data: datos,

		success: function (res) {
			toastr.success('Datos Guardados Correctamente')
			tabla.ajax.reload();
			swal.close()
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});
}

function updateArticulo(id) {

	$.post("mostrar_articulo_update", { idarticulo: id }, function (res) {
		Swal.fire({
			title: 'Actualizar Articulo',
			html:
				'<form action="" name="formularioActulizarArticulo" id="formularioActulizarArticulo" method="POST">' +
				'<input type="hidden" name="id_articulo" id="id_articulo" value="' + res.idalmacen + '">' +
				'<br><label class="d-flex justify-content-between" for="">Codigo: <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><input type="text" autocomplete="off" name="codigo" placeholder="Codigo" maxlength="100" id="codigo" class="form-control" value="' + res.codigo + '" required>' +
				'<br><label class="d-flex justify-content-start" for="">Proveedor:</label><input type="text" autocomplete="off" placeholder="Proveedor" name="proveedor" id="proveedor" class="form-control" value="' + res.proveedor + '" required>' +
				'<br><label class="d-flex justify-content-start" for="">Costo:</label><input type="text" autocomplete="off" placeholder="Costo" name="costo" id="costo" class="form-control" value="' + res.costo + '" onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))" required>' +
				'<br><label class="d-flex justify-content-start" for="">Marca:</label><input type="text" autocomplete="off" placeholder="Marca" name="marca" id="marca" class="form-control" value="' + res.marca + '" required>' +
				'<br><label class="d-flex justify-content-start" for="">Nombre:</label><input type="text" autocomplete="off" placeholder="Nombre" name="nombre" id="nombre" class="form-control" value="' + res.nombre + '" required>' +
				'<br><label class="d-flex justify-content-start" for="">Stock:</label><input type="number" autocomplete="off" placeholder="Stock" name="stock" id="stock" class="form-control" value="' + res.stock + '" required>' +
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

function enviarFormActualizarArticulo() {
	let datos = $('#formularioActulizarArticulo').serialize();
	$.ajax({
		url: 'update_articulo',
		method: 'POST',
		data: datos,

		success: function (res) {
			toastr.success('Datos Actualizados Correctamente')
			tabla.ajax.reload();
			swal.close()
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});
}

function limpiarFormulario() {
	document.getElementById("formularioRegistrarArticulo").reset();
	document.getElementById('codigo').focus()
}

function mostrarformNew() {
	Swal.fire({
		title: 'Registrar Articulo',
		html:
			'<form action="" name="formularioRegistrarArticulo" id="formularioRegistrarArticulo" method="POST">' +
			'<br><label class="d-flex justify-content-between" for="">Codigo: <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><input type="text" autocomplete="off" name="codigo" placeholder="Codigo" maxlength="100" id="codigo" class="form-control" required>' +
			'<br><label class="d-flex justify-content-start" for="">Proveedor:</label><input type="text" autocomplete="off" placeholder="Proveedor" name="proveedor" id="proveedor" class="form-control" required>' +
			'<br><label class="d-flex justify-content-start" for="">Costo:</label><input type="text" autocomplete="off" placeholder="Costo" name="costo" id="costo" class="form-control" onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))" required>' +
			'<br><label class="d-flex justify-content-start" for="">Marca:</label><input type="text" autocomplete="off" placeholder="Marca" name="marca" id="marca" class="form-control" required>' +
			'<br><label class="d-flex justify-content-start" for="">Nombre:</label><input type="text" autocomplete="off" placeholder="Nombre" name="nombre" id="nombre" class="form-control" required>' +
			'<br><label class="d-flex justify-content-start" for="">Stock:</label><input type="number" autocomplete="off" placeholder="Stock" name="stock" id="stock" class="form-control" required>' +
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

function asingnarArti() {
	if ($('#cantidad').val() < 1) {
		return toastr.error('Tienes que suministrar la cantidad ha asignar')
	}
	let datos = $('#formularioAsigArt').serialize();
	$.ajax({
		url: 'asignar_articulo',
		method: 'POST',
		data: datos,

		success: function () {
			toastr.success('Datos Asignados Correctamente')
			tabla.ajax.reload();
			swal.close()
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});
}

function listarEmpleados(texto, id) {
	$.ajax({
		url: 'listar_empleados_asig_art',
		method: 'POST',
		data: 'articulo=' + id,
		success: function (res) {

			let disponibilidad = ''
			let desactivarBoton = false

			if (res.cantidad_art == 0) {
				disponibilidad = '<div class="d-flex justify-content-around"><span class="text-warning">No hay Stock Disponible</div>'
				desactivarBoton = true

			} else {
				disponibilidad = '<div class="d-flex justify-content-around"><span class="">Disponibilidad: ' + res.cantidad_art + ' </span><div><input type="range" id="cantidad" name="cantidad" value="0" min="0" max="' + res.cantidad_art + '" oninput="this.nextElementSibling.value = this.value" required><output class="pl-3">0</output></div></div>'
			}

			Swal.fire({
				title: 'Asignado Articulo: "' + texto + '"',
				html:
					'<form action="" name="formularioAsigArt" id="formularioAsigArt" method="POST">'
					+ disponibilidad +
					'<div id="contenido-art"><br><input type="hidden" name="id_articulo" id="id_articulo" value="' + id + '">' +
					'<label class="d-flex justify-content-start" for="">Seleccione el Empleado:</label><select class="form-control" id="id_emp" name="id_emp" required>' + res.empleados + '</select>' +
					'<div class="d-flex justify-content-around"><button id="boton-asig" class="btn btn-success mt-3" type="submit">' +
					'Guardar' +
					'</button>' +
					'</div></div>' +
					'</form>',
				showCloseButton: true,
				showConfirmButton: false,
				showCancelButton: false,
				focusConfirm: false
			})
			if (desactivarBoton) {
				$('#contenido-art').html("")
			}
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});
}

function verAsignacion(id, texto) {
	$.ajax({
		url: 'ver_asignacion',
		method: 'POST',
		data: 'id=' + id,

		success: function (res) {
			Swal.fire({
				title: 'Articulo: "' + texto + '"',
				html:
					'<table class="table">' +
					'<thead>' +
					'<tr>' +
					'<th>Empleado Despachado</th>' +
					'<th>Cantidad Despachada</th>' +
					'<th>Fecha del Despacho</th>' +
					'</tr>' +
					'</thead>' +
					'<tbody>' + res.tabla + '</tbody>' +
					'</table>',
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

function desasignarArticulo(id) {

	$.ajax({
		url: 'desasignar_articulo',
		method: 'POST',
		data: 'id_articulo=' + id,

		success: function () {
			toastr.success('Datos Desasignados Correctamente')
			tabla.ajax.reload();
			swal.close()
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
		}

	});

}

document.querySelector("#centro_central").addEventListener("submit", ev => {
	if (ev.target.matches('#formularioRegistrarArticulo')) {
		ev.preventDefault()
		enviarFormRegistrarArticulo()
	}
	if (ev.target.matches('#formularioActulizarArticulo')) {
		ev.preventDefault()
		enviarFormActualizarArticulo()
	}
	if (ev.target.matches('#formularioAsigArt')) {
		ev.preventDefault()
		asingnarArti()
	}
})

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
	$("#alm").addClass("active");
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
			url: 'listar_almacen',
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

function eliminar(idarticulo) {
	bootbox.confirm("¿Esta seguro de eliminar este dato?", function (result) {
		if (result) {
			$.post("eliminar_articulo", { idarticulo: idarticulo }, function (e) {
				toastr.success('Datos Eliminados Correctamente')
				tabla.ajax.reload();
			});
		}
	})
}

init();