<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WargaProfileController extends Controller
{
    public function index()
    {
        $warga = Auth::guard('warga')->user();

        abort_unless($warga, 403);

        return view('warga.profil', compact('warga'));
    }

    public function update(Request $request)
    {
        $warga = Auth::guard('warga')->user();

        abort_unless($warga, 403);

        $data = $request->validate([
            'nama_warga' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:wargas,email,' . $warga->id_warga . ',id_warga'],
            'no_hp' => ['required', 'string', 'max:25'],
            'alamat' => ['required', 'string'],
        ]);

        Warga::where('id_warga', $warga->id_warga)->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function password(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $warga = Auth::guard('warga')->user();

        abort_unless($warga, 403);

        if (!Hash::check($data['current_password'], $warga->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.',
            ]);
        }

        Warga::where('id_warga', $warga->id_warga)->update([
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
