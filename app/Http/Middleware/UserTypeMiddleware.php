<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTypeMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            if ($user->type == 'user') {
                // Allow access for regular users
                return $next($request);
            } elseif ($user->type == 'admin') {
                // Redirect admins to admin dashboard
                return redirect()->route('admin.dashboard');
            } elseif ($user->type == 'superadmin') {
                // Redirect super admins to super admin dashboard
                return redirect()->route('superadmin.dashboard');
            }
        }
        
        // If user is not authenticated or has no defined type, redirect to login
        return redirect('/login');
    }
}