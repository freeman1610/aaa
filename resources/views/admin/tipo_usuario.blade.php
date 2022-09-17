@extends('admin.plantilla_principal')


@if (Auth::user()->cargo == "ADMINISTRADOR")

    @extends('admin.tipo_usuario_contenido')

@else

@section('contenidoCentral')
<div class="row mt-4">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="card-title m-0">Sin acceso a Este Modúlo</h5>
        </div>
        <div class="card-body">
            <h6 class="card-title">No tienes Los Privilegios Necesarios para ingresas a Este Modúlo</h6>
        </div>
    </div>
</div>
@endsection

@endif


