<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginUpFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAuthController extends Controller
{
    public function loginUp(LoginUpFormRequest $request)
    {

        $selectCondicion = DB::table('usuarios')->select('condicion')->where('login', $request->login)->get();


        // si condicion es igual 1 inicia sesion, sino es 0, que significa que esta desactivado

        if ($selectCondicion[0]->condicion == 1) {

            if (Auth::attempt(['login' => $request->login, 'password' => $request->password], remember: false)) {


                $id_u = Auth::user()->idusuario;

                $seleccionarPermisos = DB::table('usuario_permiso')->select('idpermiso')->where('idusuario', $id_u)->get();
                foreach ($seleccionarPermisos as $permiso) {

                    switch ($permiso->idpermiso) {

                        case 1:
                            session()->put('escritorio', '1');
                            break;

                        case 2:
                            session()->put('almacen', '1');
                            break;

                        case 3:
                            session()->put('compras', '1');
                            break;

                        case 4:
                            session()->put('egresos', '1');
                            break;

                        case 5:
                            session()->put('acceso', '1');
                            break;
                    }
                }

                return response()->json(['respuesta' => '200', 'permisos' => $seleccionarPermisos], status: 200);
            } else {

                return response()->json(['respuesta' => '404'], status: 200);
            }
        } elseif ($selectCondicion[0]->condicion == 0) {

            return response()->json(['respuesta' => '401'], status: 200);
        }
    }
}
