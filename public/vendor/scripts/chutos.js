var tabla;

//funcion que se ejecuta al inicio
function init(){
	$("#chutos").addClass(" active");
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
	e.preventDefault();
	if($("[name='chuto_placa']").val()=="" || $("[name='chuto_modelo']").val()=="" 
	|| $("[name='chuto_marca']").val()=="" || $("[name='chuto_estado']").val()==""){
		toastr.warning('Asegúrate de llenar todo los campos');
	}
	else{
		guardaryeditar(e);
	}
   })
 
}

//funcion limpiar
function limpiar(){
	$("#chuto_id").val("");
	$("#chuto_placa").val("");
	$("#chuto_modelo").val("");
	$("#chuto_marca").val("");
	$("#chuto_estado").val("");
}
 
//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").css("z-index","0");
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//cancelar form
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//funcion listar
function listar(){
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
			url:'../controlador/chutos.php?op=listar',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":10,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../controlador/chutos.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
			if(datos === 'Datos actualizados correctamente'){
				toastr.success('Datos actualizados correctamente');
			}
			if(datos === 'No se pudo actualizar los datos'){
				toastr.error('No se pudo actualizar los datos');
			}
			if(datos === 'Datos registrados correctamente'){
				toastr.success('Datos registrados correctamente');
			}
			if(datos === 'No se pudo registrar los datos'){
				toastr.error('No se pudo registrar los datos');
			}
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}

function mostrar(chuto_id){
	$.post("../controlador/chutos.php?op=mostrar",{chuto_id : chuto_id},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#chuto_id").val(data.chuto_id);
			$("#chuto_placa").val(data.chuto_placa);
			$("#chuto_modelo").val(data.chuto_modelo);
			$("#chuto_marca").val(data.chuto_marca);
			$("#chuto_estado").val(data.chuto_estado);
		})
}


function eliminar(chuto_id){
	bootbox.confirm("¿Esta seguro de eliminar este dato?" , function(result){
		if (result) {
			$.post("../controlador/chutos.php?op=eliminar" , {chuto_id : chuto_id}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
init();