@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Chutos  <button class="btn btn-dark" onclick="mostrarformNew()" id="btnagregar"><i class="fa fa-plus-circle"></i>Registrar Chuto</button></h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Placa del Chuto</th>
                            <th>Modelo del Chuto</th>
                            <th>Marca del Chuto</th>
                            <th>Estado del Chuto</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Placa del Chuto</th>
                            <th>Modelo del Chuto</th>
                            <th>Marca del Chuto</th>
                            <th>Estado del Chuto</th>
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

    function enviarFormRegistrarChuto(){
        
        let datos = $('#formularioRegistrarChuto').serialize();

        $.ajax({
            url: 'registrar_chuto',
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

    function updateChuto(id) {

        $.post("mostrar_chuto", { chuto_id: id }, function (res) {
            Swal.fire({
                title: 'Actualizar Chuto',
                html:
                    '<form action="" name="formularioActulizarChuto" id="formularioActulizarChuto" method="POST">'+
                        '@csrf'+
                        '<input type="hidden" name="chuto_id" id="chuto_id" value="'+res[0].chuto_id+'">'+
                        '<br><label class="d-flex justify-content-between" for="">Placa: </label><input type="text" autocomplete="off" name="chuto_placa" placeholder="Placa" maxlength="100" id="chuto_placa" class="form-control" value="'+res[0].chuto_placa+'" required>'+
                        '<br><label class="d-flex justify-content-start" for="">Modelo:</label><input type="text" autocomplete="off" placeholder="Modelo" name="chuto_modelo" id="chuto_modelo" class="form-control" value="'+res[0].chuto_modelo+'" required>'+
                        '<br><label class="d-flex justify-content-start" for="">Marca:</label><input type="text" autocomplete="off" placeholder="Marca" name="chuto_marca" id="chuto_marca" class="form-control" value="'+res[0].chuto_marca+'" required>'+
                        '<br><label class="d-flex justify-content-start" for="">Estado del Chuto</label>'+
                            '<select name="chuto_estado" id="chuto_estado" class="form-control" required>'+res[1]+'</select>'+
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

    function enviarFormActualizarChuto() {
        let datos = $('#formularioActulizarChuto').serialize();
        $.ajax({
            url: 'actualizar_chuto',
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
        document.getElementById("formularioRegistrarChuto").reset();
        document.getElementById('codigo').focus()
    }

    function mostrarformNew() {
        Swal.fire({
            title: 'Registrar Chuto',
            html:
                '<form action="" name="formularioRegistrarChuto" id="formularioRegistrarChuto" method="POST">'+
                    '@csrf'+
                    '<br><label class="d-flex justify-content-between" for="">Placa: <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><input type="text" autocomplete="off" name="chuto_placa" placeholder="Placa" maxlength="100" id="chuto_placa" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Modelo:</label><input type="text" autocomplete="off" placeholder="Modelo" name="chuto_modelo" id="chuto_modelo" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Marca:</label><input type="text" autocomplete="off" placeholder="Marca" name="chuto_marca" id="chuto_marca" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Estado del Chuto</label>'+
                        '<select name="chuto_estado" id="chuto_estado" class="form-control" required>'+
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
        if(ev.target.matches('#formularioRegistrarChuto')){
            ev.preventDefault()
            enviarFormRegistrarChuto()
        }
        if(ev.target.matches('#formularioActulizarChuto')){
            ev.preventDefault()
            enviarFormActualizarChuto()
        }
    })
</script>
<script src="{{ asset('vendor/scripts/chutos.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection