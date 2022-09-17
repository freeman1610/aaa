var tabla;

//funcion que se ejecuta al inicio
function init(){
	$("#dep").addClass(" active");
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
	e.preventDefault();
	if($("[name='nombre']").val()=="" || $("[name='descripcion']").val()==""){
		toastr.warning('Asegúrate de llenar todo los campos');
	}else{
		guardaryeditar(e);
	}
   	
   })
}

//funcion limpiar
function limpiar(){
	$("#iddepartamento").val("");
	$("#nombre").val("");
	$("#descripcion").val(""); 
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
			url:'../controlador/departamento.php?op=listar',
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
     	url: "../controlador/departamento.php?op=guardaryeditar",
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

function mostrar(iddepartamento){
	$.post("../controlador/departamento.php?op=mostrar",{iddepartamento : iddepartamento},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);
			$("#nombre").val(data.nombre);
			$("#descripcion").val(data.descripcion);
			$("#iddepartamento").val(data.iddepartamento);
		})
}


//funcion para desactivar activar y eliminar
function desactivar(iddepartamento){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../controlador/departamento.php?op=desactivar", {iddepartamento : iddepartamento}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function eliminar(iddepartamento){
	bootbox.confirm("¿Esta seguro de eliminar este dato?" , function(result){
		if (result) {
			$.post("../controlador/departamento.php?op=eliminar" , {iddepartamento : iddepartamento}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(iddepartamento){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../controlador/departamento.php?op=activar" , {iddepartamento : iddepartamento}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();