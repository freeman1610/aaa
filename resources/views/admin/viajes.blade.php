@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Viajes  <button class="btn btn-dark" onclick="mostrarform()" id="btnagregar"><i class="fa fa-plus-circle"></i>Registrar Viaje</button></h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Codigo del Viaje</th>
                            <th>Chofer</th>
                            <th>Camion</th>
                            <th>Destino</th>
                            <th>Descripcion de la Carga</th>
                            <th>Fecha de Ida y Retorno</th>
                            <th>Observaciones del Viaje</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Codigo del Viaje</th>
                            <th>Chofer</th>
                            <th>Camion</th>
                            <th>Destino</th>
                            <th>Descripcion de la Carga</th>
                            <th>Fecha de Ida y Retorno</th>
                            <th>Observaciones del Viaje</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
@section('agregarScriptsJS')
<script src="{{ asset('vendor/scripts/viajes.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection