@extends('admin.plantilla_principal')

@section('etiquetas_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection
@section('contenidoCentral')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Articulos <button class="btn btn-dark" onclick="mostrarform(true)" id="btnagregar"><i class="fa fa-plus-circle"></i> Registrar Articulo</button>
                <a target="_blank" href="#"><button class="btn btn-info">Reporte</button></a>
                </h3>
            </div>
            <div class="card-body" id="listadoregistros">
                <table id="tbllistado" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            {{-- <th>Opciones</th> --}}
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Descripcion</th>
                            <th>Fecha de Ingreso</th>
                            {{-- <th>Estado</th> --}}
                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Stock</th>
                            <th>Descripcion</th>
                            <th>Fecha de Ingreso</th>
                        </tr>
                    </tfoot>
                </table>
            </div><!-- /.card-body -->
            {{-- <div class="card-body" style="z-index:-1;" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Nombre del Articulo(*):</label>
                                <input class="form-control" type="hidden" name="idarticulo" id="idarticulo">
                                <input class="form-control" type="text" name="nombre" id="nombre" minlength="4" maxlength="100" placeholder="Nombre del Articulo" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Categoria(*):</label>
                                <select name="idcategoria" id="idcategoria" class="form-control select2" data-Live-search="true"></select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Descripción(*):</label>
                                <input class="form-control" type="text" name="descripcion" id="descripcion" minlength="4" maxlength="100" placeholder="Descripción del Articulo" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Imagen:</label>
                                <input class="form-control" type="file" name="imagen" id="imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                                <img src="" alt="" width="150px" height="120" id="imagenmuestra">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="">Codigo:</label>
                                <input class="form-control" type="text" name="codigo" id="codigo" minlength="4" maxlength="100" placeholder="codigo del producto" autocomplete="off">
                                <button class="btn btn-success mt-2" type="button" onclick="generarbarcode()">Generar Codigo</button>
                                <div id="print">
                                    <svg id="barcode"></svg>
                                </div>
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
            </div><!-- /.card-body --> --}}
        </div><!-- /.card -->
    </div><!-- /.col -->
</div>

@endsection

@section('agregarScriptsJS')


<script src="{{ asset('vendor/scripts/almacen.js') }}"></script>
<script src="{{ asset('vendor/scripts/libreria.js') }}"></script> 
@endsection