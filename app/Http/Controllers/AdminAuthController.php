<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (session('admin_authenticated')) {
            return redirect($this->landingUrl(session('admin_user')));
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

        if ($adminUser = $this->databaseUser($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('admin_authenticated', true);
            $request->session()->put('admin_user', $adminUser);

            return redirect()->intended($this->landingUrl($adminUser));
        }

        if ($this->legacyCredentialsMatch($credentials)) {
            $adminUser = [
                'id' => null,
                'name' => 'Super Admin',
                'username' => $credentials['username'],
                'role' => 'super_admin',
                'section_key' => null,
                'item_key' => null,
            ];

            $request->session()->regenerate();
            $request->session()->put('admin_authenticated', true);
            $request->session()->put('admin_user', $adminUser);

            return redirect()->intended(route('admin.index'));
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors(['username' => 'Username atau password admin tidak sesuai.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_authenticated');
        $request->session()->forget('admin_user');
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    private function databaseUser(array $credentials): ?array
    {
        try {
            $user = AdminUser::query()
                ->where('username', $credentials['username'])
                ->where('is_active', true)
                ->first();

            if (! $user || ! Hash::check($credentials['password'], $user->password_hash)) {
                return null;
            }

            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role,
                'section_key' => $user->section_key,
                'item_key' => $user->item_key,
            ];
        } catch (\Throwable) {
            return null;
        }
    }

    private function legacyCredentialsMatch(array $credentials): bool
    {
        $username = (string) env('ADMIN_USERNAME', 'admin');
        $password = (string) env('ADMIN_PASSWORD', '');

        return hash_equals($username, $credentials['username'])
            && $password !== ''
            && hash_equals($password, $credentials['password']);
    }

    private function landingUrl(?array $adminUser): string
    {
        if (($adminUser['role'] ?? null) !== 'member') {
            return route('admin.index');
        }

        $sectionKey = $adminUser['section_key'] ?? null;
        $itemKey = $adminUser['item_key'] ?? null;

        if (! $sectionKey || ! $itemKey) {
            return route('admin.index');
        }

        $segments = explode('/', $itemKey);

        return match (count($segments)) {
            1 => route('admin.item', [$sectionKey, $segments[0]]),
            2 => route('admin.nested.item', [$sectionKey, $segments[0], $segments[1]]),
            3 => route('admin.nested.leaf', [$sectionKey, $segments[0], $segments[1], $segments[2]]),
            default => route('admin.index'),
        };
    }
}
