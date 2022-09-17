
var tabla;



//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   mostrarform_clave(false);

   $("#formulario").on("submit",function(e){

	guardaryeditar(e);
   })
   $("#formularioc").on("submit",function(c){
   	editar_clave(c);
   })

   $('[data-mask]').inputmask();
   //Datemask dd/mm/yyyy
   $('#datemask').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd'});

   $("#imagenmuestra").hide();
//mostramos los permisos
// $.post("../controlador/perfil.php?op=permisosP&id=", function(r){
// 	$("#permisos").html(r);
// });
}

//funcion limpiar
function limpiar(){
	$("#nombre").val("");
	$("#apellido").val("");
   	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#login").val("");
	$("#clave").val("");
	$("#imagenmuestra").attr("src","");
	// $("#imagenactual").val("");
	$("#idusuario").val("");
}

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
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
	$("#claves").show();
	limpiar();
	mostrarform(false);
}
function cancelarform2(){
	limpiar();
	window.location.href="escritorio";
}

// funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
    
	 let datos = $('#formulario').serialize();

	 $.ajaxSetup({
		headers: {
			 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	 });

     $.ajax({
     	url: "guardar_perfil_editado",
     	type: "POST",
     	data: datos,

     	success: function(res){

			toastr.success('Datos actualizados correctamente');
			mostrarform(false);
			$("#claves").show();
			limpiar()
			perfil()
     	},

		error: function(err){
			console.log(err);
		}
     });
	 
}



function perfil(){

	$.ajax({

		method: 'get',
        url: 'perfil_personal',

        success: function(datoss){
            let mostrarData = datoss[0]

			mostrarform(true);
			if ($("#idusuario").val(mostrarData.idusuario).length==0) {
				$("#claves").show();
			}
			$("#nombre").val(mostrarData.nombre);
			$("#apellido").val(mostrarData.apellido);
			$("#tipo_documento").val(mostrarData.tipo_documento);
			$("#tipo_documento").select2();
			$("#num_documento").val(mostrarData.num_documento);
			$("#direccion").val(mostrarData.direccion);
			$("#telefono").val(mostrarData.telefono);
			$("#email").val(mostrarData.email);
			$("#cargo").val(mostrarData.cargo);
			$("#login").val(mostrarData.login);
			$("#imagenmuestra").show();
			$("#imagenmuestra").attr("src","../files/usuarios/"+mostrarData.imagen);
			$("#imagenactual").val(mostrarData.imagen);
			$("#idusuario").val(mostrarData.idusuario);
        }
		
			
		

	});

}

function mostrarform_clave(flag){
	limpiar();
	if(flag)
	{
		$("#listadoregistros").hide();
		$("#formulario_clave").show();
		$("#btnGuardar_clave").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formulario_clave").hide();
		$("#btnagregar").show();
	}
}

function editar_clave(c){
     c.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar_clave").prop("disabled",true);
    //  var formData=new FormData($("#formularioc")[0]);

	let datos = $('#formularioc').serialize();


     $.ajax({
     	url: "editar_contra_perfil",
     	type: "POST",
     	data: datos,


     	success: function(){
			toastr.success('Contresaña Actualizadad');
			 $("#btnGuardar_clave").prop("disabled",false);
     	}
     });

	 $("#getCodeModal").modal('hide');
}

function mostrar_clave(){

	$("#getCodeModal").modal('show');
}
window.onload = perfil()
init();