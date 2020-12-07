<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Company;
use App\User;
use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

use function assert;
use function redirect;

class UserAuthenticate
{
    /**
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if ($user === null) {
            throw new Exception('User is null');
        }

        assert($user instanceof User);

        $companies    = $user->getCompanies();
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
