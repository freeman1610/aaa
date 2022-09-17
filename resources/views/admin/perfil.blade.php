@extends('admin.plantilla_principal')

@section('contenidoCentral')

<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Perfil</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('escritorio') }}">Escritorio</a></li>
            <li class="breadcrumb-item active">{{ Auth::user()->nombre }}</li>
        </ol>
    </div>
</div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<div class="content">
<div class="container-fluid">
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img id="imgUserPlantillaPerfil" class="profile-user-img img-fluid img-circle" src="vendor/img-users/{{ Auth::user()->imagen }}" width="128px" alt="User profile picture">
                </div>
                <div class="text-center mt-3">
                    
                    <button class="btn btn-info" onclick="mostrarFormCambiarImagen()">Cambiar Foto</button>
                
                </div>
                <h3 class="profile-username text-center">{{ Auth::user()->nombre }}</h3>
                <p class="text-muted text-center">{{ Auth::user()->cargo }}</p>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- About Me Box -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Seguridad</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div>
                    <!-- text input -->
                    <div>
                        <button class="btn btn-info" onclick="mostrar_clave('{{ Auth::user()->idusuario }}')"><i class="fa fa-key"></i>   Cambiar Contraseña</button>
                    </div>
                </div>    
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('guardar_perfil_editado') }}" name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                                    <!-- text input -->
                            <div class="form-group">
                                <label for="">Nombre(*):</label>
                                <input class="form-control" type="hidden" name="idusuario" id="idusuario">
                                <input class="form-control" type="text" name="nombre" id="nombre" maxlength="20" placeholder="Nombre" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Apellido(*):</label>
                                <input class="form-control" type="text" name="apellido" id="apellido" maxlength="20" placeholder="Apellido" autocomplete="off" required>
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
                                <label for="">Documento Nro: </label>
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
                                <label for="">Usuario(*): </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input class="form-control" type="text" name="login" id="login" maxlength="20" placeholder="nombre de usuario" autocomplete="off" >
                                </div><!-- /.input group -->
                            </div>
                        </div>              
                        <div class="col-sm-12 mt-2">
                            <!-- text input -->
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>  Guardar</button>
                                <button class="btn btn-danger" onclick="cancelarform2()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.card-body -->
               
            <div class="modal fade" id="getCodeModal" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width: 40% !important;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambio de contraseña</h4>
                            <div class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form action="" name="formularioc" id="formularioc" method="POST">
                                @csrf
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group" id="claves">
                                        <label for="">Password(*): </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input class="form-control" type="password" name="clavec" id="clavec" maxlength="64" minlength="6" placeholder="Clave" autocomplete="off" required>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-eye" id="show"></i></span>
                                            </div>
                                        </div><!-- /.input group -->
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar_clave"><i class="fa fa-save"></i>  Guardar</button>
                                        <button class="btn btn-danger"  type="button"  data-dismiss="modal" ><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->


@endsection

@section('agregarScriptsJS')
    <script>


    function guardarImagen()
    {
        $imagen_new = $('#imagen_new');
        let formData = new FormData();
        let datos = $('#formulario_img').serialize();

        formData.append('imagen_new', $imagen_new[0].files[0]);

        $.ajax({
            url: 'guardar_foto_perfil_editado' + '?' + datos,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){

                toastr.success('Imagen Actualizada');

                $('#imgUserPlantillaPerfil').attr('src', 'vendor/img-users/'+res.nueva_img)
                $('#imgFormSweet').attr('src', 'vendor/img-users/'+res.nueva_img)
                $('#imgUser1').attr('src', 'vendor/img-users/'+res.nueva_img)
                $('#imgUser2').attr('src', 'vendor/img-users/'+res.nueva_img)
                $('#imgUser3').attr('src', 'vendor/img-users/'+res.nueva_img)


            },
            error: function(err){
                toastr.error(err.responseJSON.message);
            }
        })

    }


   

    function mostrarFormCambiarImagen(){

        let imagen_ruta = $('#imgUser1').attr('src')

        Swal.fire({
            title: '<strong>Imagen Actual</strong>',
            html:
                '<img id="imgFormSweet" class="img-fluid img-circle mb-4" src="'+imagen_ruta+'" width="200" height="200"><br>' +
                '<form action="" name="formulario_img" id="formulario_img" method="POST" enctype="multipart/form-data">'+
                '    @csrf'+
                    '<input class="form" type="file" name="imagen_new" id="imagen_new">'+
                    '<button class="btn btn-default mt-4" type="submit">'+
                        'Guardar Imagen'+
                    '</button>'+
                '</form>',
            showCloseButton: true,
            showConfirmButton: false,
            showCancelButton: false,
            focusConfirm: false,
        })
    }


    document.querySelector("#centro_central").addEventListener("submit", ev =>{
	
	if(ev.target.matches('#formulario_img')){
        ev.preventDefault()
        guardarImagen()
    }
        
    });
        
        
    
    </script>
    <script src="{{ asset('vendor/scripts/libreria.js') }}"></script>
    <script src="{{ asset('vendor/scripts/perfil.js') }}"></script>
    
    <script src="{{ asset('vendor/scripts/passwd.js') }}"></script>
@endsection