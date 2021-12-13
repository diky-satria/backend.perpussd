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
            'nis' => $this->nis,
            'nama' => $this->nama,
            'kelas' => $this->kelas->kelas,
            'kelas_id' => $this->kelas_id,
            'gambar' => $this->gambar,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat
        ];
    }
}
