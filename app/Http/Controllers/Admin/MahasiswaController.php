<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Semester;
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
        $jurusan = Jurusan::orderBy('nama_jurusan', 'ASC')->get();
        $semester = Semester::orderBy('id', 'ASC')->get();
        $kelas = Kelas::orderBy('id', 'ASC')->get();
        return response()->json([
            'data' => new MahasiswaResource($mahasiswa),
            'jurusan' => $jurusan,
            'semester' => $semester,
            'kelas' => $kelas
        ]); 
    }

    public function store()
    {
        request()->validate([
            'nim' => 'required|unique:mahasiswas,nim',
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'jurusan_id' => 'required',
            'semester_id' => 'required',
            'kelas_id' => 'required',
            // 'gambar' => 'required|mimes:jpg,png,jpeg,gif|max:2048'
        ],[
            'nim.required' => 'NIM harus di isi',
            'nim.unique' => 'NIM sudah terdaftar',
            'nama.required' => 'Nama harus di isi', 
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'jurusan_id.required' => 'Jurusan harus dipilih',
            'semester_id.required' => 'Semester harus dipilih',
            'kelas_id.required' => 'Kelas harus dipilih'
        ]);

        // $filename = request()->file('gambar')->getClientOriginalName();
        // request()->file('gambar')->storeAs('mahasiswa', $filename);

        Mahasiswa::create([
            'jurusan_id' => request('jurusan_id'),
            'semester_id' => request('semester_id'),
            'kelas_id' => request('kelas_id'),
            'nim' => strtoupper(request('nim')),
            'nama' => ucwords(request('nama')),
            'email' => request('email'),
            'gambar' => 'user-prof.png'
        ]);

        User::create([
            'email' => request('email'),
            'nama' => strtoupper(request('nama')),
            'password' => bcrypt('password'),
            'role' => 'user'
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
            'jurusan_id' => request('jurusan_id'),
            'semester_id' => request('semester_id'),
            'kelas_id' => request('kelas_id')
        ]);

        //update user
        $user = User::where('email', $mahasiswa->email)->first();
        $user->update([
            'nama' => ucwords(request('nama'))
        ]);

        return response()->json([
            'message' => 'mahasiswa berhasil diedit'
        ]);
    }

    public function delete(Mahasiswa $mahasiswa)
    {
        //hapus mahasiswa
        $mahasiswa->delete();

        //hapus user
        $user = User::where('email', $mahasiswa->email)->first();
        $user->delete();

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
