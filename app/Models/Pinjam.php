<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;

    protected $fillable = ['buku_id'];

    public function transaksis()
    {
        return $this->belongsToMany(Transaksi::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
