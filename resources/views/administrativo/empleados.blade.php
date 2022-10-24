@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Empleados  <button class="btn btn-dark" onclick="clickAgregarEmpleado()" id="btnagregar"><i class="fa fa-plus-circle"></i>Agregar</button></h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre Y Apellido</th>
                            <th>Cedula</th>
                            <th>Fecha de Ingreso</th>
                            <th>Telefono</th>
                            <th>Dirección</th>
                            <th>Cargo</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre Y Apellido</th>
                            <th>Cedula</th>
                            <th>Fecha de Ingreso</th>
                            <th>Telefono</th>
                            <th>Dirección</th>
                            <th>Cargo</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
            <div class="card-body" style="z-index:-1;" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Nombre(*):</label>
                                <input class="form-control" type="hidden" name="id_emp" id="id_emp">
                                <input class="form-control" type="text" name="nombre" id="nombre" maxlength="20" placeholder="Nombre" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Apellido(*):</label>
                                <input class="form-control" type="text" name="apellido" id="apellido" maxlength="20" placeholder="Apellido" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Cedúla: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="cedula" id="cedula" placeholder="Documento de Identidad" maxlength="10" onkeypress="return SoloNumeros(event)" autocomplete="off">
                                </div><!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Tipo Documento(*):</label><select name="tipo_documento" id="tipo_documento" class="form-control" required>
                                    <option value="Cedula">Cedúla</option>
                                    <option value="RIF">RIF</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Cargo(*):</label>
                                <input class="form-control" type="text" name="cargo" id="cargo" maxlength="20" placeholder="Cargo" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Fecha de Nacimiento</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" class="form-control" name="fecha_nac" id="fecha_nac">
                                  </div><!-- /.input group -->
                            </div>     
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Departamento(*):</label>
                                <select name="iddepartamento" id="iddepartamento" class="form-control select2" data-Live-search="true" ></select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Telefono: </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="telefono" id="telefono" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                </div><!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Fecha de Ingreso:</label>
                                <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Dirección: </label>
                                <input class="form-control" type="text" name="direccion" id="direccion"  maxlength="70" autocomplete="off" placeholder="Dirección">
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
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->

@endsection

@section('agregarScriptsJS')
<script src="{{ asset('vendor/scripts/empleados.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection