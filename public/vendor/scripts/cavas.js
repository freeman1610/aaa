var tabla;

//funcion que se ejecuta al inicio
function init(){
	$("#cavas").addClass(" active");
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
	e.preventDefault();
	if($("[name='cava_placa']").val()=="" || $("[name='cava_modelo']").val()=="" 
	|| $("[name='cava_marca']").val()=="" || $("[name='cava_estado']").val()==""){
		toastr.warning('Asegúrate de llenar todo los campos');
	}
	else{
		guardaryeditar(e);
	}
   })
 
}

//funcion limpiar
function limpiar(){
	$("#cava_id").val("");
	$("#cava_placa").val("");
	$("#cava_modelo").val("");
	$("#cava_marca").val("");
	$("#cava_estado").val("");
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
			url:'../controlador/cavas.php?op=listar',
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
     	url: "../controlador/cavas.php?op=guardaryeditar",
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

function mostrar(cava_id){
	$.post("../controlador/cavas.php?op=mostrar",{cava_id : cava_id},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#cava_id").val(data.cava_id);
			$("#cava_placa").val(data.cava_placa);
			$("#cava_modelo").val(data.cava_modelo);
			$("#cava_marca").val(data.cava_marca);
			$("#cava_estado").val(data.cava_estado);
		})
}


function eliminar(cava_id){
	bootbox.confirm("¿Esta seguro de eliminar este dato?" , function(result){
		if (result) {
			$.post("../controlador/cavas.php?op=eliminar" , {cava_id : cava_id}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
init();