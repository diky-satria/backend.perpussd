<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PeminjamanResource extends JsonResource
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
            'buku_id' => $this->buku_id,
            'judul' => $this->buku->judul,
            'kode_buku' => $this->buku->kode,
            'lokasi' => $this->buku->lokasi->nama
        ];
    }
}
