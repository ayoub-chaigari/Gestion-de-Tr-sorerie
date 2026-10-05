<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // 1. Check if user is individually suspended
            if ($user->status === 'suspended') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->withErrors([
                    'email' => 'Votre compte a été suspendu. Veuillez contacter l\'administrateur.'
                ]);
            }

            // 2. Check if the user's company is suspended (Grace access to Support)
            if ($user->role !== 'SUPER_ADMIN' && $user->company_id) {
                $company = $user->company;
                if ($company && $company->status !== 'active') {
                    // Allow access to support and logout routes
                    if ($request->is('support*') || $request->routeIs('support.*', 'profile.*', 'logout')) {
                        return $next($request);
                    }

                    // For all other routes, redirect to support instead of logging out
                    return redirect()->route('support.index')->with('error', 'L\'accès aux services standard est suspendu. Vous pouvez uniquement accéder au Support pour le moment.');
                }
            }
        }

        return $next($request);
    }
}
