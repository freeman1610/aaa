@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Fletes  <button class="btn btn-dark" onclick="mostrarform()" id="btnagregar"><i class="fa fa-plus-circle"></i>Registrar Flete</button></h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Codigo</th>
                            <th>Destino del Flete</th>
                            <th>Kilometros</th>
                            <th>Valor Con Carga</th>
                            <th>Valor Sin Carga</th>
                            <th>Estado</th>
                            <th>Tipo de Flete</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Codigo</th>
                            <th>Destino del Flete</th>
                            <th>Kilometros</th>
                            <th>Valor Con Carga</th>
                            <th>Valor Sin Carga</th>
                            <th>Estado</th>
                            <th>Tipo de Flete</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('agregarScriptsJS')
<script src="{{ asset('vendor/scripts/fletes.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection