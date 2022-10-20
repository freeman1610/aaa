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
                            <th>Estado</th>
                            <th>Codigo</th>
                            <th>Proveedor</th>
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
                            <th>Estado</th>
                            <th>Codigo</th>
                            <th>Proveedor</th>
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
<script src="{{ asset('vendor/scripts/almacen.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection