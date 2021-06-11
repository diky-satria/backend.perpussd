<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buku;
use App\Models\Pinjam;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollapseResource;
use App\Http\Resources\TransaksiResource;
use App\Http\Resources\PeminjamanResource;

class CollapseController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('status', 0)->orderBy('id', 'DESC')->get();
        return CollapseResource::collection($transaksi);
    }

    public function show(Transaksi $transaksi)
    {
        $detail = $transaksi->pinjams()->get();
        return response()->json([
            'detail' => PeminjamanResource::collection($detail),
            'transaksi' => new CollapseResource($transaksi)
        ]);
    }

    public function delete(Transaksi $transaksi, $detail_id, $buku_id)
    {
        $buku = Buku::where('id', $buku_id)->first();
        $buku->update([
            'jumlah' => $buku->jumlah + 1
            ]);
        
        $pinjam = Pinjam::where('id', $detail_id)->first();
        $pinjam->delete();
        $transaksi->pinjams()->detach($detail_id);

        return response()->json([
            'message' => 'buku berhasil dikembalikan, '
        ]);
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return response()->json([
            'message' => 'transaksi berhasil dihapus'
        ]);
    }
}
