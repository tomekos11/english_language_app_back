<?php

namespace App\Http\Middleware;

use Closure;
use Modules\Auth\Enums\RoleEnum;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->role === RoleEnum::ADMIN) {
            return $next($request);
        }

        return apiResponse(false, [], 'Odmowa dostepu', 403);
    }
}
