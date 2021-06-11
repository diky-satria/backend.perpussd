<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::orderBy('id', 'ASC')->get();
        return $lokasi;
    }
}
