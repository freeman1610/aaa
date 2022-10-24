@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
    
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tipos de Usuario</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Fecha/registro</th>
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
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
            <div class="card-body" style="height: 400px; z-index:-1;" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Nombre de Tipo de Usuario</label>
                                <input class="form-control" type="hidden" name="idtipousuario" id="idtipousuario">
                                <input class="form-control" type="text" name="nombre_t" id="nombre_t" minlength="4" maxlength="50" placeholder="Nombre" readonly="true" onblur="soloMayusculas('nombre_t')" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Descripcion</label>
                                <input class="form-control" type="text" name="descripcion" id="descripcion" minlength="6" maxlength="256" placeholder="Descripcion">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <!-- text input -->
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
                                <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection
@section('agregarScriptsJS')
<script src="{{ asset('vendor/scripts/tipousuario.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script>
@endsection