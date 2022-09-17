var tabla;

//funcion que se ejecuta al inicio
function init(){
	$("#acc").addClass(" active");
	$("#tpusr").addClass(" active");
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   })
}

//funcion limpiar
function limpiar(){
	$("#idtipousuario").val("");
	$("#nombre_t").val("");
	$("#descripcion").val(""); 
}
 
//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){

		$("#listadoregistros").hide();
		$("#formularioregistros").css("z-index","1");
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
			url:'listar_tipousuario',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e);
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
     let datos = $('#formulario').serialize();

     $.ajax({
     	url: "guardar_tipousuario",
     	type: "POST",
     	data: datos,

     	success: function(res){
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

    //  limpiar();
}

function mostrar(idtipousuario){
	$.ajaxSetup({
		headers: {
			 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	 });
	$.post("mostrar_tipousuario",{idtipousuario : idtipousuario},
		function(data)
		{
			mostrarform(true);			
			$("#nombre_t").val(data.nombre_t);
			$("#descripcion").val(data.descripcion);
			$("#idtipousuario").val(data.idtipousuario);
		})
}


//funcion para desactivar
function desactivar(idtipousuario){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("desactivar_tipousuario", {idtipousuario : idtipousuario}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(idtipousuario){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("activar_tipousuario" , {idtipousuario : idtipousuario}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

init();