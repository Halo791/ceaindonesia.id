<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('admin_authenticated') !== true) {
            return redirect()->route('admin.login');
        }

        if (! $request->session()->has('admin_user')) {
            $request->session()->put('admin_user', [
                'id' => null,
                'name' => 'Super Admin',
                'username' => (string) env('ADMIN_USERNAME', 'admin'),
                'role' => 'super_admin',
                'section_key' => null,
                'item_key' => null,
            ]);
        }

        return $next($request);
    }
}
