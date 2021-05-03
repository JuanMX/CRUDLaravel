<?php

namespace App\Http\Controllers;

use App\Costo;
use App\User;
use App\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class bitacoraController extends Controller
{
    public function index(){
        return view('bitacora.bitacora');
    }

    public function bitacoraDataTable(Request $request){
        
        // $buscarPorColumna=array();
        // $columnasParaBuscar=6;
        // $ultimaColumna=0;
        // $whereColumnas="";

        // for($i=1; $i<=$columnasParaBuscar; $i++){
        //     if($request['columns'][$i]['search']['value']!=""){
        //         //idObjeto          
        //         if($i==3){
        //             $buscarPorColumna[$i] = 'idObjeto = '.$request['columns'][$i]['search']['value'].' AND ';
        //         }
        //         //nombre
        //         else if($i==4){
        //             $nombre = $request['columns'][$i]['search']['value'];
        //             $buscarPorColumna[$i] = '("'. $nombre.'" LIKE Concat(Concat("%",nombre),"%") OR "'.$nombre.'" LIKE Concat(Concat("%",apellidoPaterno),"%") OR "'.$nombre.'" LIKE Concat(Concat("%",apellidoMaterno),"%")'.') AND ';
        //         }
        //         //fecha
        //         else if($i==6){
        //             $date = $request['columns'][$i]['search']['value'];
        //             $date = str_replace('/', '-', $date);

        //             if(str_contains($date, ':')){
        //                 $fecha = date('Y-m-d H:i:s', strtotime($date));
        //             }
        //             else{
        //                 $fecha = date('Y-m-d', strtotime($date));
        //             }

        //             $buscarPorColumna[$i] = 'bitacoraMovimiento.created_at LIKE "%'.$fecha.'%" AND ';
                    
        //         }
        //         else{
        //             $tabla= $request['columns'][$i]['data'];
        //             $buscarPorColumna[$i] = $tabla.' LIKE "%'.$request['columns'][$i]['search']['value'].'%" AND ';
        //         }
        //         $ultimaColumna=$i;
        //     }
        //     else{
        //         $buscarPorColumna[$i] = "";
        //     }
        // }
        
        // //Quita el "AND" al final del query en la ultima columna por la que se busco ("la mas a la derecha"), para evitar errores de sintaxis en el query
        // if($ultimaColumna>0){
        //     $quitadoAND = str_replace('AND ', '', $buscarPorColumna[$ultimaColumna]);
        //     $buscarPorColumna[$ultimaColumna] = $quitadoAND;

        //     //arma el query
        //     for($i=1; $i<=$columnasParaBuscar; $i++){
        //         if( $buscarPorColumna[$i]!="" ){
        //             $whereColumnas= $whereColumnas.$buscarPorColumna[$i];
        //         }
        //     }
        // }

        $bitacoraCount = DB::table('bitacora')
            ->join('users', 'bitacora.idUsuario', '=', 'users.id')
            ->select('bitacora.descripcion', 'bitacora.tipoAccion', 'bitacora.tabla', 'bitacora.ip', 'bitacora.created_at', 'users.nick AS idUsuario')

        ->when(strlen($request['search']['value']) > 0, function ($query) use ($request) {
            return $query->where(function ($query) use ($request) {
                return $query->orWhereRaw('tipoAccion LIKE "%' . $request['search']['value'] . '%"')
                            ->orWhereRaw('tabla LIKE "%' . $request['search']['value'] . '%"')
                            ->orWhereRaw('nick LIKE "%' . $request['search']['value'] . '%"');
            });
        })
        
        // ->when(strlen($whereColumnas) > 0, function ($query) use ($request, $whereColumnas) {
        //     return $query->where(function ($query) use ($request, $whereColumnas) {
        //         return $query->whereRaw($whereColumnas);
        //     });
        // })

        ->when((int) $request['order'][0]['column'] == 1, function ($query) use ($request) {
            return $query->orderBy('tipoAccion', $request['order'][0]['dir']);
        }, function ($query) use ($request) {
            return $query->when((int) $request['order'][0]['column'] == 2, function ($query) use ($request) {
                return $query->orderBy('tabla', $request['order'][0]['dir']);
            }, function ($query) use ($request) {
                return $query->when((int) $request['order'][0]['column'] == 3, function ($query) use ($request) {
                    return $query->orderBy('idUsuario', $request['order'][0]['dir']);
                }, function ($query) use ($request) {
                    return $query->when((int) $request['order'][0]['column'] == 4, function ($query) use ($request) {
                        return $query->orderBy('ip', $request['order'][0]['dir']);
                    }, function ($query) use ($request) {
                        return $query->when((int) $request['order'][0]['column'] == 5, function ($query) use ($request) {
                            return $query->orderBy('created_at', $request['order'][0]['dir']);
                        });
                    });
                });
            });
        })
        ->get()
        ->count('1');
        
        //$bitacora = BitacoraMovimiento::select('descripcion', 'tipoAccion', 'tabla', 'idObjeto', 'idUsuarioMod', 'ip', 'created_at')
        
        $bitacora = DB::table('bitacora')
        ->join('users', 'bitacora.idUsuario', '=', 'users.id')
        ->select('bitacora.descripcion', 'bitacora.tipoAccion', 'bitacora.tabla', 'bitacora.ip', 'bitacora.created_at', 'users.nick AS idUsuario')

        ->when(strlen($request['search']['value']) > 0, function ($query) use ($request) {
            return $query->where(function ($query) use ($request) {
                return $query->orWhereRaw('tipoAccion LIKE "%' . $request['search']['value'] . '%"')
                            ->orWhereRaw('tabla LIKE "%' . $request['search']['value'] . '%"')
                            ->orWhereRaw('nick LIKE "%' . $request['search']['value'] . '%"');
            });
        })

        // ->when(strlen($whereColumnas) > 0, function ($query) use ($request, $whereColumnas) {
        //     return $query->where(function ($query) use ($request, $whereColumnas) {
        //         return $query->whereRaw($whereColumnas);
        //     });
        // })
        
        ->when((int) $request['order'][0]['column'] == 1, function ($query) use ($request) {
            return $query->orderBy('tipoAccion', $request['order'][0]['dir']);
        }, function ($query) use ($request) {
            return $query->when((int) $request['order'][0]['column'] == 2, function ($query) use ($request) {
                return $query->orderBy('tabla', $request['order'][0]['dir']);
            }, function ($query) use ($request) {
                return $query->when((int) $request['order'][0]['column'] == 3, function ($query) use ($request) {
                    return $query->orderBy('idUsuario', $request['order'][0]['dir']);
                }, function ($query) use ($request) {
                    return $query->when((int) $request['order'][0]['column'] == 4, function ($query) use ($request) {
                        return $query->orderBy('ip', $request['order'][0]['dir']);
                    }, function ($query) use ($request) {
                        return $query->when((int) $request['order'][0]['column'] == 5, function ($query) use ($request) {
                            return $query->orderBy('created_at', $request['order'][0]['dir']);
                        });
                    });
                });
            });
        })
        ->offset($request['start'])
        ->limit($request['length'])
        ->get()
        ->toArray();


        
        for ($i=0; $i<count($bitacora); $i++){
            // $keys = array_keys(json_decode($bitacora[$i]['descripcion'], JSON_UNESCAPED_UNICODE));
            // $bitacora[$i]['descripcion'] = json_decode($bitacora[$i]['descripcion'], JSON_UNESCAPED_UNICODE);
            $keys = array_keys(json_decode($bitacora[$i]->descripcion, JSON_UNESCAPED_UNICODE));
            $bitacora[$i]->descripcion = json_decode($bitacora[$i]->descripcion, JSON_UNESCAPED_UNICODE);
                               //<div class='container'>
            $nuevaDescripcion = "<div class='container'><div class='table-responsive' ><table class='table table-sm display responsive' width='100%'><thead>";
            for($j=0; $j<count($keys); $j++){

                $nuevaDescripcion = $nuevaDescripcion."<th>".$keys[$j]."</th>";
                
            }
            $nuevaDescripcion= $nuevaDescripcion."</thead>";
            for($j=0; $j<count($keys); $j++){
                
                $nuevaDescripcion= $nuevaDescripcion."<td>".$bitacora[$i]->descripcion[$keys[$j]]."</td>";
                
            }
            $nuevaDescripcion= $nuevaDescripcion."</table></div></div>";
            
            $bitacora[$i]->descripcion = $nuevaDescripcion;
            
        }
        //$bitacora[0]['descripcion'] = json_decode($bitacora[0]['descripcion'], JSON_UNESCAPED_UNICODE);

        // dd(array_keys(json_decode($bitacora[0]['descripcion'], JSON_UNESCAPED_UNICODE)));
        //$bitacora[0]['descripcion']="<h3>Contraseña</h3>".$bitacora[0]['descripcion']['contrasenia']."<h3>ID</h3>".$bitacora[0]['descripcion']['id'];
        
        return response()->json([
            'draw'            => $request['draw'],
            'recordsTotal'    => count($bitacora),
            'recordsFiltered' => $bitacoraCount,
            'data'            => $bitacora,
        ]);
    }


    public function bitacoraLogin()
    {
        $banderaRetorno = true;
        try {
            DB::transaction(function () {
                $idUsuario = 0;
                if (isset((Auth::user()->id)) == true) {
                    $idUsuario = Auth::user()->id;
                }
                Bitacora::create([
                    'tipoAccion'     => 'Login',
                    'tabla'          => 'users',
                    'idUsuario'      => $idUsuario,
                    'ip'             => $_SERVER['REMOTE_ADDR'],
                    'descripcion'    => json_encode(array('Acción' => 'Inicio de sesión', 'Nick' => Auth::user()->nick), JSON_UNESCAPED_UNICODE),
                ]);
            });
        } catch (Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $banderaRetorno = false;
        }
        return $banderaRetorno;
    }


    public function bitacoraDelete($objeto)
    {
        // $a = json_encode($objeto->toArray(), JSON_UNESCAPED_UNICODE);
        // $a = json_decode($a, JSON_UNESCAPED_UNICODE);
        // dd($objeto->toArray());
        $banderaRetorno = true;
        try {
            DB::transaction(function () use ($objeto) {
                $idUsuario = 0;
                if (isset((Auth::user()->id)) == true) {
                    $idUsuario = Auth::user()->id;
                }

                $camposObjecto = $this->getArrayCampos(get_class($objeto));
                $aux           = array();

                foreach ($camposObjecto as $valorCampo) {

                    if($valorCampo=='eliminado'){
                        $aux[$valorCampo] = $objeto[$valorCampo];
                    }

                }

                BitacoraMovimiento::create([
                    'idObjeto'       => $objeto->id,
                    'tabla'          => str_replace('App\\', '', get_class($objeto)),
                    // 'descripcion'    => json_encode($objeto->toArray(), JSON_UNESCAPED_UNICODE),
                    'descripcion'    => json_encode($aux, JSON_UNESCAPED_UNICODE),
                    'ip'             => $_SERVER['REMOTE_ADDR'],
                    'idUsuarioMod'   => $idUsuario,
                    'tipoAccion'     => 'Eliminar',
                ]);
            });
        } catch (Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $banderaRetorno = false;
        }
        return $banderaRetorno;
    }
    

    public function bitacoraUpdate($objeto = [])
    {
        $banderaRetorno = true;
        try {
            DB::transaction(function () use ($objeto) {
                $idUsuario = 0;
                if (isset((Auth::user()->id)) == true) {
                    $idUsuario = Auth::user()->id;
                }
                $camposObjecto = $this->getArrayCampos(get_class($objeto['nuevo']));
                $aux           = array();

                foreach ($camposObjecto as $valorCampo) {
                    if ($objeto['anterior'][$valorCampo] != $objeto['nuevo'][$valorCampo]) {

                        if($valorCampo=='created_at' || $valorCampo=='updated_at'){
                            $aux[$valorCampo] = date("Y-m-d H:i:s", strtotime($objeto['anterior'][$valorCampo])) . ' => ' . date("Y-m-d H:i:s", strtotime($objeto['nuevo'][$valorCampo]));
                        }
                        else{
                            $aux[$valorCampo] = $objeto['anterior'][$valorCampo] . ' => ' . $objeto['nuevo'][$valorCampo];
                        }
                    }
                }
                if (count($aux) > 0) {
                    // $aux['id'] = $objeto['anterior']['id']; // pone el idObjeto al final de descripcion
                    BitacoraMovimiento::create([
                        'idObjeto'       => $objeto['nuevo']->id,
                        'tabla'          => str_replace('App\\', '', get_class($objeto['nuevo'])),
                        'descripcion'    => json_encode($aux, JSON_UNESCAPED_UNICODE),
                        'ip'             => $_SERVER['REMOTE_ADDR'],
                        'idUsuarioMod'   => $idUsuario,
                        'tipoAccion'     => 'Actualizar',
                    ]);
                }
            });
        } catch (Exception $e) {
            Log::error(__CLASS__ . '/' . __FUNCTION__ . ' (Linea: ' . $e->getLine() . '): ' . $e->getMessage());
            $banderaRetorno = false;
        }
        return $banderaRetorno;
    }

    //OBTIENE LOS VALORES DE PARAMETROS DE CADA CLASE DE OBJETO
    public function getArrayCampos($nombreObjeto)
    {
        switch ($nombreObjeto) {
            case 'App\Costo':
                $model = new costo();
                break;
            case 'App\User':
                $model = new User();
                break;
        }
        return $model->getFillable();
    }
}