<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( (auth()->check() && auth()->user()->rol=='ROL_ADMINISTRADOR') && auth()->user()->bloqueado==false &&  auth()->user()->eliminado==false){
            return $next($request);
        }
        else{
            // return redirect('login');
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors'  => array(array('Ocurrió un incidente')),
                    // Este campo es por si la petición es vía datatable
                    'error'   => array(array('Ocurrió un incidente')),
                    'data'    => []
                ]);
            }
            abort(403);
        }
    }
}
