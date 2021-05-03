<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
  {

    public function login(){

        if (Auth::check()){

            return redirect('usuarios');
        }
        return view('login');
    }

    public function loginUsuario(Request $request)
    {
        $jsonReturn = array('success'=>true, 'error'=>[], 'data'=>[]);

        $validate = \Validator::make($request->all(), [
            'nick'=>'required',
            'password'=>'required',
        ],[
            // 'email.required' => 'El correo electrónico del usuario es requerido',
            // 'email.email'    => 'No es un formato válido de correo electrónico',

            'nick.required' => 'El nick es requerido',
            'password.required' => 'La contraseña es requerida',
        ]);
        if ($validate->fails()) {
            $jsonReturn['success']=false;
            $jsonReturn['error']=$validate->errors();
        }

        if($jsonReturn['success']==true){
            
            $user = User::all()->where('nick','=',$request->nick)->first();
            if(!is_null($user))
            {
                if(Hash::check($request->password, $user->password)){

                    if($user->eliminado==0 && $user->bloqueado==0){//verificar si esta activo en la base de datos
                        
                        Auth::loginUsingId($user->id);

                        $bitacora = new BitacoraController();
                        $bitacora->bitacoraLogin();
                        
                        $jsonReturn['data']['inicio']="home";
                    }else{
                        $jsonReturn['success']=false;
                        $jsonReturn['error']=array("Esta cuenta está bloqueada o eliminada");
                    }
                }else{
                    $jsonReturn['success']=false;
                    $jsonReturn['error']=array("La contraseña no es correcta");
                }
            }else{
                $jsonReturn['success']=false;
                $jsonReturn['error']=array("Estas credenciales no coinciden con nuestros registros");
            }
        }
        
        return response()->json($jsonReturn);
    }

    public function logout() 
    {
        session()->flush();//quita la sesion
        return redirect()->route('root');
    }
}