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