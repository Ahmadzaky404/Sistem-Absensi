<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::check() && Auth::user()->role === 'direktur_utama') {
            return redirect()->route('dirut.dashboard');
        }

        if (Auth::check() && Auth::user()->role === 'direktur') {
            return redirect()->route('direktur.dashboard');
        }

        if (Auth::check() && in_array(Auth::user()->role, ['karyawan', 'office_boy'], true)) {
            return redirect()->route(Auth::user()->role === 'office_boy' ? 'office-boy.dashboard' : 'karyawan.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->merge([
            'username' => trim((string) $request->input('username')),
        ]);

        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return match (Auth::user()->role) {
                'direktur_utama' => redirect()->intended(route('dirut.dashboard')),
                'direktur' => redirect()->intended(route('direktur.dashboard')),
                'office_boy' => redirect()->intended(route('office-boy.dashboard')),
                'karyawan' => redirect()->intended(route('karyawan.dashboard')),
                default => redirect()->intended(route('admin.dashboard')),
            };
        }

        return back()
            ->withInput($request->only('username'))
            ->with('login_error', 'Username atau password salah.');
    }

    public function showKaryawanLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'direktur') {
            return redirect()->route('direktur.dashboard');
        }

        if (Auth::check() && in_array(Auth::user()->role, ['karyawan', 'office_boy'], true)) {
            return redirect()->route(Auth::user()->role === 'office_boy' ? 'office-boy.dashboard' : 'karyawan.dashboard');
        }

        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.karyawan-login');
    }

    public function loginKaryawan(Request $request): RedirectResponse
    {
        $request->merge([
            'username' => trim((string) $request->input('username')),
        ]);

        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            if (! in_array(Auth::user()->role, ['karyawan', 'office_boy'], true)) {
                Auth::logout();

                return back()
                    ->withInput($request->only('username'))
                    ->with('login_error', 'Username atau password salah.');
            }

            $request->session()->regenerate();

            return redirect()->intended(route(Auth::user()->role === 'office_boy' ? 'office-boy.dashboard' : 'karyawan.dashboard'));
        }

        return back()
            ->withInput($request->only('username'))
            ->with('login_error', 'Username atau password salah.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $loginRoute = in_array(Auth::user()?->role, ['karyawan', 'office_boy'], true) ? 'karyawan.login' : 'login';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($loginRoute)->with('logout_success', 'Logout berhasil.');
    }
}
