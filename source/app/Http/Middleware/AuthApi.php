<?php

namespace App\Http\Middleware;

use App\model\Users;
use Closure;


class AuthApi
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
        $key=$request->input('syskey');
        if(Users::checkApiKeyExist($key))
        {
            return $next($request);
        }
        else
        {
            return response()->json([
                'status'=>'101',
                'result' => 'Api Key Not Found'
            ]);
        }


    }
}
