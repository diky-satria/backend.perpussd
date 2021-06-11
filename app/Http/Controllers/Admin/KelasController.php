<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::orderBy('id', 'ASC')->get();
        return $kelas;
    }
}
