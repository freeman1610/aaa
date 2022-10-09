<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\UsuarioPermiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsuarioController extends Controller
{
    public function mostrar_listar_usuarios()
    {
        $seleccionDeUsuarios = Usuario::select(
            'idusuario',
            'nombre',
            'apellido',
            'tipo_documento',
            'num_documento',
            'direccion',
            'telefono',
            'email',
            'cargo',
            'login',
            'idtipousuario',
            'iddepartamento',
            'imagen',
            'condicion'
        )->get();

        $arrayDeDatos = array();

        foreach ($seleccionDeUsuarios as $dato) {
            $arrayDeDatos[] = array(
                "0" => ($dato->condicion) ? '<button class="btn btn-primary btn-xs" title="Editar" onclick="mostrar(' . $dato->idusuario . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-info btn-xs" title="Cambiar Clave" onclick="mostrarFormCambiarContra(' . $dato->idusuario . ')"><i class="fa fa-key"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Desactivar" onclick="desactivar(' . $dato->idusuario . ')"><i class="fa fa-times"></i></button>' : '<button class="btn btn-primary btn-xs" title="Editar" onclick="mostrar(' . $dato->idusuario . ')"><i class="fa fa-edit"></i></button>' . ' ' . '<button class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminar(' . $dato->idusuario . ')"><i class="fa fa-trash"></i></button>' . ' ' . '<button class="btn btn-info btn-xs" title="Activar" onclick="activar(' . $dato->idusuario . ')"><i class="fa fa-check"></i></button>',
                "1" => $dato->nombre,
                "2" => $dato->apellido,
                "3" => $dato->tipo_documento,
                "4" => $dato->num_documento,
                "5" => $dato->telefono,
                "6" => $dato->email,
                "7" => $dato->login,
                "8" => "<img src='vendor/img-users/" . $dato->imagen . "' height='50px' width='50px'>",
                "9" => ($dato->condicion) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
            );
        }

        $results = array(
            "sEcho" => 1, //info para datatables
            "iTotalRecords" => count($arrayDeDatos), //enviamos el total de registros al datatable
            "iTotalDisplayRecords" => count($arrayDeDatos), //enviamos el total de registros a visualizar
            "aaData" => $arrayDeDatos
        );

        return response()->json($results, status: 200);
    }

    public function lista_usuarios_editar(Request $request)
    {

        $uss = Usuario::find($request->id_user);

        return response()->json($uss, status: 200);
    }

    public function mostrar_tipo_usuario()
    {
        $seleccionarTiposDeUsuario = DB::table('tipousuario')->select('idtipousuario', 'nombre_t')->get();

        return response()->json($seleccionarTiposDeUsuario, status: 200);
    }

    public function mostrar_departamentos()
    {
        $seleccionarDepartamentos = DB::table('departamento')->select('iddepartamento', 'nombre')->get();

        return response()->json($seleccionarDepartamentos, status: 200);
    }

    public function mostrar_permisos(Request $request)
    {

        $selectPermisos = DB::table('permiso')->select()->get();

        $selectPermisosAsignados = DB::table('usuario_permiso')->select('idpermiso')->where('idusuario', $request->id_user)->get();

        $arrayPermisosAsignados = array();

        $arrayPermisosAsignadosEnviar = array();


        foreach ($selectPermisosAsignados as $dato) {
            array_push($arrayPermisosAsignados, $dato->idpermiso);
        }

        $i = 0;
        $num = count($arrayPermisosAsignados);

        foreach ($selectPermisos as $datos) {

            if (in_array($datos->idpermiso, $arrayPermisosAsignados)) {
                $arrayPermisosAsignadosEnviar[$i] = ['seleccion' => 'check', 'idpermiso' => $datos->idpermiso, 'nombre' => $datos->nombre];
            } else {
                $arrayPermisosAsignadosEnviar[$i] = ['seleccion' => '', 'idpermiso' => $datos->idpermiso, 'nombre' => $datos->nombre];
            }

            $i++;
        }

        return response()->json($arrayPermisosAsignadosEnviar, status: 200);
    }

    public function guardar_usuario_editado(Request $request)
    {

        $selectUsuario = Usuario::find($request->idusuario);

        if ($request->hasFile('imagen')) {

            $imagen_n = $request->file('imagen');
            $rutaDeGuardado = 'vendor/img-users/';
            $nombreImagenNuevo = time() . '-' . $imagen_n->getClientOriginalName();
            $moverImagen = $request->file('imagen')->move($rutaDeGuardado, $nombreImagenNuevo);

            $selectUsuario->imagen = $nombreImagenNuevo;
        }

        $selectUsuario->nombre = $request->nombre;
        $selectUsuario->apellido = $request->apellido;
        $selectUsuario->tipo_documento = $request->tipo_documento;
        $selectUsuario->num_documento  = $request->num_documento;
        $selectUsuario->direccion = $request->direccion;
        $selectUsuario->telefono = $request->telefono;
        $selectUsuario->email = $request->email;
        $selectUsuario->cargo = $request->cargo;
        $selectUsuario->login = $request->login;
        $selectUsuario->save();

        UsuarioPermiso::where('idusuario', $request->idusuario)->delete();

        foreach ($request->permiso as $dato) {
            $permisoNew = new UsuarioPermiso;
            $permisoNew->idusuario = $request->idusuario;
            $permisoNew->idpermiso = $dato;
            $permisoNew->save();
        }
    }

    public function crear_usuario(Request $request)
    {

        $this->validate($request, [
            'idtipousuario_a' => 'required',
            'iddepartamento_a' => 'required',
            'nombre_a' => 'required',
            'apellido_a' => 'required',
            'tipo_documento_a' => 'required',
            'num_documento_a' => 'required',
            'telefono_a' => 'required',
            'email_a' => 'required',
            'cargo_a' => 'required',
            'login_a' => 'required',
            'direccion_a' => 'required',
            'clave_a' => 'required|min:6'
        ]);

        $nombreImagenNuevo = "user_icon_default.png";

        if ($request->hasFile('imagen_a')) {

            $this->validate($request, [
                'imagen_a' => 'image'
            ]);


            $imagen_n = $request->file('imagen_a');
            $rutaDeGuardado = 'vendor/img-users/';
            $nombreImagenNuevo = time() . '-' . $imagen_n->getClientOriginalName();
            $request->file('imagen_a')->move($rutaDeGuardado, $nombreImagenNuevo);
        }

        $contra_cifrada = bcrypt($request->clave_a);

        $usuarioNew = new Usuario;
        $usuarioNew->nombre = $request->nombre_a;
        $usuarioNew->apellido = $request->apellido_a;
        $usuarioNew->tipo_documento =  $request->tipo_documento_a;
        $usuarioNew->num_documento =  $request->num_documento_a;
        $usuarioNew->direccion = $request->direccion_a;
        $usuarioNew->telefono = $request->telefono_a;
        $usuarioNew->email = $request->email_a;
        $usuarioNew->cargo = $request->cargo_a;
        $usuarioNew->login = $request->login_a;
        $usuarioNew->idtipousuario = $request->idtipousuario_a;
        $usuarioNew->iddepartamento = $request->iddepartamento_a;
        $usuarioNew->password = $contra_cifrada;
        $usuarioNew->remember_token = 'NULL';
        $usuarioNew->imagen = $nombreImagenNuevo;
        $usuarioNew->condicion = '1';
        $usuarioNew->save();

        if (isset($request->permiso)) {
            $usuarioNuevo = Usuario::select('idusuario')->latest()->first();
            foreach ($request->permiso as $dato) {
                $permisoNew = new UsuarioPermiso;
                $permisoNew->idusuario = $usuarioNuevo->idusuario;
                $permisoNew->idpermiso = $dato;
                $permisoNew->save();
            }
        }
    }

    public function editar_clave_usuario(Request $request)
    {

        $this->validate($request, [
            'clave' => 'required|min:6'
        ]);

        $selectUsuario = Usuario::find($request->idusuario);

        $contra_cifrada = bcrypt($request->clave);

        $selectUsuario->password = $contra_cifrada;

        $selectUsuario->save();
    }

    public function desactivar_usuario(Request $request)
    {
        $this->validate($request, [
            'idusuario' => 'required'
        ]);

        $selectUsuario = Usuario::find($request->idusuario);

        $selectUsuario->condicion = 0;

        $selectUsuario->save();

        return 'Datos Desactivados Correctamente';
    }

    public function activar_usuario(Request $request)
    {
        $this->validate($request, [
            'idusuario' => 'required'
        ]);

        $selectUsuario = Usuario::find($request->idusuario);

        $selectUsuario->condicion = 1;

        $selectUsuario->save();

        return 'Datos Activados Correctamente';
    }

    public function eliminar_usuario(Request $request)
    {
        $this->validate($request, [
            'idusuario' => 'required'
        ]);

        Usuario::destroy($request->idusuario);

        return 'Datos Eliminados Correctamente';
    }
}
