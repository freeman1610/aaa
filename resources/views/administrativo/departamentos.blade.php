
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
<script src="{{ asset('vendor/scripts/departamento.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection