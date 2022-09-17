$(document).ready(function(){

	$('#show').mousedown(function(){
	$('#clave').removeAttr('type');
	$('#clavea').removeAttr('type');
	$('#clavec').removeAttr('type');
	$('#show').addClass('fa-eye-slash').removeClass('fa-eye');
	});

	$('#show').mouseup(function(){
	$('#clave').attr('type','password');
	$('#clavea').attr('type','password');
	$('#clavec').attr('type','password');
	$('#show').addClass('fa-eye').removeClass('fa-eye-slash');
	});

});