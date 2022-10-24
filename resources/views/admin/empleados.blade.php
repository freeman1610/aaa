@extends('admin.plantilla_principal')

@if(session()->get('administrativo') != 1)
@section("contenidoCentral")
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-center"><h1 class="h1">401 | No Tienes Acceso a este Modulo</h1></div>
    </div>
</div>
@endsection
@else
@extends('administrativo.empleados')
@endif