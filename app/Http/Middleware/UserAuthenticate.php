<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $companyId
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $companies = Auth::user()->companies()->get();

        foreach ($companies as $company){

            if ($company->id == $request->route('company') ){
                return $next($request);
            }
        };

        return redirect('home');
    }
}
