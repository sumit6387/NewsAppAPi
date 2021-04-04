<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Auther;
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
        $auther = Auther::where('email',$email)->get()->first();
        Session::put('amount',$auther->amount);
        if(!$email){
            return Redirect::to(url('/auther/auther-login'));
        }
        return $next($request);
    }
}
