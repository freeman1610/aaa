@extends('admin.plantilla_principal')

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
            <select name="id_empleado" style="display: none" id="id_empleado"></select>
            <input type="hidden" id="salario">
        </div><!-- /.card -->
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection

@section('agregarScriptsJS')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function enviarConsultaPDFXfechas() {
 
        let fecha_inicio = document.getElementById('fecha_inicio').value
        let fecha_fin = document.getElementById('fecha_fin').value
        // Compruebo fechas
        if(fecha_inicio > fecha_fin){
 
            toastr.error('No puedes realizar una busqueda desde el '+fecha_fin+' al '+fecha_inicio)
 
        }else{
            let datos = $('#formGenerarPDFXfechas').serialize();
            window.open('generarPDFXfechas?'+datos, '_blank')     
        }
    }

    function GenerarPDFXfechas() {
        Swal.fire({
            title: '<strong>Seleccione el rango de Fechas</strong>',
            html:
                '<form name="formGenerarPDFXfechas" id="formGenerarPDFXfechas" method="post">'+
                    '<div class="d-flex justify-content-between">'+
                        '<div>'+
                            '<label for="">Fecha Inicio</label>'+
                            '<input type="date" class="form-control" required id="fecha_inicio" name="fecha_inicio">'+
                        '</div>'+
                        '<div>'+
                            '<label for="">Fecha Fin</label>'+
                            '<input type="date" class="form-control" required id="fecha_fin" name="fecha_fin">'+
                        '</div>'+
                    '</div>'+
                    '<br><button class="btn btn-success" type="submit">Generar</button>'+
                '</form>',
            showCloseButton: true,
            showConfirmButton: false,
            showCancelButton: false,
            focusConfirm: false,
        })
        
    }

    function salarioBase() {
        $.ajax({
            url: 'mostrar_salario',
            method: 'POST',

            success: function(res){
                Swal.fire({
                title: '<strong>Salario Base</strong>',
                html:
                    '<table class="table">'+
                    '<tbody>'+
                            '<tr>'+
                                '<td>Salario Mensual:</td>'+
                                '<td> Bs '+res.salarioMensual+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>Salario Quincenal:</td>'+
                                '<td> Bs '+res.salarioQuincenal+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>Salario Diario:</td>'+
                                '<td> Bs '+res.salarioDiario+'</td>'+
                            '</tr>'+
                            '<tr>'+
                                '<td>Salario por Hora:</td>'+
                                '<td> Bs '+res.salarioHora+'</td>'+
                            '</tr>'+
                        '</tbody>'+
                    '</table>',
                preConfirm: () => {
                    mostrarFormSalarioBase()
                },
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Actualizar Salario',
            })
            },

            error: function(err){
                toastr.error(err.responseJSON.message)
            }

        });
       
    }

    function mostrarFormSalarioBase () {

        $.ajax({
            url: 'mostrar_salario',
            method: 'POST',

            success: function(res){
                Swal.fire({
                    title: '<strong>Actualizar Salario Base</strong>',
                    html:
                        '<form action="" name="formularioSalarioBase" id="formularioSalarioBase" method="POST">'+
                            '@csrf'+
                            '<input type="number" required class="form-control" value="'+res.salarioMensual+'" name="salario_base" id="salario_base" step="any">'+
                            '<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" type="submit">Guardar</button>'+
                            '<button class="btn btn-danger cancel-form-update-salario mt-3" type="button">Cancelar</button></div>'+
                        '</form>',
                    showCloseButton: true,
                    showConfirmButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                })
            },

            error: function(err){
                toastr.error(err.responseJSON.message)
            }

        });

        
    }

    function enviarFormCrearUsuario(){

      let datos = $('#formularioCrearNomina').serialize();

        $.ajax({
            url: 'crear_nomina',
            method: 'POST',
            data: datos,

            success: function(res){
                toastr.success('Datos Guardados Correctamente')
                tabla.ajax.reload();
            },

            error: function(err){
                toastr.error(err.responseJSON.message)
            }

        });
    }

    function updateSalarioBase(){

    let datos = $('#formularioSalarioBase').serialize();

    $.ajax({
        url: 'update_salario_base',
        method: 'POST',
        data: datos,

        success: function(res){
            toastr.success('Datos Guardados Correctamente')
            init()
        },

        error: function(err){
            toastr.error(err.responseJSON.message)
        }

    });
    }

    function limpiarFormulario(formulario) {
        document.getElementById("formularioCrearNomina").reset();
        document.getElementById('id_empleado_a').focus()
    }
    
    function clickAgregarNomina(){

        let id_empleado_select = document.getElementById('id_empleado').innerHTML
        let salario_value = document.getElementById('salario').value
        Swal.fire({
            title: '<strong>Pago de Nomina</strong>',
            html:
                '<form action="" name="formularioCrearNomina" id="formularioCrearNomina" method="POST">'+
                    '@csrf'+
                    '<br><label class="d-flex justify-content-between" for="">Empleado(*): <button class="btn btn-info btn-sm" onclick="limpiarFormulario()" type="button">Limpiar</button></label><select name="id_empleado_a" id="id_empleado_a" class="form-control select2" required data-Live-search="true" ><option value="">Seleccione</option>'+id_empleado_select+'</select>'+
                    '<br><label for="" class="d-flex justify-content-start">Salario Mensual(*):</label><input type="text" class="form-control" value="Bs '+salario_value+'" readonly>'+
                    '<br><label for="" class="d-flex justify-content-start">Tipo de Nómina(*):</label><select name="tipo_nomina_a" id="tipo_nomina_a" class="form-control select2" required data-Live-search="true"><option value="">Seleccione</option>'+
                        '<option value="mensual">Mensual</option>'+
                        '<option value="quincenal">Quincenal</option>'+
                    '</select>'+
                    '<br><label for="" class="d-flex justify-content-start">Fecha de pago de Nomina(*)</label><input type="date" required class="form-control" name="inicio_pago_a" id="inicio_pago_a"'+
                    '<br><br><label for="" class="d-flex justify-content-start">Dias Laborados(*):</label><input class="form-control" type="text" name="dias_lab_a" id="dias_lab_a" minlength="1" required placeholder="Días Laborados" autocomplete="off" onkeypress="return SoloNumeros(event)" minlength="0" maxlength="2" onkeyup="contarNumsMensual()">'+
                    '<br><label for="" class="d-flex justify-content-start">Dia(s) de Descanso Remunerado:(*)</label><input class="form-control" type="text" name="dias_lib_a" id="dias_lib_a" minlength="1" required placeholder="Días de Descanso" autocomplete="off" onkeypress="return SoloNumeros(event)" minlength="0" maxlength="2" onkeyup="contarNumsMensual()">'+
                    '<br><label for="" class="d-flex justify-content-start">Horas Extra Diurnas(*):</label><input class="form-control" type="text" name="hora_d_a" id="hora_d_a" minlength="1 required" placeholder="Días de Permiso" autocomplete="off" onkeypress="return SoloNumeros(event)">'+
                    '<br><label for="" class="d-flex justify-content-start">Horas Extra Nocturnas(*):</label><input class="form-control" type="text" name="hora_n_a" id="hora_n_a" minlength="1" required placeholder="Días de Permiso" autocomplete="off" onkeypress="return SoloNumeros(event)">'+
                    '<div class="d-flex justify-content-around"><button class="btn btn-success mt-3" id="botonSubmitNomina" type="submit">'+
                        'Realizar Pago'+
                    '</button>'+
                    '<button class="btn btn-info mt-3 ml-2" onclick="limpiarFormulario()" type="button">'+
                        'Limpiar'+
                    '</button></div>'+
                '</form>',
            showCloseButton: true,
            showConfirmButton: false,
            showCancelButton: false,
            focusConfirm: false,
        })
    }

    document.querySelector("#centro_central").addEventListener("submit", ev =>{

        if(ev.target.matches('#formularioCrearNomina')){
            ev.preventDefault()
            enviarFormCrearUsuario()
        }

        if(ev.target.matches('#formularioSalarioBase')){
            ev.preventDefault()
            updateSalarioBase()
        }

        if(ev.target.matches('#formGenerarPDFXfechas')){
            ev.preventDefault()
            enviarConsultaPDFXfechas()
        }
        
    });

    document.querySelector("#centro_central").addEventListener("click", ev =>{

        if(ev.target.matches('.cancel-form-update-salario')){
            salarioBase()
        }

    });


</script>
<script src="{{ asset('vendor/scripts/nomina.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script>

@endsection