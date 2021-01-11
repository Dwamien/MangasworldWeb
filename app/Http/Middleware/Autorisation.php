<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Autorisation
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
        if(Session::get('id') == 0){
            return redirect('/getLogin');
        }
        return $next($request);
    }
}
