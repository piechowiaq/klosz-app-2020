<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use function abort;
use function assert;

class AuthorizeAdminPanelAccess
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->getUser()->isSuperAdmin()) {
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
