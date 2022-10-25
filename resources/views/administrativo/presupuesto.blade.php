@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Presupuesto
                    <button class="btn btn-dark" id="btnPresupuesto"><i class="fa fa-plus-circle"></i>Asignar Presupuesto</button>
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Administrador</th>
                            <th>Fondos Agregados</th>
                            <th>Presupuesto Anterior</th>
                            <th>Presupuesto Actual</th>
                            <th>Fecha del Presupuesto</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Administrador</th>
                            <th>Fondos Agregados</th>
                            <th>Presupuesto Anterior</th>
                            <th>Presupuesto Actual</th>
                            <th>Fecha del Presupuesto</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
            <select name="id_empleado" style="display: none" id="id_empleado"></select>
            <input type="hidden" id="salario">
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('agregarScriptsJS')
<script src="{{ asset('vendor/scripts/presupuesto.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script>
@endsection