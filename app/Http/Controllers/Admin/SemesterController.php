<?php

namespace App\Http\Controllers\Admin;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SemesterController extends Controller
{
    public function index()
    {
        $semester = Semester::orderBy('semester', 'ASC')->get();
        return $semester;
    }
}
