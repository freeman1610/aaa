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
<script src="{{ asset('vendor/scripts/cavas.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection