<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
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
            'nim' => $this->nim,
            'nama' => $this->nama,
            'email' => $this->email,
            'jurusan' => $this->jurusan->nama_jurusan,
            'semester' => $this->semester->semester,
            'kelas' => $this->kelas->kelas,
            'jurusan_id' => $this->jurusan_id,
            'semester_id' => $this->semester_id,
            'kelas_id' => $this->kelas_id,
            'gambar' => $this->gambar
        ];
    }
}
