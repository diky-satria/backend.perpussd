<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollapseResource extends JsonResource
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
            'petugas' => $this->petugas,
            'jumlah' => $this->pinjams()->count()
        ];
    }
}
