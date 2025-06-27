<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $roles (dapat berupa single role atau multiple roles dipisah koma)
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized. Please login first.'
            ], 401);
        }

        $user = Auth::user();
        
        // Convert roles string to array (split by comma)
        $allowedRoles = array_map('trim', explode(',', $roles));

        // Check if user has any of the required roles
        if (!in_array($user->role, $allowedRoles)) {
            return response()->json([
                'message' => 'Forbidden. You do not have permission to access this resource.',
                'required_roles' => $allowedRoles,
                'your_role' => $user->role
            ], 403);
        }

        return $next($request);
    }
}
