<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        abort_unless($admin, 403);

        return view('admin.profil', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        abort_unless($admin, 403);

        $data = $request->validate([
            'nama_admin' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,' . $admin->id_admin . ',id_admin'],
            'no_hp' => ['required', 'string', 'max:20'],
        ]);

        Admin::where('id_admin', $admin->id_admin)->update($data);

        return back()->with('success', 'Profil admin berhasil diperbarui.');
    }

    public function password(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Auth::guard('admin')->user();

        abort_unless($admin, 403);

        if (!Hash::check($data['current_password'], $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.',
            ]);
        }

        Admin::where('id_admin', $admin->id_admin)->update([
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Password admin berhasil diubah.');
    }
}
