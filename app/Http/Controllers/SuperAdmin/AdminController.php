<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\Buku;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function count()
    {
        $mahasiswa = Mahasiswa::all()->count();
        $buku = Buku::all()->count();
        $transaksi = Transaksi::where('status', 0)->count();

        return response()->json([
            'message' => 'hitung data',
            'mahasiswa' => $mahasiswa,
            'buku' => $buku,
            'transaksi' => $transaksi
        ]);
    }

    public function index(){
        $user = User::where('role', 'admin')->orderBy('id', 'DESC')->get();
        return response()->json([
            'user' => $user
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email'
        ],[
            'nama.required' => 'Nama harus di isi',
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar'
        ]);

        $user = User::create([
            'nama' => ucwords(request('nama')),
            'email' => request('email'),
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        return response()->json([
            'message' => 'admin berhasil ditambahkan',
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'admin berhasil dihapus'
        ]);
    }
}
