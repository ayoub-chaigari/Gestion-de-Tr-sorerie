<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $module, string $action): Response
    {
        if (!$request->user() || !$request->user()->hasPermission($module, $action)) {
             if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden: Missing permission'], 403);
            }
            abort(403, "Vous n'avez pas le droit ($action) sur le module $module.");
        }

        return $next($request);
    }
}
