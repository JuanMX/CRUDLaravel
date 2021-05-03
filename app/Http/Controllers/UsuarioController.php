<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UsuarioController extends Controller
{
    public function index(){
        return view('usuario.index');
    }

    public function listarUsuarios(){

        $jsonReturn = array('success'=>true,'data'=>[]);
        
        try {
            $jsonReturn['data'] = DB::table('users')->select('id', 'nick', 'rol', 'genero', 'bloqueado', 'eliminado')->where('eliminado', false)->get()->toArray();
        } catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error'] = array("No fue posible listar la información, intente de nuevo más tarde");
        }

        return response()->json(['data'=>$jsonReturn['data']]);
    }


    public function crearUsuario(Request $request)
    {

        $jsonReturn = array('success'=>true, 'error'=>[], 'data'=>[]);

        try{
            $validate = \Validator::make($request->all(), [
                // 'nombre'      => 'required|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ.\s]+$/',
                'nick' => [
                    'required',
                    Rule::unique('users')->ignore($request->nick),
                    'alpha_dash',
                    'max:255',
                ],
                'rol' => [
                    'required',
                    Rule::in(['ROL_BASICO', 'ROL_ADMINISTRADOR']),
                ],
                'genero' => [
                    'required',
                    Rule::in(['MASCULINO', 'FEMENINO', 'OTRO']),
                ],
                'contrasenia' => 'required|confirmed|max:255|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[\w~@#$%^&*+=`{}:;,!.?\"()\[\]-_¡¿°¬´<>]{8,}$/',
                // 'email'       => [
                //     'required',
                //     Rule::unique('users')->ignore($request->email),
                //     'email',
                //     'max:255',
                // ],
            ],[
                // 'nombre.required' => 'El nombre es requerido',
                // 'nombre.max'      => 'El nombre es de máximo 255 caracteres',
                // 'nombre.regex'    => 'El nombre solo debe contener letras',

                'nick.required'   => 'El nick es requerido',
                'nick.max'        => 'El nick es de máximo 255 caracteres',
                'nick.alpha_dash' => 'El nick solo debe contener números, letras, guiones y guiones bajos sin espacios',
                'nick.unique'     => 'El nick no está disponible',

                'rol.required' => 'El rol es requerido',
                'rol.in'       => 'El rol no es válido',

                'genero.required' => 'El género es requerido',
                'genero.in'       => 'El género no es válido',

                'contrasenia.required'   => 'La contraseña es requerida',
                'contrasenia.confirmed'  => 'La contraseña y su confirmación no coinciden',
                'contrasenia.regex'      => 'La contraseña debe contener: mínimo 8 caracteres, al menos una mayúscula, al menos una minúscula y al menos un número',
                

                // 'email.required'    => 'El correo electrónico es requerido',
                // 'email.max'         => 'El correo electrónico es de máximo 255 caracteres',
                // 'email.email'       => 'No es un correo electrónico válido',
                // 'email.unique'      => 'El correo electrónico no está disponible',
            ]);

            if ($validate->fails()) {
                $jsonReturn['success']=false;
                $jsonReturn['error']=$validate->errors();
            }

            if($jsonReturn['success']==true){

                DB::transaction(function() use ($request){

                    $usuario = new User;

                    // $usuario->name     = $request->nombre;
                    $usuario->nick     = $request->nick;
                    $usuario->password = Hash::make($request->contrasenia);
                    // $usuario->email    = $request->email;
                    $usuario->rol      = $request->rol;
                    $usuario->genero   = $request->genero;
                    
                    $usuario->save();
                });                
                
            }
        }catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error']=array('Ocurrió un incidente al crear el registro');
        }

        return response()->json($jsonReturn);
    }


    public function editarUsuario(Request $request)
    {

        $jsonReturn = array('success'=>true, 'error'=>[], 'data'=>[]);

        try{
            $validate = \Validator::make($request->all(), [
                // 'nombre'      => 'required|max:255|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ.\s]+$/',
                // 'email'       => [
                //     'required',
                //     Rule::unique('users')->ignore($request->id),
                //     'email',
                //     'max:255',
                // ],
                'nick' => [
                    'required',
                    Rule::unique('users')->ignore($request->id),
                    'alpha_dash',
                    'max:255',
                ],
                'rol' => [
                    'required',
                    Rule::in(['ROL_BASICO', 'ROL_ADMINISTRADOR']),
                ],
                'genero' => [
                    'required',
                    Rule::in(['MASCULINO', 'FEMENINO', 'OTRO']),
                ],
                'id' => 'required|integer|min:1',
            ],[
                // 'nombre.required' => 'El nombre es requerido',
                // 'nombre.max'      => 'El nombre es de máximo 255 caracteres',
                // 'nombre.regex'    => 'El nombre solo debe contener letras',

                // 'email.required'    => 'El correo electrónico es requerido',
                // 'email.max'         => 'El correo electrónico es de máximo 255 caracteres',
                // 'email.email'       => 'No es un correo electrónico válido',
                // 'email.unique'      => 'El correo electrónico no está disponible',

                'nick.required'   => 'El nick es requerido',
                'nick.max'        => 'El nick es de máximo 255 caracteres',
                'nick.alpha_dash' => 'El nick solo debe contener números, letras, guiones y guiones bajos sin espacios',
                'nick.unique'     => 'El nick no está disponible',

                'rol.required' => 'El rol es requerido',
                'rol.in'       => 'El rol no es válido',

                'genero.required' => 'El género es requerido',
                'genero.in'       => 'El género no es válido',

                'id.required' => 'El registro es requerido',
                'id.integer'  => 'El tipo de registro no es válido',
                'id.min'      => 'No es un registro válido',
            ]);

            if ($validate->fails()) {
                $jsonReturn['success']=false;
                $jsonReturn['error']=$validate->errors();
            }

            if($jsonReturn['success']==true){

                DB::transaction(function() use ($request){

                    $usuario = User::where('eliminado', false)->findOrFail($request->id);;

                    // $usuario->name     = $request->nombre;
                    // $usuario->email    = $request->email;

                    $usuario->nick  = $request->nick;
                    $usuario->rol   = $request->rol;
                    $usuario->genero = $request->genero;
                    
                    $usuario->save();
                });                
                
            }
        } catch (ModelNotFoundException $e) {
                        
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error']= array('Ocurrió un incidente al guardar la información');
        }catch(Exception $e) {
            
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error']=array('Ocurrió un incidente al crear el registro');
        }

        return response()->json($jsonReturn);
    }


    public function bloquearUsuario(Request $request)
    {
        $jsonReturn = array('success'=>true, 'error'=>[], 'data'=>[]);
        $isUpdated = false;
        try {

            $validate = \Validator::make($request->all(), [
                'id' => 'required|integer|min:1',                
            ],[
                'id.required' => 'El registro es requerido',
                'id.integer'  => 'El tipo de registro no es válido',
                'id.min'      => 'No es un registro válido',
            ]);
            if ($validate->fails()) {
                $jsonReturn['success']=false;
                $jsonReturn['error']=$validate->errors();
            }

            if($jsonReturn['success']){
                DB::transaction(function () use ($request, &$isUpdated) {
                    $isUpdated = User::where('id', $request['id'])->where('eliminado', false)->update([
                        'bloqueado' => true,
                    ]);
                });

                if (!$isUpdated) {

                    $jsonReturn['success']=false;
                    $jsonReturn['error']=array("No fue posible bloquear el registro, intente de nuevo más tarde");

                }
            }

        } catch (Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error']=array('Ocurrió un incidente al bloquear el registro');
        }
        return response()->json($jsonReturn);
    }


    public function desbloquearUsuario(Request $request)
    {
        $jsonReturn = array('success'=>true, 'error'=>[], 'data'=>[]);
        $isUpdated = false;
        try {

            $validate = \Validator::make($request->all(), [
                'id' => 'required|integer|min:1',                
            ],[
                'id.required' => 'El registro es requerido',
                'id.integer'  => 'El tipo de registro no es válido',
                'id.min'      => 'No es un registro válido',
            ]);
            if ($validate->fails()) {
                $jsonReturn['success']=false;
                $jsonReturn['error']=$validate->errors();
            }

            if($jsonReturn['success']){
                
                DB::transaction(function () use ($request, &$isUpdated) {
                    $isUpdated = User::where('id', $request['id'])->where('eliminado', false)->update([
                        'bloqueado' => false,
                    ]);
                });

                if (!$isUpdated) {

                    $jsonReturn['success']=false;
                    $jsonReturn['error']=array("No fue posible desbloquear el registro, intente de nuevo más tarde");

                }
            }

        } catch (Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error']=array('Ocurrió un incidente al desbloquear el registro');
        }
        return response()->json($jsonReturn);
    }


    public function eliminarUsuario(Request $request)
    {
        $jsonReturn = array('success'=>true, 'error'=>[], 'data'=>[]);
        $isUpdated = false;
        try {

            $validate = \Validator::make($request->all(), [
                'id' => 'required|integer|min:1',                
            ],[
                'id.required' => 'El registro es requerido',
                'id.integer'  => 'El tipo de registro no es válido',
                'id.min'      => 'No es un registro válido',
            ]);
            if ($validate->fails()) {
                $jsonReturn['success']=false;
                $jsonReturn['error']=$validate->errors();
            }

            if($jsonReturn['success']){
                DB::transaction(function () use ($request, &$isUpdated) {
                    $isUpdated = User::where('id', $request['id'])->where('eliminado', false)->update([
                        'eliminado' => true,
                    ]);
                });

                if (!$isUpdated) {

                    $jsonReturn['success']=false;
                    $jsonReturn['error']=array("No fue posible eliminar el registro, intente de nuevo más tarde");

                }
            }

        } catch (Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error']=array('Ocurrió un incidente al desbloquear el registro');
        }
        return response()->json($jsonReturn);
    }
}