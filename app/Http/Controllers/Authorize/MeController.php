<?php

namespace App\Http\Controllers\Authorize;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MahasiswaResource;
use Illuminate\Support\Facades\Auth;
use App\models\User;

class MeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return $request->user();
    }

    public function meUser()
    {
        $mahasiswa = Mahasiswa::where('email', Auth::user()->email)->first();
        if($mahasiswa){
            return response()->json([
                'mahasiswa' => new MahasiswaResource($mahasiswa)
            ]);
        }else{
            return response()->json([
                'mahasiswa' => ''
            ]);
        }
    }

    public function lihat()
    {
        $user = User::orderBy('id', 'ASC')->get();
        return $user;
    }
}
