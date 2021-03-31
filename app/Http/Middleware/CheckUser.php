<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
class CheckUser
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
        $headers = $request->header('token');
        $user = User::where('token',$headers)->get()->first();
        if(!$user){
            return response()->json([
                'status' => false,
                'msg' => "You have No Token"
            ]);
        }
        return $next($request);
    }
}
