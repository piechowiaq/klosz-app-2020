<?php

namespace App\Http\Middleware;

use App\Company;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserAuthenticate
{

    public function handle($request, Closure $next)
    {

        $companies = Auth::user()->companies()->get();

        foreach ($companies as $company){

            if ($company->id = $request->route('company')){
                return $next($request);
            }

        };

        return redirect('/login');
    }
}
