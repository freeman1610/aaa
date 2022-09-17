var tabla;

//funcion que se ejecuta al inicio
function init(){
	$("#emp").addClass(" active");
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
	e.preventDefault();
	if($("[name='nombre']").val()=="" || $("[name='apellido']").val()=="" 
	|| $("[name='cedula']").val()=="" || $("[name='direccion']").val()=="" 
	|| $("[name='telefono']").val()==""|| $("[name='fecha_nac']").val()=="" 
	|| $("[name='cargo']").val()==""){
		toastr.warning('Asegúrate de llenar todo los campos');
	}
	else{
		guardar(e);
	}
   })
   $('[data-mask]').inputmask();
   //Datemask dd/mm/yyyy
   $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd'});
   //cargamos los items al select Departamento
   
   let select = document.getElementById("iddepartamento")
   
   $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
 
	$.ajax({
		url: 'mostrar_departamentos',
		type: 'POST',

		success: function(res){
			
			res.forEach(function(dato){

				let option = document.createElement('option');
		
				option.value = dato.iddepartamento;
				option.text = dato.nombre;
				select.appendChild(option);
				
			});

			$("#iddepartamento").select2();
		}
	});
}

//funcion limpiar
function limpiar(){
	$("#iddepartamento").val("");
	$("#nombre").val("");
	$("#apellido").val("");
	$("#cedula").val("");
	$("#fecha_nac").val("");
	$("#iddepartamento").select2();
	$("#cargo").val("");
	$("#telefono").val("");
	$("#direccion").val("");
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
			url:'listar_empleados',
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
//funcion para guardar
function guardar(e){

	

     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     
	let datos = $('#formulario').serialize();

	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

     $.ajax({
     	url: "guardar_update_empleado",
     	type: "POST",
     	data: datos,

     	success: function(){
			toastr.success('Empleado Actualizado');
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}

function mostrar(id_emp){
	$.post("mostrar_empleado",{id_emp : id_emp},
		function(data)
		{

			mostrarform(true);

			$("#nombre").val(data.nombre);
			$("#apellido").val(data.apellido);
			$("#cedula").val(data.cedula);
			$("#fecha_ingreso").val(data.fecha_ingreso);
			$("#fecha_nac").val(data.fecha_nac);
			$("#iddepartamento").val(data.iddepartamento);
			$("#iddepartamento").select2();
			$("#cargo").val(data.cargo);
			$("#telefono").val(data.telefono);
			$("#direccion").val(data.direccion);
			$("#id_emp").val(data.id_emp);
		})
}


function eliminar(id_emp){
	bootbox.confirm("¿Esta seguro de eliminar este dato?" , function(result){
		if (result) {
			$.post("eliminar_empleado" , {id_emp : id_emp}, function(){
				toastr.success('Empleado Eliminado');
				tabla.ajax.reload();
			});
		}
	})
}
init();