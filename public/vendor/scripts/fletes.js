function numeracionDeMil(donde,caracter){
    pat = /[\*,\+,\(,\),\?,\,$,\[,\],\^]/
    valor = donde.value
    largo = valor.length
    crtr = true
    if(isNaN(caracter) || pat.test(caracter) == true){
        
        if (pat.test(caracter)==true){ 
            caracter = "'\'" + caracter
        }
        carcter = new RegExp(caracter,"g")
        valor = valor.replace(carcter,"")
        
        valor =valor.substr(0,largo-1)
        donde.value = valor
        crtr = false
    }
    else{
        var nums = new Array()
        cont = 0
        for(m=0;m<largo;m++){
            if(valor.charAt(m) == "." || valor.charAt(m) == " ")
                {continue;}
            else{
                nums[cont] = valor.charAt(m)
                cont++
            }
        }
    }
    var cad1="",cad2="",tres=0
    if(largo > 3 && crtr == true){
        for (k=nums.length-1;k>=0;k--){
            cad1 = nums[k]
            cad2 = cad1 + cad2
            tres++
            if((tres%3) == 0){
                if(k!=0){
                    cad2 = "." + cad2
                }
            }
        }
        donde.value = cad2
    }
}	

var tabla;

//funcion que se ejecuta al inicio
function init(){
	$("#fletes").addClass(" active");
   mostrarform(false);
   listar();

   $("#formulario").on("submit",function(e){
	e.preventDefault();
	if($("[name='flete_destino']").val()=="" || $("[name='flete_kilometros']").val()=="" 
	|| $("[name='flete_valor_en_carga']").val()=="" || $("[name='flete_valor_sin_carga']").val()==""){
		toastr.warning('Asegúrate de llenar todo los campos');
	}
	else{
		guardaryeditar(e);
	}
   })
 
}

//funcion limpiar
function limpiar(){
	$("#flete_id").val("");
	$("#flete_destino").val("");
	$("#flete_kilometros").val("");
	$("#flete_valor_en_carga").val("");
	$("#flete_valor_sin_carga").val("");
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
			url:'../controlador/fletes.php?op=listar',
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
     	url: "../controlador/fletes.php?op=guardaryeditar",
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

function mostrar(flete_id){
	$.post("../controlador/fletes.php?op=mostrar",{flete_id : flete_id},
		function(data,status)
		{
			data=JSON.parse(data);
			mostrarform(true);

			$("#flete_id").val(data.flete_id);
			$("#flete_destino").val(data.flete_destino);
			$("#flete_kilometros").val(data.flete_kilometros);
			$("#flete_valor_en_carga").val(data.flete_valor_en_carga);
			$("#flete_valor_sin_carga").val(data.flete_valor_sin_carga);
		})
}


function eliminar(flete_id){
	bootbox.confirm("¿Esta seguro de eliminar este dato?" , function(result){
		if (result) {
			$.post("../controlador/fletes.php?op=eliminar" , {flete_id : flete_id}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}
init();