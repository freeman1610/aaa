var tabla;

//funcion que se ejecuta al inicio
function init(){
$("#formulario").on("submit",function(e){
	//no se activara la accion predeterminada 
	e.preventDefault();
	if($("[name='num_documento']").val()==""){
		bootbox.alert("Asegúrate de llenar todo los campos");
	}else{
		registrar_asistencia(e);
	}
   })

}

//funcion limpiar
function limpiar(){
	$("#num_documento").val("");
	setTimeout('document.location.reload()',2000);

}

function registrar_asistencia(e){
     e.preventDefault();//no se activara la accion predeterminada 
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../controlador/reg_asistencia.php?op=registrar_asistencia",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     			$("#movimientos").html(datos);
     		//bootbox.alert(datos);
     	}
     });
     limpiar();
}





init();