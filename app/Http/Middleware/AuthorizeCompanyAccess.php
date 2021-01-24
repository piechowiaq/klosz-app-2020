<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Company;
use App\User;
use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

use function abort;
use function assert;

class AuthorizeCompanyAccess
{
    /**
     * @return Application|RedirectResponse|Redirector|mixed
     *
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        $currentUser   = $this->getUser();
        $userCompanies = $currentUser->getCompanies();
        $routeCompany  = $request->route('company');
        assert($routeCompany instanceof Company);
        if ($currentUser->isSuperAdmin() || $userCompanies->contains($routeCompany)) {
            return $next($request);
        }

        abort(Response::HTTP_UNAUTHORIZED);
    }

    private function getUser(): User
    {
        $user = Auth::user();
        assert($user instanceof User);

        return $user;
    }
}
