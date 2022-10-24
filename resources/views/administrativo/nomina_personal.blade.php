@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Nómina 
                    <button class="btn btn-dark" onclick="clickAgregarNomina()" id="btnagregar"><i class="fa fa-plus-circle"></i>Realizar Pago</button>
                    <button class="btn btn-dark" onclick="salarioBase()" id="btnagregar"><i class="fa fa-money-check-alt"></i> Salario Base</button>
                    <button class="btn btn-dark" onclick="GenerarPDFXfechas()" id="btnagregar"><i class="fas fa-file-alt"></i> Generar PDF por rango de fechas</button>
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Empleado</th>
                            <th>Salario Mensual</th>
                            <th>Tipo de Nomina</th>
                            <th>Inicio del Pago</th>
                            <th>Fin del Pago</th>
                            <th>Total Asignaciones</th>
                            <th>Total deducciones</th>
                            <th>Total Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Empleado</th>
                            <th>Salario Mensual</th>
                            <th>Tipo de Nomina</th>
                            <th>Inicio del Pago</th>
                            <th>Fin del Pago</th>
                            <th>Total Asignaciones</th>
                            <th>Total deducciones</th>
                            <th>Total Pago</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
            <input type="hidden" id="salario">
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('agregarScriptsJS')
<script src="{{ asset('vendor/scripts/nomina.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script>
@endsection