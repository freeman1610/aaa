@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('contenidoCentral')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Usuarios  
                    <button class="btn btn-dark" onclick="clickAgregarUsuario()" id="btnagregar"><i class="fa fa-plus-circle"></i> Agregar</button>
                    <button class="btn btn-dark" onclick="backUpDataBase()"><i class="fas fa-server"></i> Respaldo de la Base de Datos</button>
                    {{-- <button class="btn btn-dark" onclick="restoreDataBase()"><i class="fas fa-file-import"></i> Restaurar la Base de Datos</button> --}}
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre(s)</th>
                            <th>Apellido(s)</th>
                            <th>Documento</th>
                            <th>Numero Documento</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Opciones</th>
                            <th>Nombre(s)</th>
                            <th>Apellido(s)</th>
                            <th>Documento</th>
                            <th>Numero Documento</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Foto</th>
                            <th>Estado</th>
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
                                <label for="">Tipo de Usuario(*):</label>
                                <select name="idtipousuario" id="idtipousuario" class="form-control select2" data-Live-search="true" required></select>
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
                                <label for="">Nombre(*):</label>
                                <input class="form-control" type="hidden" name="idusuario" id="idusuario">
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
                                <label for="">Tipo Documento(*):</label>
                                <select name="tipo_documento" id="tipo_documento" class="form-control" required>
                                    <option value="Cedula">Cedúla</option>
                                    <option value="RIF">RIF</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Cedula: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="num_documento" id="num_documento" placeholder="Documento de Identidad" maxlength="10" onkeypress="return SoloNumeros(event)" autocomplete="off">
                                </div><!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Dirección: </label>
                                <input class="form-control" type="text" name="direccion" id="direccion"  maxlength="70" autocomplete="off" placeholder="Dirección">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Telefono:</label>
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
                                <label for="">Email: </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" type="email" name="email" id="email" maxlength="70" placeholder="email" autocomplete="off" >
                                </div><!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Cargo: </label>
                                <input class="form-control" type="text" name="cargo" id="cargo" maxlength="20" placeholder="Cargo" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Usuario(*): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" type="text" name="login" id="login" maxlength="20" placeholder="nombre de usuario" autocomplete="off" >
                                </div><!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group" align="center">
                                <label for="" class="mr-2">Imagen de Perfil:</label>
                                <img src="" alt="" class="img-fluid img-circle" width="150px" height="120" id="imagenmuestra">
                                <input class="form-control" type="file" name="imagen" id="imagen">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Permisos</label>
                                <ul id="permisos" style="list-style: none;">
                                </ul>
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
<script>

    function enviarFormCrearUsuario(){
      
        $imagen = $('#imagen_a');
        let formData = new FormData();
        let datos = $('#formularioCrearUsuario').serialize();
        formData.append('imagen_a', $imagen[0].files[0]);


        $.ajax({
            url: 'crear_usuario' + '?' + datos,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function(datos){
                toastr.success('Datos Guardados Correctamente')

                tabla.ajax.reload();
            },

            error: function(err){
                toastr.error(err.responseJSON.message)
            }

        });
    }
    
    function prueba(){
        let telll = document.getElementById('telefono_a')

        Inputmask({"mask": "(999) 999-9999"}).mask(telll)


    }
   

    function clickAgregarUsuario(){

        let idtipousuario_select = document.getElementById('idtipousuario').innerHTML

        let iddepartamento_select = document.getElementById('iddepartamento').innerHTML

        let permisos_ul = document.getElementById('permisos').innerHTML
        
        Swal.fire({
            title: '<strong>Agregar Usuario</strong>',
            html:
                 '<form action="" name="formularioCrearUsuario" id="formularioCrearUsuario" method="POST" enctype="multipart/form-data">'+
                    '<label for="">Tipo de Usuario(*):</label><select name="idtipousuario_a" id="idtipousuario_a" class="form-control select2" data-Live-search="true" required>'+idtipousuario_select+'</select>'+
                    '<br><label for="">Departamento(*):</label><select name="iddepartamento_a" id="iddepartamento_a" class="form-control select2" data-Live-search="true" >'+iddepartamento_select+'</select>'+
                                            
                    '<br><label for="">Nombre(*):</label><input type="text" name="nombre_a" placeholder="Nombre" id="nombre_a" class="form-control" required>'+
                    '<br><label for="">Apellido(*):</label><input type="text" name="apellido_a" placeholder="Apellido" id="apellido_a" class="form-control" required>'+
                    '<br><label for="">Tipo Documento(*):</label><select name="tipo_documento_a" id="tipo_documento_a" class="form-control" required>'+
                        '<option value="Cedula">Cedúla</option>'+
                        '<option value="RIF">RIF</option>'+
                        '<option value="Pasaporte">Pasaporte</option>'+
                    '</select>'+
                    '<br><label for="">Cedula:</label><input type="text" name="num_documento_a" placeholder="Cedúla" onkeypress="return SoloNumeros(event)" maxlength="10" id="num_documento_a" class="form-control" required>'+
                    '<br><label for="">Dirección:</label><input type="text" name="direccion_a" placeholder="Dirección" id="direccion_a" class="form-control" required>'+
                    '<br><label for="">Telefono:</label><input type="text" name="telefono_a" onkeydown="prueba()" placeholder="Telefono" id="telefono_a" class="form-control" required>'+
                    '<br><label for="">Email:</label><input type="email" name="email_a" placeholder="Email" id="email_a" class="form-control" required>'+
                    '<br><label for="">Cargo:</label><input type="text" name="cargo_a" placeholder="Cargo" id="cargo_a" class="form-control" required>'+
                    '<br><label for="">Usuario(*):</label><input type="text" name="login_a" placeholder="Usuario" id="login_a" class="form-control" required>'+
                    '<br><label for="">Contraseña(*):</label><input type="password" name="clave_a" placeholder="Contraseña" minlength="6" id="clave_a" class="form-control" required>'+
                    '<br><label for="">Imagen de Perfil(*):</label><input class="form" type="file" name="imagen_a" id="imagen_a">'+
                    '<br><div style="display: flex;justify-content: left;text-align: left"><ul style="list-style: none;">'+permisos_ul+'</ul></div>'+'<button class="btn btn-success mt-1" type="submit">'+
                        'Guardar Usuario'+
                    '</button>'+
                '</form>',
            showCloseButton: true,
            showConfirmButton: false,
            showCancelButton: false,
            focusConfirm: false,
        })
        
    


    }

    document.querySelector("#centro_central").addEventListener("submit", ev =>{
	
        if(ev.target.matches('#formularioCrearUsuario')){
            ev.preventDefault()
            enviarFormCrearUsuario()
        }
            
    });


</script>
<script src="{{ asset('vendor/scripts/usuario.js') }}"></script>

<script src="{{ asset('vendor/scripts/libreria.js') }}"></script>
<script src="{{ asset('vendor/scripts/passwd.js') }}"></script> 
@endsection