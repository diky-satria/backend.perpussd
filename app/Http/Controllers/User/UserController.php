<?php

namespace App\Http\Controllers\User;

use App\Models\Mahasiswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Resources\PeminjamanResource;
use App\Http\Resources\TransaksiResource;

class UserController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $mhs = Mahasiswa::where('email', Auth::user()->email)->first();
        $pjmHariIni = Transaksi::where('mahasiswa_id', $mhs->id)
                            ->where('status', '!=', 0)
                            ->whereDate('tgl_peminjaman', [now()])
                            ->count();
        $totalTransPinjam = Transaksi::where('mahasiswa_id', $mhs->id)
                                    ->where('status', 1)
                                    ->count();
        $totalJumBuk = Transaksi::where('mahasiswa_id', $mhs->id)
                        ->where('status', 1)
                        ->sum('jumlah');
        $riwayat = Transaksi::where('mahasiswa_id', $mhs->id)
                            ->where('status', '!=', 0)
                            ->orderBy('id', 'DESC')
                            ->get();

        return response()->json([
            'pjmHariIni' => $pjmHariIni,
            'totalTransPinjam' => $totalTransPinjam,
            'totalJumBuk' => $totalJumBuk,
            'riwayat' => TransaksiResource::collection($riwayat)
        ]);
    }

    public function riwayat(Transaksi $transaksi)
    {
        if(Auth::user()->email !== $transaksi->mahasiswa->email){
            abort(403, 'Forbidden');
        }
        $pinjam = $transaksi->pinjams()->get();

        return response()->json([
            'transaksi' => new TransaksiResource($transaksi),
            'pinjam' => PeminjamanResource::collection($pinjam)
        ]);
    }
}
