@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Departamento  <button class="btn btn-dark" onclick="mostrarformNew()" id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button></h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Fecha/registro</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Fecha/registro</th>
                            <th>Estado</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('agregarScriptsJS')
<script>
    $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    
    function enviarFormRegistrarDepartamento(){
        
        let datos = $('#formularioRegistrarDepartamento').serialize();

        $.ajax({

            url: 'registrar_departamento',
            method: 'POST',
            data: datos,

            success: function(res){
                toastr.success('Datos Guardados Correctamente')
                tabla.ajax.reload();
            },

            error: function(err){
                toastr.error(err.responseJSON.message)
            }

        });
    }

    function enviarFormActualizarDepartamento(){
        
        let datos = $('#formularioActulizarDepartamento').serialize();

        $.ajax({

            url: 'update_departamento',
            method: 'POST',
            data: datos,

            success: function(res){
                toastr.success('Datos Actualizados Correctamente')
                tabla.ajax.reload();
            },

            error: function(err){
                toastr.error(err.responseJSON.message)
            }

        });
    }

    function limpiarFormulario() {
        document.getElementById("formularioRegistrarDepartamento").reset();
        document.getElementById('nombre').focus()
    }

    function mostrarformNew() {
        Swal.fire({
            title: 'Registrar Departamento',
            html:
                '<form action="" name="formularioRegistrarDepartamento" id="formularioRegistrarDepartamento" method="POST">'+
                    '@csrf'+
                    '<br><label class="d-flex justify-content-start" for="">Nombre:</label><input type="text" autocomplete="off" placeholder="Nombre" name="nombre" id="nombre" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Descripción:</label><input type="text" name="descripcion" autocomplete="off" placeholder="Descripción" id="descripcion" class="form-control" required>'+
                    '<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" type="submit">'+
                        'Guardar'+
                    '</button>'+
                    '<button class="btn btn-info mt-3 ml-2" onclick="limpiarFormulario()" type="button">'+
                        'Limpiar'+
                    '</button></div>'+
                '</form>',
            showCloseButton: true,
            showConfirmButton: false,
            showCancelButton: false,
            focusConfirm: false
        })
    }

    function updateDepartamento(id) {
        $.post("mostrar_departamento_update", { id_departamento: id }, function (res) {
            Swal.fire({
                title: 'Actualizar Departamento: '+res.nombre,
                html:
                    '<form action="" name="formularioActulizarDepartamento" id="formularioActulizarDepartamento" method="POST">'+
                        '@csrf'+
                        '<input type="hidden" name="id_departamento" id="id_departamento" value="'+res.iddepartamento+'">'+
                        '<br><label class="d-flex justify-content-start" for="">Nombre:</label><input type="text" autocomplete="off" placeholder="Nombre" name="nombre" id="nombre" class="form-control" value="'+res.nombre+'" required>'+
                        '<br><label class="d-flex justify-content-start" for="">Descripción:</label><input type="text" name="descripcion" autocomplete="off" placeholder="Descripción" id="descripcion" class="form-control" value="'+res.descripcion+'" required>'+
                        '<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" type="submit">'+
                            'Guardar'+
                        '</button>'+
                        '<button class="btn btn-info mt-3 ml-2" onclick="limpiarFormulario()" type="button">'+
                            'Limpiar'+
                        '</button></div>'+
                    '</form>',
                showCloseButton: true,
                showConfirmButton: false,
                showCancelButton: false,
                focusConfirm: false
            })
        });
    }

    document.querySelector("#centro_central").addEventListener("submit", ev =>{
        if(ev.target.matches('#formularioRegistrarDepartamento')){
            ev.preventDefault()
            enviarFormRegistrarDepartamento()
        }
        if(ev.target.matches('#formularioActulizarDepartamento')){
            ev.preventDefault()
            enviarFormActualizarDepartamento()
        }
    })
</script>
<script src="{{ asset('vendor/scripts/departamento.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection