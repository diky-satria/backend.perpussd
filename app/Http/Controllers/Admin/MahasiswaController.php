<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MahasiswaResource;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::orderBy('id', 'DESC')->get();
        return MahasiswaResource::collection($mahasiswa);
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $kelas = Kelas::orderBy('id', 'ASC')->get();
        return response()->json([
            'data' => new MahasiswaResource($mahasiswa),
            'kelas' => $kelas
        ]); 
    }

    public function store() 
    {
        request()->validate([
            'nis' => 'required|unique:mahasiswas,nis',
            'nama' => 'required',
            'kelas_id' => 'required',
            // 'gambar' => 'required|mimes:jpg,png,jpeg,gif|max:2048'
        ],[
            'nis.required' => 'NIS harus di isi',
            'nis.unique' => 'NIS sudah terdaftar',
            'nama.required' => 'Nama harus di isi', 
            'kelas_id.required' => 'Kelas harus dipilih'
        ]);

        // $filename = request()->file('gambar')->getClientOriginalName();
        // request()->file('gambar')->storeAs('mahasiswa', $filename);

        Mahasiswa::create([
            'kelas_id' => request('kelas_id'),
            'nis' => strtoupper(request('nis')),
            'nama' => ucwords(request('nama')),
            'telepon' => request('telepon'),
            'alamat' => request('alamat'),
            'gambar' => 'user-prof.png'
        ]);
        
        return response()->json([
            'message' => 'mahasiswa berhasil ditambahkan'
        ]);
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        request()->validate([
            'nama' => 'required'
        ],[
            'nama.required' => 'Nama harus di isi'
        ]);

        //update mahasiswa
        $mahasiswa->update([
            'nama' => ucwords(request('nama')),
            'kelas_id' => request('kelas_id'),
            'telepon' => request('telepon'),
            'alamat' => request('alamat')
        ]);

        return response()->json([
            'message' => 'mahasiswa berhasil diedit'
        ]);
    }

    public function delete(Mahasiswa $mahasiswa)
    {
        //hapus mahasiswa
        $mahasiswa->delete();

        return response()->json([
            'message' => 'mahasiswa dan user berhasil dihapus'
        ]);
    }

    public function ubahProfil()
    {
        $mahasiswa = Mahasiswa::where('email', Auth::user()->email)->first();
        $max = Mahasiswa::max('id') + 1;
        $gambar_lama = $mahasiswa->gambar;
        if($gambar_lama != 'user-prof.png'){
            Storage::delete('mahasiswa/' . $gambar_lama);
        }
        $filename = request()->file('gambar')->getClientOriginalName();
        request()->file('gambar')->storeAs('mahasiswa', $max . $filename);

        $mahasiswa->update([
            'gambar' => $max . $filename
        ]);

        return response()->json([
            'message' => 'profil berhasil diubah'
        ]);
    }

    public function ubahPassword(User $user)
    {
        request()->validate([
            'password' => 'required|min:6',
            'konfirmasi_password' => 'same:password'
        ],[
            'password.required' => 'Password harus di isi',
            'password.min' => 'Password min 6 karakter',
            'konfirmasi_password.same' => 'Konfirmasi password salah'
        ]);

        $user->update([
            'password' => bcrypt(request('password'))
        ]);

        return response()->json([
            'message' => 'password berhasil diubah'
        ]);
    }
}
