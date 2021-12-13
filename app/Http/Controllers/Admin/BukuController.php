<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buku;
use App\Models\Lokasi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::orderBy('id', 'DESC')->get();
        return BukuResource::collection($buku);
    }

    public function show(Buku $buku)
    {
        $lokasi = Lokasi::orderBy('id', 'ASC')->get();
        return response()->json([
            'lokasi' => $lokasi,
            'data' => new BukuResource($buku)
        ]);
    }

    public function store()
    {
        request()->validate([
            'kode' => 'required|unique:bukus,kode',
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required|numeric',
            'isbn' => 'required',
            'jumlah' => 'required|numeric',
            'lokasi_id' => 'required',
            'gambar' => 'required|mimes:jpg,png,jpeg,gif|max:2048'
        ],[
            'kode.required' => 'Kode harus di isi',
            'kode.unique' => 'Kode sudah terdaftar',
            'judul.required' => 'Judul harus di isi',
            'pengarang.required' => 'Pengarang harus di isi',
            'penerbit.required' => 'Penerbit harus di isi',
            'tahun.required' => 'Tahun harus di isi',
            'tahun.numeric' => 'Format harus angka',
            'isbn.required' => 'ISBN harus di isi',
            'jumlah.required' => 'Jumlah harus di isi',
            'jumlah.numeric' => 'Format harus angka',
            'lokasi_id.required' => 'Lokasi harus dipilih',
            'gambar.required' => 'Gambar harus di isi',
            'gambar.mimes' => 'Format file harus jpg/jpeg/png/gif',
            'gambar.max' => 'Ukuran gambar maximal 2 MB'
        ]);
            
        //id terakhir
        $id = Buku::max('id') + 1;
        
        //upload gambar
        $filename = request()->file('gambar')->getClientOriginalName();
        request()->file('gambar')->storeAs('buku', $id.$filename);

        Buku::create([
            'kode' => strtoupper(request('kode')),
            'judul' => ucwords(request('judul')),
            'pengarang' => ucwords(request('pengarang')),
            'penerbit' => ucwords(request('penerbit')),
            'tahun' => request('tahun'),
            'isbn' => request('isbn'),
            'jumlah' => request('jumlah'),
            'lokasi_id' => request('lokasi_id'),
            'gambar' => $id . $filename
        ]);

        return response()->json([
            'message' => 'buku berhasil ditambahkan'
        ]);
    }

    public function edit(Buku $buku)
    {
        request()->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required|numeric',
            'isbn' => 'required',
            'jumlah' => 'required|numeric'
        ],[
            'judul.required' => 'Judul harus di isi',
            'pengarang.required' => 'Pengarang harus di isi',
            'penerbit.required' => 'Penerbit harus di isi',
            'tahun.required' => 'Tahun harus di isi',
            'tahun.numeric' => 'Format harus angka',
            'isbn.required' => 'ISBN harus di isi',
            'jumlah.required' => 'Jumlah harus di isi',
            'jumlah.numeric' => 'Format harus angka'
        ]);

        $gambar = request()->file('gambar');

        if($gambar){
            request()->validate([
                'gambar' => 'mimes:jpg,png,jpeg,gif|max:2048'
            ],[
                'gambar.mimes' => 'Format file harus jpg/jpeg/png/gif',
                'gambar.max' => 'Ukuran gambar maximal 2 MB'
            ]);
            $gambar_lama = $buku->gambar;
            if($gambar_lama){
                Storage::delete('buku/' . $gambar_lama);
            }

            $str = Str::random(6);
            request()->file('gambar')->storeAs('buku', $str . $gambar->getClientOriginalName());
            $buku->update([
                'judul' => ucwords(request('judul')),
                'pengarang' => ucwords(request('pengarang')),
                'penerbit' => ucwords(request('penerbit')),
                'tahun' => request('tahun'),
                'isbn' => request('isbn'),
                'jumlah' => request('jumlah'),
                'lokasi_id' => request('lokasi_id'),
                'gambar' => $str . request('gambar')->getClientOriginalName()
            ]);
        }else{
            $buku->update([
                'judul' => ucwords(request('judul')),
                'pengarang' => ucwords(request('pengarang')),
                'penerbit' => ucwords(request('penerbit')),
                'tahun' => request('tahun'),
                'isbn' => request('isbn'),
                'jumlah' => request('jumlah'),
                'lokasi_id' => request('lokasi_id')
            ]);
        }

        return response()->json([
            'message' => 'Buku berhasil diedit'
        ]);
    }

    public function delete(Buku $buku)
    {
        $gambar_lama = $buku->gambar;
        if($gambar_lama){
            Storage::delete('buku/' . $gambar_lama);
        }

        $buku->delete();

        return response()->json([
            'message' => 'buku berhasil dihapus'
        ]);
    }
}
