function soloMayusculas(campo_id) 
{
	var cadena = document.getElementById(campo_id).value;
	var cadena2 = cadena.toUpperCase();
	document.getElementById(campo_id).value = cadena2;
}

function SoloNumeros(evt) // solo permite insertar NUMEROS,EL PUNTO, ENTER, ESPACIO
{
	var nav4 = window.Event ? true : false;
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57, '.' = 46
	var key = nav4 ? evt.which : evt.keyCode;
	return (key <= 13 || (key >= 48 && key <= 57));
}

function NumCheck(e, field) {
  key = e.keyCode ? e.keyCode : e.which
  // backspace
  if (key == 8) return true
  // 0-9
  if (key > 47 && key < 58) {
    if (field.value == "") return true
    regexp = /.[0-9]{2}$/
    return !(regexp.test(field.value))
  }
  // .
  if (key == 46) {
    if (field.value == "") return false
    regexp = /^[0-9]+$/
    return regexp.test(field.value)
  }
  // other key
  return false
 
}

function revisa_form(form_id) 
{
	//Con esta función revisamos los elementos del formulario que se pasa por parámetro
	var formulario = document.getElementById(form_id);	
	var valido = true;
    for (var j=0; j<formulario.elements.length; j++)
    {
        elemento=formulario.elements[j];
        if (elemento.className != 'no_requerido') //Para diferenciar los campos no requeridos en el formulario
        {
	        valor = formulario.elements[j].value;
	        if (valor == null || valor.length == 0)
	        {
	        	alert('[ERROR] El campo '+ formulario.elements[j].name +' no debe estar vacío');
	        	formulario.elements[j].style.border='1px solid red';
	        	formulario.elements[j].focus();
	        	valido = false;
	        	break;
	        }
    	}
    }
	return valido;
}