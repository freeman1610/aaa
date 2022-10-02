
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});


function backUpDataBase() {
	$.ajax({
		url: 'backupsql',
		type: 'POST',

		success: function (res) {
			let ht = '<div class="d-flex justify-content-center">' + res.boton + '</div>'
			Swal.fire({
				icon: 'success',
				title: 'Base de Datos Respaldada Existosamente!',
				html: ht,
				showConfirmButton: false,
				showCloseButton: true
			})
		},
		error: function (err) {
			toastr.error(err.responseJSON.message)
		}
	});
}

// function restoreSQL() {

// 	// $imagen = $('#imagen');
// 	// let formData = new FormData();
// 	// let datos = $('#formularioCrearUsuario').serialize();
// 	// formData.append('imagen', $imagen[0].files[0]);


// 	// $.ajax({
// 	// 	url: 'crear_usuario' + '?' + datos,
// 	// 	method: 'POST',
// 	// 	data: formData,
// 	// 	processData: false,
// 	// 	contentType: false,



// 	newSql = $('#newSql');
// 	let formData = new FormData();
// 	formData.append('newSql', newSql[0].files[0]);
// 	// let datos = $('#formRestoreDB').serialize();

// 	$.ajax({
// 		url: 'restore_db',
// 		type: 'POST',
// 		data: formData,
// 		processData: false,
// 		contentType: false,
// 		success: function () {
// 			Swal.fire({
// 				icon: 'success',
// 				title: 'Base de Datos Actualizada Existosamente!',
// 				showConfirmButton: false,
// 				showCloseButton: true
// 			})
// 		},
// 		error: function (err) {
// 			toastr.error(err.responseJSON.message)
// 		}
// 	})
// }

// function restoreDataBase() {

// 	let ht = '<form method="POST" id="formRestoreDB" name="formRestoreDB" enctype="multipart/form-data">' +
// 		'<input type="file" id="newSql" name="newSql" required accept=".sql">' +
// 		'<br><button type="submit" class="btn btn-primary mt-3">Enviar</button>' +
// 		'</form>'

// 	Swal.fire({
// 		title: 'Inserte el Archivo SQL para restaurar los Datos',
// 		html: ht,
// 		showConfirmButton: false,
// 		showCancelButton: false,
// 		showCloseButton: true
// 	})
// }

// document.querySelector("#centro_central").addEventListener("submit", ev => {
// 	if (ev.target.matches('#formRestoreDB')) {
// 		ev.preventDefault()
// 		restoreSQL()
// 	}

// });

function limpiarBackUp() {
	$.post("limpieza_backup_db");
}

function mostrarTipoUsuario() {

	let select = document.getElementById("idtipousuario")

	$.ajax({
		url: 'mostrar_tipo_usuario',
		type: 'POST',

		success: function (res) {

			res.forEach(function (dato) {

				let option = document.createElement('option');

				option.value = dato.idtipousuario;
				option.text = dato.nombre_t;
				select.appendChild(option);



			});

			$("#idtipousuario").select2();
		}
	});



}

function mostrarDepartamentos() {

	let select = document.getElementById("iddepartamento")

	$.ajax({
		url: 'mostrar_departamentos',
		type: 'POST',

		success: function (res) {

			res.forEach(function (dato) {

				let option = document.createElement('option');

				option.value = dato.iddepartamento;
				option.text = dato.nombre;
				select.appendChild(option);



			});

			$("#iddepartamento").select2();
		}
	});

}

function mostrarPermisos(id_user) {
	let ulll = document.getElementById("permisos")
	ulll.innerHTML = ""
	let indice = 0
	$.ajax({
		url: 'mostrar_permisos?id_user=' + id_user,
		type: 'POST',

		success: function (res) {

			res.forEach(function (dato) {

				let li = document.createElement('li');

				li.id = 'li-' + indice

				ulll.appendChild(li);

				let inputt = document.createElement('input');

				inputt.type = "checkbox"
				if (dato.seleccion == "check") {
					inputt.checked = true
				}
				inputt.value = dato.idpermiso;
				inputt.name = "permiso[]"


				let textto = 'li-' + indice

				let selecLI = document.getElementById(textto)

				selecLI.appendChild(inputt);

				let texto = document.createElement('span')
				texto.innerText = ' ' + dato.nombre
				selecLI.appendChild(texto);



				indice++

			});

		}
	});
}

var tabla;

//funcion que se ejecuta al inicio
function init() {
	$("#acc").addClass(" active");
	$("#usr").addClass(" active");
	mostrarform(false);
	listar();

	if (document.getElementById('formulario') != null) {
		$("#formulario").on("submit", function (e) {
			e.preventDefault();
			if ($("[name='nombre']").val() == "" || $("[name='apellido']").val() == ""
				|| $("[name='num_documento']").val() == "" || $("[name='direccion']").val() == ""
				|| $("[name='telefono']").val() == "" || $("[name='email']").val() == ""
				|| $("[name='cargo']").val() == "" || $("[name='login']").val() == "") {
				toastr.warning('Asegúrate de llenar todo los campos');
			} else {
				guardar(e);
			}

		})
	} else {

	}



	$('[data-mask]').inputmask();
	//Datemask dd/mm/yyyy
	$('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd' });

	//cargamos los items al select Tipousuario

	mostrarTipoUsuario()

	//cargamos los items al select Departamento

	mostrarDepartamentos()

	$("#imagenmuestra").hide();
	//mostramos los permisos

	mostrarPermisos()

}

//funcion limpiar
function limpiar() {
	$("#nombre").val("");
	$("#apellido").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#idtipousuario").select2();
	$("#iddepartamento").select2();
	$("#telefono").val("");
	$("#email").val("");
	$("#cargo").val("");
	$("#login").val("");
	$("#clave").val("");
	$("#clavec").val("");
	$("#imagenmuestra").attr("src", "");
	$("#imagenactual").val("");
	$("#imagen").val("");
	$("#idusuario").val("");
}



function formularioCrearUsuario(eve) {

	eve.preventDefault()

	$("#btnGuardar").prop("disabled", true);

	$imagen = $('#imagen');
	let formData = new FormData();
	let datos = $('#formularioCrearUsuario').serialize();
	formData.append('imagen', $imagen[0].files[0]);


	$.ajax({
		url: 'crear_usuario' + '?' + datos,
		method: 'POST',
		data: formData,
		processData: false,
		contentType: false,

		success: function (datos) {
			toastr.success('Datos Registrados Correctamente')
			// mostrarform(false);
			// tabla.ajax.reload();
		},
		error: function (err) {
			toastr.error(err.responseJSON.message)
			$("#btnGuardar").prop("disabled", false);
		}
	});
	$("#claves").show();
	limpiar();


}

//funcion mostrar formulario
function mostrarform(flag) {
	limpiar();
	if (document.getElementById('formularioCrearUsuario') != null) {
		$('#formularioCrearUsuario').attr("id", "formulario")
		$('#formulario').attr("name", "formulario")
	}
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
	$("#claves").show();
	limpiar();
	mostrarform(false);
}
function cancelarform2() {
	limpiar();
	window.location.href = "escritorio";
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
			url: 'mostrar_listar_usuarios',
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
//funcion para guardar
function guardar(e) {
	e.preventDefault();//no se activara la accion predeterminada 
	$("#btnGuardar").prop("disabled", true);

	$imagen = $('#imagen');
	let formData = new FormData();
	let datos = $('#formulario').serialize();
	formData.append('imagen', $imagen[0].files[0]);


	$.ajax({
		url: 'guardar_usuario_editado' + '?' + datos,
		method: 'POST',
		data: formData,
		processData: false,
		contentType: false,

		success: function (datos) {
			toastr.success('Datos actualizados correctamente')
			mostrarform(false);
			tabla.ajax.reload();
			$("#claves").show();
			limpiar();
		},

		error: function (err) {
			toastr.error(err.responseJSON.message)
			$("#btnGuardar").prop("disabled", false);
		}

	});

}

function mostrar(idusuario) {

	$.ajax({
		url: 'lista_usuarios_editar?id_user=' + idusuario,
		type: 'POST',

		success: function (datos) {
			mostrarform(true);
			if ($("#idusuario").val(datos.idusuario).length == 0) {
				$("#claves").show();
			} else {
				$("#claves").hide();
			}
			$("#nombre").val(datos.nombre);
			$("#apellido").val(datos.apellido);
			$("#tipo_documento").val(datos.tipo_documento);
			$("#num_documento").val(datos.num_documento);
			$("#direccion").val(datos.direccion);
			$("#telefono").val(datos.telefono);
			$("#email").val(datos.email);
			$("#cargo").val(datos.cargo);
			$("#login").val(datos.login);
			$("#idtipousuario").val(datos.idtipousuario);
			$("#idtipousuario").select2();
			$("#iddepartamento").val(datos.iddepartamento);
			$("#iddepartamento").select2();
			$("#imagenmuestra").show();
			$("#imagenmuestra").attr("src", "vendor/img-users/" + datos.imagen);
			$("#imagenactual").val(datos.imagen);
			$("#idusuario").val(datos.idusuario);
		}
	});

	mostrarPermisos(idusuario)

}

function editar_clave() {

	let datos = $('#formularioCambiarContra').serialize();

	$.ajax({
		url: "editar_clave_usuario",
		type: "POST",
		data: datos,


		success: function () {
			toastr.success('Clave Actualizadad');
			tabla.ajax.reload();
		},
		error: function (err) {
			toastr.error(err.responseJSON.message);
		}
	});
}

function mostrarFormCambiarContra(idusuario) {

	Swal.fire({
		title: '<strong>Cambiar Contraseña</strong>',
		html:
			'<form action="" name="formularioCambiarContra" id="formularioCambiarContra" method="POST">' +
			'<input type="hidden" name="idusuario" id="idusuario" value="' + idusuario + '">' +
			'<input class="form-control" minlength="6" type="password" name="clave" id="clave" placeholder="Contraseña">' +
			'<button class="btn btn-default mt-4" type="submit">' +
			'Guardar Contraseña' +
			'</button>' +
			'</form>',
		showCloseButton: true,
		showConfirmButton: false,
		showCancelButton: false,
		focusConfirm: false,
	})

	$("#idusuarioc").val(idusuario);

}

document.querySelector("#centro_central").addEventListener("submit", ev => {

	if (ev.target.matches('#formularioCambiarContra')) {
		ev.preventDefault()
		editar_clave()
	}

});


//funcion para desactivar
function desactivar(idusuario) {
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function (result) {
		if (result) {
			$.post("desactivar_usuario", { idusuario: idusuario }, function (e) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: e,
					timerProgressBar: true,
					showConfirmButton: false,
					timer: 3000
				})
				tabla.ajax.reload();
			});
		}
	})
}

function eliminar(idusuario) {
	bootbox.confirm("¿Esta seguro de eliminar este Usuario?", function (result) {
		if (result) {
			$.post("eliminar_usuario", { idusuario: idusuario }, function (e) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: e,
					timerProgressBar: true,
					showConfirmButton: false,
					timer: 3000
				})
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idusuario) {
	bootbox.confirm("¿Esta seguro de activar este dato?", function (result) {
		if (result) {
			$.post("activar_usuario", { idusuario: idusuario }, function (e) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: e,
					timerProgressBar: true,
					showConfirmButton: false,
					timer: 3000
				})
				tabla.ajax.reload();
			});
		}
	})
}


init();