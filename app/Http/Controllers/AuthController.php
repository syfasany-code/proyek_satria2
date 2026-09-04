<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function loginWarga()
    {
        return view('auth.login_warga');
    }

    public function authenticateWarga(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Username atau NIK wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        $warga = Warga::where('username', $credentials['login'])
            ->orWhere('nik', $credentials['login'])
            ->first();

        if (!$warga || !Hash::check($credentials['password'], $warga->password)) {
            return back()
                ->withInput($request->only('login', 'remember'))
                ->withErrors([
                    'login' => 'Username/NIK atau password salah.',
                ]);
        }

        if ($warga->status_warga !== 'Aktif') {
            return back()
                ->withInput($request->only('login', 'remember'))
                ->withErrors([
                    'login' => 'Akun warga sedang tidak aktif.',
                ]);
        }

        Auth::guard('warga')->login($warga, $remember);

        $request->session()->regenerate();

        return redirect()->route('warga.dashboard');
    }

    public function loginAdmin()
    {
        return view('auth.login_admin');
    }

    public function authenticateAdmin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username admin wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        $admin = Admin::where('username', $credentials['username'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return back()
                ->withInput($request->only('username', 'remember'))
                ->withErrors([
                    'username' => 'Username atau password admin salah.',
                ]);
        }

        Auth::guard('admin')->login($admin, $remember);

        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logoutWarga(Request $request)
    {
        Auth::guard('warga')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('warga.login');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function forgotWarga()
    {
        return view('auth.forgot_password_warga');
    }

    public function sendResetWarga(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $status = Password::broker('wargas')->sendResetLink(
            ['email' => $request->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Link reset password telah dikirim ke email Anda.'
            );
        }

        return back()->withErrors([
            'email' => 'Email tidak ditemukan dalam data warga.',
        ]);
    }

    public function resetWargaForm(string $token)
    {
        return view('auth.reset_password_warga', [
            'token' => $token,
            'email' => request('email'),
        ]);
    }

    public function resetWarga(Request $request)
    {
        $data = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $status = Password::broker('wargas')->reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $request->password_confirmation,
                'token' => $data['token'],
            ],
            function (Warga $warga, string $password) {
                $warga->password = Hash::make($password);
                $warga->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('warga.login')
                ->with('success', 'Password berhasil diubah. Silakan login kembali.');
        }

        return back()->withErrors([
            'email' => 'Link reset password tidak valid atau sudah kedaluwarsa.',
        ]);
    }

    public function forgotAdmin()
    {
        return view('auth.forgot_password_admin');
    }

    public function sendResetAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $status = Password::broker('admins')->sendResetLink(
            ['email' => $request->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with(
                'status',
                'Link reset password telah dikirim ke email admin.'
            );
        }

        return back()->withErrors([
            'email' => 'Email admin tidak ditemukan.',
        ]);
    }

    public function resetAdminForm(string $token)
    {
        return view('auth.reset_password_admin', [
            'token' => $token,
            'email' => request('email'),
        ]);
    }

    public function resetAdmin(Request $request)
    {
        $data = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $status = Password::broker('admins')->reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $request->password_confirmation,
                'token' => $data['token'],
            ],
            function (Admin $admin, string $password) {
                $admin->password = Hash::make($password);
                $admin->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('admin.login')
                ->with('success', 'Password admin berhasil diubah. Silakan login kembali.');
        }

        return back()->withErrors([
            'email' => 'Link reset password tidak valid atau sudah kedaluwarsa.',
        ]);
    }
}