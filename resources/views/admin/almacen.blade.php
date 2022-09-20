@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('contenidoCentral')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Articulos <button class="btn btn-dark" onclick="mostrarformNew(true)" id="btnagregar"><i class="fa fa-plus-circle"></i> Registrar Articulo</button>
                </h3>
            </div>
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Codigo</th>
                            <th>Marca</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Descripcion</th>
                            <th>Fecha de Ingreso</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Codigo</th>
                            <th>Marca</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Descripcion</th>
                            <th>Fecha de Ingreso</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->
</div>

@endsection

@section('agregarScriptsJS')

<script>

    function enviarFormRegistrarArticulo(){
        
        let datos = $('#formularioRegistrarArticulo').serialize();

        $.ajax({
            url: 'registrar_articulo',
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

    function limpiarFormulario() {
        document.getElementById("formularioRegistrarArticulo").reset();
        document.getElementById('codigo').focus()
    }

    function mostrarformNew() {
        Swal.fire({
            title: 'Registrar Articulo',
            html:
                '<form action="" name="formularioRegistrarArticulo" id="formularioRegistrarArticulo" method="POST">'+
                    '@csrf'+
                    '<br><label class="d-flex justify-content-between" for="">Codigo: <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><input type="text" autocomplete="off" name="codigo" placeholder="Codigo" maxlength="100" id="codigo" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Marca:</label><input type="text" autocomplete="off" placeholder="Marca" name="marca" id="marca" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Nombre:</label><input type="text" autocomplete="off" placeholder="Nombre" name="nombre" id="nombre" class="form-control" required>'+
                    '<br><label class="d-flex justify-content-start" for="">Stock:</label><input type="number" autocomplete="off" placeholder="Stock" name="stock" id="stock" class="form-control" required>'+
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

    document.querySelector("#centro_central").addEventListener("submit", ev =>{
        if(ev.target.matches('#formularioRegistrarArticulo')){
            ev.preventDefault()
            enviarFormRegistrarArticulo()
        }
    })
</script>


<script src="{{ asset('vendor/scripts/almacen.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection