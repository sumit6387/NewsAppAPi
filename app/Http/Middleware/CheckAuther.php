<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;
use Closure;

class CheckAuther
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $email = Session::get('autherEmail');
        if(!$email){
            return Redirect::to(url('/auther/auther-login'));
        }
        return $next($request);
    }
}
