<?php

namespace App\Http\Middleware;

use App\Company;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->isSuperAdmin()){

            return $next($request);
        }

        else

        $companies = Auth::user()->companies()->get();

        foreach ($companies as $company){

            if ($company->id == $request->route('company')){
                return $next($request);
            }

        };

        return redirect('/login');
    }
}
