@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Cavas  <button class="btn btn-dark" onclick="mostrarformNew()" id="btnagregar"><i class="fa fa-plus-circle"></i>Registar Cava</button></h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Placa de la Cava</th>
                            <th>Modelo de la Cava</th>
                            <th>Marca de la Cava</th>
                            <th>Estado de la Cava</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Placa de la Cava</th>
                            <th>Modelo de la Cava</th>
                            <th>Marca de la Cava</th>
                            <th>Estado de la Cava</th>
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

    function enviarFormRegistrarCava(){
        
        let datos = $('#formularioRegistrarCava').serialize();

        $.ajax({
            url: 'registrar_cava',
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

    function updateCava(id) {

        $.post("mostrar_cava", { cava_id: id }, function (res) {
            Swal.fire({
                title: 'Actualizar Cava',
                html:
                    '<form action="" name="formularioActulizarCava" id="formularioActulizarCava" method="POST">'+
                        '@csrf'+
                        '<input type="hidden" name="cava_id" id="cava_id" value="'+res[0].cava_id+'">'+
                        '<br><label class="d-flex justify-content-between" for="">Placa: </label><input type="text" autocomplete="off" name="cava_placa" placeholder="Placa" maxlength="100" id="cava_placa" class="form-control" value="'+res[0].cava_placa+'" required>'+
                        '<br><label class="d-flex justify-content-start" for="">Modelo:</label><input type="text" autocomplete="off" placeholder="Modelo" name="cava_modelo" id="cava_modelo" class="form-control" value="'+res[0].cava_modelo+'" required>'+
                        '<br><label class="d-flex justify-content-start" for="">Marca:</label><input type="text" autocomplete="off" placeholder="Marca" name="cava_marca" id="cava_marca" class="form-control" value="'+res[0].cava_marca+'" required>'+
                        '<br><label class="d-flex justify-content-start" for="">Estado del Cava</label>'+
                            '<select name="cava_estado" id="cava_estado" class="form-control" required>'+res[1]+'</select>'+
                        '<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" type="submit">'+
                            'Guardar'+
                        '</button>'+
                    '</form>',
                showCloseButton: true,
                showConfirmButton: false,
                showCancelButton: false,
                focusConfirm: false
            })
        });
    }

    function enviarFormActualizarCava() {
        let datos = $('#formularioActulizarCava').serialize();
        $.ajax({
            url: 'actualizar_cava',
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
        document.getElementById("formularioRegistrarCava").reset();
        document.getElementById('codigo').focus()
    }

    function mostrarformNew() {
        Swal.fire({
            title: 'Registrar Cava',
            html:
                '<form action="" name="formularioRegistrarCava" id="formularioRegistrarCava" method="POST">'+
                    '@csrf'+
                    '<br><label class="d-flex justify-content-between" for="">Placa: <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><input type="text" autocomplete="off" name="cava_placa" placeholder="Placa" maxlength="100" id="cava_placa" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Modelo:</label><input type="text" autocomplete="off" placeholder="Modelo" name="cava_modelo" id="cava_modelo" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Marca:</label><input type="text" autocomplete="off" placeholder="Marca" name="cava_marca" id="cava_marca" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Estado del Cava</label>'+
                        '<select name="cava_estado" id="cava_estado" class="form-control" required>'+
                            '<option value="">Seleccione</option>'+
                            '<option value="ACTIVO">ACTIVO</option>'+
                            '<option value="TALLER">TALLER</option>'+
                            '<option value="FUERA DE SERVICIO">FUERA DE SERVICIO</option>'+
                        '</select>'+
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
    document.querySelector("#centro_central").addEventListener("submit", ev =>{
        if(ev.target.matches('#formularioRegistrarCava')){
            ev.preventDefault()
            enviarFormRegistrarCava()
        }
        if(ev.target.matches('#formularioActulizarCava')){
            ev.preventDefault()
            enviarFormActualizarCava()
        }
    })
</script>
<script src="{{ asset('vendor/scripts/cavas.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection