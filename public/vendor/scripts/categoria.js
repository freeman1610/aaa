var tabla;

//funcion que se ejecuta al inicio
function init(){
	$("#alm").addClass(" active");
	$("#cat").addClass(" active");
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
	//no se activara la accion predeterminada 
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
	$("#idcategoria").val("");
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
			url:'../controlador/categoria.php?op=listar',
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
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../controlador/categoria.php?op=guardaryeditar",
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

function mostrar(idcategoria){
	$.post("../controlador/categoria.php?op=mostrar",{idcategoria : idcategoria},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);
			$("#nombre").val(data.nombre);
			$("#descripcion").val(data.descripcion);
			$("#idcategoria").val(data.idcategoria);
		})
}
//funcion para eliminar

function eliminar(idcategoria){
	bootbox.confirm("¿Esta seguro de eliminar este dato?" , function(result){
		if (result) {
			$.post("../controlador/categoria.php?op=eliminar" , {idcategoria : idcategoria}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

//funcion para desactivar
function desactivar(idcategoria){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../controlador/categoria.php?op=desactivar", {idcategoria : idcategoria}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idcategoria){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../controlador/categoria.php?op=activar" , {idcategoria : idcategoria}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();