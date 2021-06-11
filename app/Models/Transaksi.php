<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['mahasiswa_id','kode','tgl_peminjaman','tgl_pengembalian','jumlah','status','petugas'];

    public function pinjams()
    {
        return $this->belongsToMany(Pinjam::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}
