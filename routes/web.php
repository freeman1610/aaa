<?php

use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\BackUpAndRestoreDBController;
use App\Http\Controllers\CavaController;
use App\Http\Controllers\ChutoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\FleteController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\NominaChoferesController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\PdfNominaChoferController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SalarioController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ViajeCompletadoController;
use App\Http\Controllers\ViajeController;
use App\Models\Flete;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::view('/', 'welcome')->name('principio');

Route::post('login', [LoginAuthController::class, 'loginUp']);

Route::view('login', 'admin.login')->name('login')->middleware('guest');

Route::middleware(['auth'])->group(function () {

    // --------------------- VISTAS PRINCIPALES ---------------------------

    Route::view('escritorio', 'admin.index')->name('escritorio');

    Route::view('usuarios', 'admin.usuarios')->name('usuarios');

    Route::view('tipo_usuario', 'admin.tipo_usuario')->name('tipo_usuario');

    Route::view('empleados', 'admin.empleados')->name('empleados');

    Route::view('nomina_personal', 'admin.nomina_personal')->name('nomina_personal');

    Route::view('nomina_chofer', 'admin.nomina_chofer')->name('nomina_chofer');

    Route::view('departamentos', 'admin.departamentos')->name('departamentos');

    Route::view('chutos', 'admin.chutos')->name('chutos');

    Route::view('cavas', 'admin.cavas')->name('cavas');

    Route::view('fletes', 'admin.fletes')->name('fletes');

    Route::view('viajes', 'admin.viajes')->name('viajes');

    Route::view('viajes_completados', 'admin.viajes_completados')->name('viajes_completados');

    Route::view('perfil', 'admin.perfil')->name('perfil');

    Route::view('salarios_base_administrativo', 'admin.salarios_base_administrativo')->name('salarios_base_administrativo');

    Route::view('almacen', 'admin.almacen')->name('almacen');

    // --------------------- FIN VISTAS PRINCIPALES ---------------------------

    Route::get('perfil_personal', [PerfilController::class, 'mostrar_perfil_personal'])->name('mostrar_perfil_personal');

    // ---------------- USUARIOS ------------------------

    Route::get('mostrar_listar_usuarios', [UsuarioController::class, 'mostrar_listar_usuarios'])->name('mostrar_listar_usuarios');

    Route::post('lista_usuarios_editar', [UsuarioController::class, 'lista_usuarios_editar'])->name('lista_usuarios_editar');

    // Las rutas "mostrar_tipo_usuario", "mostrar_departamentos", "mostrar_permisos"... Se pueden reutilizar
    // para otras vistas en el sistema

    Route::post('mostrar_tipo_usuario', [UsuarioController::class, 'mostrar_tipo_usuario'])->name('mostrar_tipo_usuario');

    Route::post('mostrar_departamentos', [UsuarioController::class, 'mostrar_departamentos'])->name('mostrar_departamentos');

    Route::post('mostrar_permisos', [UsuarioController::class, 'mostrar_permisos'])->name('mostrar_permisos');

    Route::post('guardar_usuario_editado', [UsuarioController::class, 'guardar_usuario_editado'])->name('guardar_usuario_editado');

    Route::post('crear_usuario', [UsuarioController::class, 'crear_usuario'])->name('crear_usuario');

    Route::post('editar_clave_usuario', [UsuarioController::class, 'editar_clave_usuario'])->name('editar_clave_usuario');

    Route::post('desactivar_usuario', [UsuarioController::class, 'desactivar_usuario'])->name('desactivar_usuario');

    Route::post('activar_usuario', [UsuarioController::class, 'activar_usuario'])->name('activar_usuario');

    Route::post('eliminar_usuario', [UsuarioController::class, 'eliminar_usuario'])->name('eliminar_usuario');

    //  ---------------- FIN USUARIOS ------------------------

    // ----------------- TIPO USUARIO ------------------------

    Route::get('listar_tipousuario', [TipoUsuarioController::class, 'listar_tipousuario'])->name('listar_tipousuario');

    Route::post('mostrar_tipousuario', [TipoUsuarioController::class, 'mostrar_tipousuario'])->name('mostrar_tipousuario');

    Route::post('guardar_tipousuario', [TipoUsuarioController::class, 'guardar_tipousuario'])->name('guardar_tipousuario');

    //  ---------------- FIN TIPO USUARIOS ------------------------

    // ----------------- EMPLEADOS ------------------------

    Route::get('listar_empleados', [EmpleadosController::class, 'listar_empleados'])->name('listar_empleados');

    Route::post('mostrar_empleado', [EmpleadosController::class, 'mostrar_empleado'])->name('mostrar_empleado');

    Route::post('crear_empleado', [EmpleadosController::class, 'crear_empleado'])->name('crear_empleado');

    Route::post('guardar_update_empleado', [EmpleadosController::class, 'guardar_update_empleado'])->name('guardar_update_empleado');

    Route::post('eliminar_empleado', [EmpleadosController::class, 'eliminar_empleado'])->name('eliminar_empleado');


    //  ---------------- FIN EMPLEADOS ------------------------

    // ----------------- NOMINA PERSONAL ------------------------


    Route::post('crear_nomina', [NominaController::class, 'crear_nomina'])->name('crear_nomina');

    Route::get('listar_nomina', [NominaController::class, 'listar_nomina'])->name('listar_nomina');

    Route::post('muestra_empleados_select', [EmpleadosController::class, 'muestra_empleados_select'])->name('muestra_empleados_select');

    Route::post('muestra_salario_base', [SalarioController::class, 'muestra_salario_base'])->name('muestra_salario_base');

    Route::post('mostrar_salario', [NominaController::class, 'mostrar_salario'])->name('mostrar_salario');

    Route::post('update_salario_base', [NominaController::class, 'update_salario_base'])->name('update_salario_base');

    Route::get('pagoNominaPDF', [NominaController::class, 'pagoNominaPDF'])->name('pagoNominaPDF');

    Route::get('generarPDFXfechas', [NominaController::class, 'generarPDFXfechas'])->name('generarPDFXfechas');

    //  ---------------- FIN NOMINA PERSONAL ------------------------

    // ----------------- NOMINA CHOFER ------------------------

    Route::get('listar_nomina_chofer', [NominaChoferesController::class, 'listar_nomina_chofer'])->name('listar_nomina_chofer');

    Route::post('mostrar_pagos_disponibles', [NominaChoferesController::class, 'mostrar_pagos_disponibles'])->name('mostrar_pagos_disponibles');

    Route::post('listar_datos_viaje', [NominaChoferesController::class, 'listar_datos_viaje'])->name('listar_datos_viaje');

    Route::post('crear_pago_nomina_chofer', [NominaChoferesController::class, 'crear_pago_nomina_chofer'])->name('crear_pago_nomina_chofer');

    Route::post('boton_ver_detalles', [NominaChoferesController::class, 'boton_ver_detalles'])->name('boton_ver_detalles');
    // ------------------- PDF'S -----------------------
    Route::get('pdfNominaChofer', [PdfNominaChoferController::class, 'pdfNominaChofer'])->name('pdfNominaChofer');


    //  ---------------- FIN NOMINA CHOFER ------------------------

    // ----------------- DEPARTAMENTOS ------------------------

    Route::get('listar_departamentos', [DepartamentoController::class, 'listar_departamentos'])->name('listar_departamentos');

    Route::post('mostrar_departamento_update', [DepartamentoController::class, 'mostrar_departamento_update'])->name('mostrar_departamento_update');

    Route::post('registrar_departamento', [DepartamentoController::class, 'registrar_departamento'])->name('registrar_departamento');

    Route::post('update_departamento', [DepartamentoController::class, 'update_departamento'])->name('update_departamento');

    Route::post('desactivar_departamento', [DepartamentoController::class, 'desactivar_departamento'])->name('desactivar_departamento');

    Route::post('activar_departamento', [DepartamentoController::class, 'activar_departamento'])->name('activar_departamento');

    Route::post('eliminar_departamento', [DepartamentoController::class, 'eliminar_departamento'])->name('eliminar_departamento');

    // ----------------- FIN DEPARTAMENTOS ------------------------

    // ----------------- TRANSPORTE ------------------------
    // CHUTOS
    Route::get('listar_chutos', [ChutoController::class, 'listar_chutos'])->name('listar_chutos');

    Route::post('registrar_chuto', [ChutoController::class, 'registrar_chuto'])->name('registrar_chuto');

    Route::post('mostrar_chuto', [ChutoController::class, 'mostrar_chuto'])->name('mostrar_chuto');

    Route::post('actualizar_chuto', [ChutoController::class, 'actualizar_chuto'])->name('actualizar_chuto');

    Route::post('eliminar_chuto', [ChutoController::class, 'eliminar_chuto'])->name('eliminar_chuto');
    // CAVAS
    Route::get('listar_cavas', [CavaController::class, 'listar_cavas'])->name('listar_cavas');

    Route::post('registrar_cava', [CavaController::class, 'registrar_cava'])->name('registrar_cava');

    Route::post('mostrar_cava', [CavaController::class, 'mostrar_cava'])->name('mostrar_cava');

    Route::post('actualizar_cava', [CavaController::class, 'actualizar_cava'])->name('actualizar_cava');

    Route::post('eliminar_cava', [CavaController::class, 'eliminar_cava'])->name('eliminar_cava');
    // FLETES
    Route::get('listar_fletes', [FleteController::class, 'listar_fletes'])->name('listar_fletes');

    Route::post('listar_estados', [FleteController::class, 'listar_estados'])->name('listar_estados');

    Route::post('listar_municipios', [FleteController::class, 'listar_municipios'])->name('listar_municipios');

    Route::post('listar_parroquias', [FleteController::class, 'listar_parroquias'])->name('listar_parroquias');

    Route::post('registrar_flete', [FleteController::class, 'registrar_flete'])->name('registrar_flete');

    Route::post('mostrar_flete', [FleteController::class, 'mostrar_flete'])->name('mostrar_flete');

    Route::post('update_flete', [FleteController::class, 'update_flete'])->name('update_flete');

    Route::post('eliminar_flete', [FleteController::class, 'eliminar_flete'])->name('eliminar_flete');
    // VIAJES
    Route::get('listar_viajes', [ViajeController::class, 'listar_viajes'])->name('listar_viajes');

    Route::post('listar_crear_viaje', [ViajeController::class, 'listar_crear_viaje'])->name('listar_crear_viaje');

    Route::post('listar_fletes_ida', [ViajeController::class, 'listar_fletes_ida'])->name('listar_fletes_ida');

    Route::post('listar_fletes_retorno', [ViajeController::class, 'listar_fletes_retorno'])->name('listar_fletes_retorno');

    Route::post('crear_viaje', [ViajeController::class, 'crear_viaje'])->name('crear_viaje');

    Route::post('mostrar_viaje', [ViajeController::class, 'mostrar_viaje'])->name('mostrar_viaje');

    Route::post('update_viaje', [ViajeController::class, 'update_viaje'])->name('update_viaje');

    Route::post('viaje_completado', [ViajeController::class, 'viaje_completado'])->name('viaje_completado');

    Route::post('viaje_delete', [ViajeController::class, 'viaje_delete'])->name('viaje_delete');


    // VIAJE COMPLETADOS
    Route::get(
        'listar_viaje_completado',
        [
            ViajeCompletadoController::class,
            'listar_viaje_completado'
        ]
    )->name('listar_viaje_completado');

    Route::get(
        'detalle_viaje_completado',
        [
            ViajeCompletadoController::class,
            'detalle_viaje_completado'
        ]
    )->name('detalle_viaje_completado');

    // ---------------------- SISTEMA ------------------------

    Route::post('backupsql', [BackUpAndRestoreDBController::class, 'backupsql'])->name('backupsql');

    Route::post('limpieza_backup_db', [BackUpAndRestoreDBController::class, 'limpieza_backup_db'])->name('limpieza_backup_db');

    // Route::post('restore_db', [BackUpAndRestoreDBController::class, 'restore_db'])->name('restore_db');

    //  ---------------- FIN TRANSPORTE ------------------------

    // ----------------- ALMACEN ------------------------

    Route::get('listar_almacen', [AlmacenController::class, 'listar_almacen'])->name('listar_almacen');

    Route::post('registrar_articulo', [AlmacenController::class, 'registrar_articulo'])->name('registrar_articulo');

    Route::post('mostrar_articulo_update', [AlmacenController::class, 'mostrar_articulo_update'])->name('mostrar_articulo_update');

    Route::post('update_articulo', [AlmacenController::class, 'update_articulo'])->name('update_articulo');

    Route::post('eliminar_articulo', [AlmacenController::class, 'eliminar_articulo'])->name('eliminar_articulo');

    // ----------------- FIN ALMACEN ------------------------

    // ----------------- PERFIL ------------------------

    Route::post('guardar_perfil_editado', [PerfilController::class, 'guardar_perfil_editado'])->name('guardar_perfil_editado');

    Route::post('guardar_foto_perfil_editado', [PerfilController::class, 'guardar_foto_perfil_editado'])->name('guardar_foto_perfil_editado');

    Route::post('editar_contra_perfil', [PerfilController::class, 'editar_contra_perfil'])->name('editar_contra_perfil');

    //  ---------------- FIN PERFIL ------------------------

    Route::get('logout', [LogoutController::class, 'exitt'])->name('logout.exitt');
});

require __DIR__ . '/auth.php';
