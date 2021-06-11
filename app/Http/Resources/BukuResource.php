<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
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
            'judul' => $this->judul,
            'pengarang' => $this->pengarang,
            'penerbit' => $this->penerbit,
            'tahun' => $this->tahun,
            'isbn' => $this->isbn,
            'jumlah' => $this->jumlah,
            'gambar' => $this->gambar,
            'lokasi' => $this->lokasi->nama,
            'lokasi_id' => $this->lokasi->id
        ];
    }
}
