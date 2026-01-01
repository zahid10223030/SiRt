<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/')->withErrors([
                'email' => 'Anda harus login terlebih dahulu',
            ]); // atau redirect()->route('login')
        }

        // 2. Baru ambil role setelah dipastikan login
        $roleName = Role::find(Auth::user()->role_id);

        if (!$roleName || !in_array($roleName->name, $roles)) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini'); // atau redirect dengan pesan
        }

        return $next($request);
    }
}
