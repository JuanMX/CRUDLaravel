<?php

namespace App\Http\Controllers;

use Auth;
use App\Costo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CostoController extends Controller
{


    public function index(){
        return view('costo.costoIndex');
    }


    // listar costos datatables server-side
    public function listarCostos(Request $request){

        $jsonReturn = array('success'=>true, 'draw'=>'', 'recordsTotal'=>0, 'recordsFiltered'=>0, 'data'=>[]);
        
        try {
            $jsonReturn['recordsFiltered'] = DB::table('costos')->select('id', 'descripcion', 'costo', 'fecha', 'bloqueado', 'eliminado')

            //Campo de busqueda
            ->when(strlen($request['search']['value']) > 0, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    return $query->orWhereRaw('descripcion LIKE "%' . $request['search']['value'] . '%"')
                                ->orWhereRaw('costo LIKE "%' . $request['search']['value'] . '%"')
                                ->orWhereRaw('fecha LIKE "%' . $request['search']['value'] . '%"');
                });
            })
            ->where('eliminado', false)

            //Ordenamiento
            ->when((int) $request['order'][0]['column'] == 1, function ($query) use ($request) {
                return $query->orderBy('costo', $request['order'][0]['dir']);
            }, function ($query) use ($request) {
                return $query->when((int) $request['order'][0]['column'] == 2, function ($query) use ($request) {
                    return $query->orderBy('fecha', $request['order'][0]['dir']);
                });
            })
            ->get()
            ->count('1');


            $jsonReturn['data'] = DB::table('costos')->select('id', 'descripcion', 'costo', DB::raw('DATE_FORMAT(fecha, "%d-%m-%Y / %H:%i") AS fecha'), 'bloqueado', 'eliminado')

            //Campo de busqueda
            ->when(strlen($request['search']['value']) > 0, function ($query) use ($request) {
                return $query->where(function ($query) use ($request) {
                    return $query->orWhereRaw('descripcion LIKE "%' . $request['search']['value'] . '%"')
                                ->orWhereRaw('costo LIKE "%' . $request['search']['value'] . '%"')
                                ->orWhereRaw('fecha LIKE "%' . $request['search']['value'] . '%"');
                });
            })
            ->where('eliminado', false)

            //Ordenamiento
            ->when((int) $request['order'][0]['column'] == 1, function ($query) use ($request) {
                return $query->orderBy('costo', $request['order'][0]['dir']);
            }, function ($query) use ($request) {
                return $query->when((int) $request['order'][0]['column'] == 2, function ($query) use ($request) {
                    return $query->orderBy('fecha', $request['order'][0]['dir']);
                });
            })
            ->offset($request['start'])
            ->limit($request['length'])
            ->get()
            ->toArray();
            
            $jsonReturn['recordsTotal'] = count($jsonReturn['data']);
            $jsonReturn['draw'] = $request['draw'];

        } catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error'] = array("No fue posible listar la información, intente de nuevo más tarde");
            $jsonReturn['recordsTotal'] = 0; 
            $jsonReturn['recordsFiltered']=0; 
            $jsonReturn['data']=[];
        }

        return response()->json( $jsonReturn );
    }


    public function crearCosto(Request $request)
    {

        $jsonReturn = array('success'=>true, 'error'=>[], 'data'=>[]);

        try{
            $validate = \Validator::make($request->all(), [
                'costo'       => 'required|max:8|regex:/^(\d{1,5})(\.\d{1,2})?$/',
                'fecha'       => 'required|date',
                'descripcion' => 'required|max:100|regex:/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,$:\s]+$/'
            ],[
                'costo.required' => 'El costo es requerido',
                'costo.max'      => 'El costo es de máximo 5 cifras',
                'costo.regex'    => 'La cantidad del costo no es correcta',

                'fecha.required' => 'La fecha es requerida',
                'fecha.date'     => 'No es una fecha válida',

                'descripcion.required'    => 'La descripción es requerida',
                'descripcion.max'         => 'La descripción es de máximo 100 caracteres',
                'descripcion.email'       => 'En la descripción se permiten números y letras',
            ]);

            if ($validate->fails()) {
                $jsonReturn['success']=false;
                $jsonReturn['error']=$validate->errors();
            }

            if($jsonReturn['success']==true){

                DB::transaction(function() use ($request){

                    $costo = new Costo;

                    $costo->costo       = $request->costo;
                    $costo->fecha       = $request->fecha;
                    $costo->descripcion = $request->descripcion;
                    
                    $costo->save();
                });                
                
            }
        }catch(Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $jsonReturn['success']=false;
            $jsonReturn['error']=array('Ocurrió un incidente al crear el registro');
        }

        return response()->json($jsonReturn);
    }


    public function editarCosto(Request $request)
    {

        $jsonReturn = array('success'=>true, 'error'=>[], 'data'=>[]);

        try{
            $validate = \Validator::make($request->all(), [
                'costo'       => 'required|max:8|regex:/^(\d{1,5})(\.\d{1,2})?$/',
                'fecha'       => 'required|date',
                'descripcion' => 'required|max:100|regex:/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ.,$:\s]+$/',
                'idEditar' => 'required|integer|min:1',
            ],[
                'costo.required' => 'El costo es requerido',
                'costo.max'      => 'El costo es de máximo 5 cifras',
                'costo.regex'    => 'La cantidad del costo no es correcta',

                'fecha.required' => 'La fecha es requerida',
                'fecha.date'     => 'No es una fecha válida',

                'descripcion.required'    => 'La descripción es requerida',
                'descripcion.max'         => 'La descripción es de máximo 100 caracteres',
                'descripcion.email'       => 'En la descripción se permiten números y letras',

                'idEditar.required' => 'El registro es requerido',
                'idEditar.integer'  => 'El tipo de registro no es válido',
                'idEditar.min'      => 'No es un registro válido',
            ]);

            if ($validate->fails()) {
                $jsonReturn['success']=false;
                $jsonReturn['error']=$validate->errors();
            }

            if($jsonReturn['success']==true){

                DB::transaction(function() use ($request){

                    $costo = Costo::where('eliminado', false)->findOrFail($request->idEditar);

                    $costo->costo = $request->costo;
                    $costo->fecha = $request->fecha;
                    $costo->descripcion = $request->descripcion;
                    
                    $costo->save();
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


    public function bloquearCosto(Request $request)
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
                    $isUpdated = Costo::where('id', $request['id'])->where('eliminado', false)->update([
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


    public function desbloquearCosto(Request $request)
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
                    $isUpdated = Costo::where('id', $request['id'])->where('eliminado', false)->update([
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


    public function eliminarCosto(Request $request)
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
                    $isUpdated = Costo::where('id', $request['id'])->where('eliminado', false)->update([
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