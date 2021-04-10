<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index(){
        return view('usuario.index');
    }

    public function listaUsuario(){

        $jsonReturn = array('success'=>true,'data'=>[]);
        
        try {
            $jsonReturn['data'] = DB::table('users')->select('id','name','email')->get()->toArray();
        } catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error'] = array("No fue posible listar la información, intente de nuevo más tarde");
        }

        return response()->json(['data'=>$jsonReturn['data']]);
    }
}