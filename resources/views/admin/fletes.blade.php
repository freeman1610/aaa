@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Fletes  <button class="btn btn-dark" onclick="mostrarform()" id="btnagregar"><i class="fa fa-plus-circle"></i>Registrar Flete</button></h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Codigo</th>
                            <th>Destino del Flete</th>
                            <th>Kilometros</th>
                            <th>Valor Con Carga</th>
                            <th>Valor Sin Carga</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Codigo</th>
                            <th>Destino del Flete</th>
                            <th>Kilometros</th>
                            <th>Valor Con Carga</th>
                            <th>Valor Sin Carga</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
            <div class="card-body" style="z-index:-1;" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                    <div class="row">
                        <div class="col-sm-6"> 
                            <!-- text input -->
                            <div class="form-group">
                                <label for="flete_destino">Destino</label>
                                <input class="form-control" type="hidden" name="flete_id" id="flete_id">
                                <input class="form-control" type="text" name="flete_destino" id="flete_destino" maxlength="100" placeholder="Destino" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="flete_kilometros">Kilometros</label>
                                <input class="form-control" type="text" name="flete_kilometros" id="flete_kilometros" maxlength="10" placeholder="Kilometros del Flete" autocomplete="off" onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="flete_valor_en_carga">Valor en Carga</label>
                                <input type="text" class="form-control" name="flete_valor_en_carga" id="flete_valor_en_carga" placeholder="Valor Carga" maxlength="10" autocomplete="off" onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <label for="flete_valor_sin_carga">Valor Sin Carga</label>
                            <input type="text" class="form-control" name="flete_valor_sin_carga" id="flete_valor_sin_carga" placeholder="Valor Sin Carga" maxlength="10" autocomplete="off" onkeyup="numeracionDeMil(this,this.value.charAt(this.value.length-1))">    
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
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('agregarScriptsJS')
<script src="{{ asset('vendor/scripts/fletes.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection