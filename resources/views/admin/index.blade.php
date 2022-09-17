
@extends('admin.plantilla_principal')

@section('contenidoCentral')
<div class="row mt-4">
    <!-- Empleados -->
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 ml">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3 style="font-size:20px;"><strong>Empleados</strong></h3>
                <p>Total de Empleados: </p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            
            <a href="{{ route('empleados') }}" class="small-box-footer">Agregar Empleado <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <!-- Reporte Asistencia -->
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <div class="small-box bg-success">
            <a href="#" class="small-box-footer">
                <div class="inner">
                    <h5 style="font-size: 20px;"><strong>Reporte de asistencias </strong></h5>
                    <p>Módulo</p>
                </div>
                <div class="icon">
                    <i class="fa fa-list" aria-hidden="true"></i>
                </div>&nbsp;
                <div class="small-box-footer">
                    <i class="fa"></i>
                </div>
            </a>
        </div>
    </div><!-- ./col -->
    <!-- Nomina -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-6 ">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 style="font-size:20px;"><strong>Nómina Administrativa</strong></h3>
                <p>Modúlo de Nómina </p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="#" class="small-box-footer">Crear Nómina <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <!-- Ingresos  -->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 style="font-size:20px;"><strong>Ingresos</strong></h3>
                <p>Ingreso de Articulos al Sistema </p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-up"></i>
            </div>
            <a href="#" class="small-box-footer">Ingresar al Inverntario <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <!-- Ingresos  -->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 style="font-size:20px;"><strong>Egresos</strong></h3>
                <p>Egresos de Articulos al Sistema </p>
            </div>
            <div class="icon">
                <i class="fas fa-arrow-down"></i>
            </div>
            <a href="#" class="small-box-footer">Retirar Articulo del Inventario <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="card card-primary card-outline col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card-header">
            <h5 class="card-title m-0">Ingreso de Articulos de los ultimos 10 dias</h5>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="compras" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div><!-- /.card-body -->
    </div><!-- /.card -->
    <div class="card card-primary card-outline col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card-header">
            <h5 class="card-title m-0">Egreso de Articulos de los ultimos 12 meses</h5>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="egresos" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div><!-- /.card-body -->
    </div><!-- /.card -->    
</div><!-- /.row -->
@endsection