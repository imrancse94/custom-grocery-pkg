<?php

namespace Imrancse94\Grocery\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Imrancse94\Grocery\app\Services\PermissionService;
use Symfony\Component\HttpFoundation\Response;

class Permission
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentRoute = Route::currentRouteName();

        $role = auth('grocery')->user()->role ?? null;

        $permission = PermissionService::PERMISSIONS;

        if(current($permission[$role]) == '*' || in_array($currentRoute, $permission[$role])) {
            return $next($request);
        }

        return \response()->json([
            'error'=>'Unauthorized',
            'message'=>'You don\'t have permission to access this page.'
        ],401);
    }
}
