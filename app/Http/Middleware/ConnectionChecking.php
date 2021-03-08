<?php

namespace App\Http\Middleware;

use Closure;

class ConnectionChecking
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
        $connected = @fsockopen("alcrace.notula.co", 80); //website, port  (try 80 or 443)                                      
        if ($connected){
        fclose($connected);       
            return true;
        }else{
            return false;
        }
        return $next($request);
    }
}
