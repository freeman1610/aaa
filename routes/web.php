<?php

use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SalarioController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\UsuarioController;
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

    Route::post('muestra_empleados_select', [EmpleadosController::class, 'muestra_empleados_select'])->name('muestra_empleados_select');

    Route::post('crear_empleado', [EmpleadosController::class, 'crear_empleado'])->name('crear_empleado');

    Route::post('guardar_update_empleado', [EmpleadosController::class, 'guardar_update_empleado'])->name('guardar_update_empleado');

    Route::post('eliminar_empleado', [EmpleadosController::class, 'eliminar_empleado'])->name('eliminar_empleado');


    //  ---------------- FIN EMPLEADOS ------------------------

    // ----------------- NOMINA PERSONAL ------------------------ 


    Route::post('crear_nomina', [NominaController::class, 'crear_nomina'])->name('crear_nomina');

    Route::get('listar_nomina', [NominaController::class, 'listar_nomina'])->name('listar_nomina');

    Route::post('muestra_empleados', [EmpleadosController::class, 'muestra_empleados'])->name('muestra_empleados');

    Route::post('muestra_salario_base', [SalarioController::class, 'muestra_salario_base'])->name('muestra_salario_base');

    Route::post('mostrar_salario', [NominaController::class, 'mostrar_salario'])->name('mostrar_salario');

    Route::post('update_salario_base', [NominaController::class, 'update_salario_base'])->name('update_salario_base');

    Route::get('pagoNominaPDF', [NominaController::class, 'pagoNominaPDF'])->name('pagoNominaPDF');

    //  ---------------- FIN NOMINA PERSONAL ------------------------

    // ----------------- ALMACEN ------------------------ 

    Route::get('listar_almacen', [AlmacenController::class, 'listar_almacen'])->name('listar_almacen');



    // ----------------- FIN ALMACEN ------------------------ 

    // ----------------- PERFIL ------------------------ 

    Route::post('guardar_perfil_editado', [PerfilController::class, 'guardar_perfil_editado'])->name('guardar_perfil_editado');

    Route::post('guardar_foto_perfil_editado', [PerfilController::class, 'guardar_foto_perfil_editado'])->name('guardar_foto_perfil_editado');

    Route::post('editar_contra_perfil', [PerfilController::class, 'editar_contra_perfil'])->name('editar_contra_perfil');

    //  ---------------- FIN PERFIL ------------------------

    Route::get('logout', [LogoutController::class, 'exitt'])->name('logout.exitt');
});

require __DIR__ . '/auth.php';
