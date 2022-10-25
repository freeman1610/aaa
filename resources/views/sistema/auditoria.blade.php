
@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Auditoria
                    <button class="btn btn-dark" onclick="autUsuairo()"><i class="fas fa-user"></i> Auditar Usuario</button>
                    <button class="btn btn-dark" onclick="GenerarPDFXfechas()" id="btnagregar"><i class="fas fa-file-alt"></i> Generar PDF por rango de fechas</button>
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Operacion</th>
                            <th>Origen</th>
                            <th>Valores Viejos</th>
                            <th>Valores Nuevos</th>
                            <th>Fecha del Movimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Usuario</th>
                            <th>Operacion</th>
                            <th>Origen</th>
                            <th>Valores Viejos</th>
                            <th>Valores Nuevos</th>
                            <th>Fecha del Movimiento</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('agregarScriptsJS')
<script src="{{ asset('vendor/scripts/auditoria.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection