
@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row mt-4 justify-content-center">
    <!-- Empleados -->
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 ml">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3 style="font-size:20px;"><strong>Empleados</strong></h3>
                <p>Total de Empleados: <span class="h3" id="empleados"></p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            @if(Auth::user()->cargo == 'ADMINISTRADOR' || session()->get('administrativo') == 1)
            <a href="{{ route('empleados') }}" class="small-box-footer">Agregar Empleado <i class="fas fa-arrow-circle-right"></i></a>
            @endif
        </div>
    </div><!-- ./col -->
     <!-- Empleados -->
     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 ml">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3 style="font-size:20px;"><strong>Viajes</strong></h3>
                <p>Viajes en Curso: <span class="h3" id="viajes_curso"></span></p>
            </div>
            <div class="icon">
                <i class="fas fa-shipping-fast"></i>
            </div>
            @if(Auth::user()->cargo == 'ADMINISTRADOR' || session()->get('administrativo') == 1)
            <a href="{{ route('viajes') }}" class="small-box-footer">Registar Viaje <i class="fas fa-arrow-circle-right"></i></a>
            @endif
        </div>
    </div><!-- ./col -->
  
    <div class="card card-primary card-outline col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card-header">
            <h5 class="card-title m-0">Chutos más usados en este Mes</h5>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="chutosss" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div><!-- /.card-body -->
    </div><!-- /.card -->
    <div class="card card-primary card-outline col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card-header">
            <h5 class="card-title m-0">Estado más visitado en este Mes</h5>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="estadosss" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div><!-- /.card-body -->
    </div><!-- /.card -->    
</div><!-- /.row -->
@endsection

@section('agregarScriptsJS')
<script src="{{ asset('vendor/scripts/contenido_index.js') }}"></script>
@endsection