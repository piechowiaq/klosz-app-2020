<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Company;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function assert;
use function redirect;

class UserAuthenticate
{

    public function handle(Request $request, Closure $next)
    {
        /**
         * @var Collection|Company[] $companies
         */
        $companies    = Auth::user()->companies;
        $routeCompany = $request->route('company');
        assert($routeCompany instanceof Company);
        foreach ($companies as $company) {
            if ($company->getId() === $routeCompany->getId()) {
                return $next($request);
            }
        }

        return redirect('/login');
    }
}
