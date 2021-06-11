<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::orderBy('id', 'DESC')->get();
        return $jurusan;
    }

    public function store()
    {
        request()->validate([
            'nama_jurusan' => 'required|unique:jurusans,nama_jurusan'
        ],[
            'nama_jurusan.required' => 'Jurusan harus di isi',
            'nama_jurusan.unique' => 'Jurusan sudah terdaftar'
        ]);

        $jurusan = Jurusan::create([
            'nama_jurusan' => ucwords(request('nama_jurusan'))
        ]);

        return response()->json([
            'message' => 'berhasil menambahakan jurusan',
            'jurusan' => $jurusan
        ]);
    }

    public function delete(Jurusan $jurusan)
    {
        $jurusan->delete();

        return response()->json([
            'message' => 'berhasil menghapus jurusan'
        ]);
    }
}
