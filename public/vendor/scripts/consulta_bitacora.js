var tabla;

//funcion que se ejecuta al inicio
function init(){
	$("#aud").addClass(" active");
	$("#audM").addClass(" active");
   listar();
    //cargamos los items al select cliente
   $.post("../controlador/consulta_bitacora.php?op=selectCliente", function(r){
   	$("#idcliente").html(r);
   	$('#idcliente').select2();
   });

}

//funcion listar
function listar(){
var  fecha_inicio = $("#fecha_inicio").val();
 var fecha_fin = $("#fecha_fin").val();
 var idcliente = $("#idcliente").val();

	tabla=$('#tbllistado').dataTable({
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
			url:'../controlador/consulta_bitacora.php?op=consulta_bitacora',
			data:{fecha_inicio:fecha_inicio, fecha_fin:fecha_fin, idcliente: idcliente},
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}


init();  