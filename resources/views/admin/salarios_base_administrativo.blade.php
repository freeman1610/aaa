@extends('admin.plantilla_principal')

@section('contenidoCentral')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Salario Base</h3>
            </div><!-- /.card-header -->
            <div class="card-body" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Salario Mensual Base(*):</label>
                                <input type="text" id="salario_men" name="salario_men" autocomplete="off">
                            </div>
                        </div>
                        {{-- <div class="col-sm-2 col-4">
                            <div class="form-group">
                                <label for="">Moneda(*):</label>
                                <select class="form-control" name="" id="">
                                    <option value="">Dolares $</option>
                                    <option value="">COP $</option>
                                    <option value="">Bolivares Bs</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Salario Mensual(*):</label>
                                <input class="form-control" type="text" name="salario" id="salario" minlength="1" placeholder="Salario Mensual" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Dias Laborados(*):</label>
                                <input class="form-control" type="text" name="dias_lab" id="dias_lab" minlength="1" placeholder="Días Laborados" maxlength="2" autocomplete="off" onkeyup="calcularMaxDias()" onkeypress="return SoloNumeros(event)">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Dias de Descanso(*):</label>
                                <input class="form-control" type="text" name="dias_desc" id="dias_desc" minlength="1" placeholder="Días de Descanso" maxlength="2" autocomplete="off" onkeyup="calcularMaxDias()" onkeypress="return SoloNumeros(event)">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Dias de Permiso(*):</label>
                                <input class="form-control" type="text" name="dias_perm" id="dias_perm" minlength="1" placeholder="Días de Permiso" maxlength="2" autocomplete="off" onkeyup="calcularMaxDias()" onkeypress="return SoloNumeros(event)">
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

    
// function numeracion(iddd){

    // onkeypress="numeracion(this.value)"
//     // var number = 1000;
//     var myNumeral = numeral (iddd);
//     var currencyString = myNumeral.format('$0,0.00');
    
//     console.log(currencyString);
    
//     // let formateador = new Intl.NumberFormat("en", { style: "currency", "currency": "ves" });
//     // let numero = iddd;
//     // let formateado = formateador.format(numero);

//     // console.log(formateado);
// }

</script>

<script src="{{ asset('vendor/scripts/libreria.js') }}"></script>
@endsection
