<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'kode' => $this->kode,
            'tgl_peminjaman' => $this->tgl_peminjaman,
            'tgl_pengembalian' => $this->tgl_pengembalian,
            'mahasiswa_id' => $this->mahasiswa_id,
            'nama' => $this->mahasiswa->nama,
            'nim' => $this->mahasiswa->nim,
            'jurusan' => $this->mahasiswa->jurusan->nama_jurusan,
            'semester' => $this->mahasiswa->semester->semester,
            'kelas' => $this->mahasiswa->kelas->kelas,
            'status' => $this->status,
            'jumlah' => $this->jumlah,
            'petugas' => $this->petugas
        ];
    }
}
