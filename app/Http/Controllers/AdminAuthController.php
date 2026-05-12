<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (session('admin_authenticated')) {
            return redirect()->route('admin.index');
        }

        return view('admin.login', [
            'navigation' => config('cea.navigation'),
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $username = (string) env('ADMIN_USERNAME', 'admin');
        $password = (string) env('ADMIN_PASSWORD', '');

        if (
            hash_equals($username, $credentials['username'])
            && $password !== ''
            && hash_equals($password, $credentials['password'])
        ) {
            $request->session()->regenerate();
            $request->session()->put('admin_authenticated', true);

            return redirect()->intended(route('admin.index'));
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Username atau password admin tidak sesuai.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_authenticated');
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
