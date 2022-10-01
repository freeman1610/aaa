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