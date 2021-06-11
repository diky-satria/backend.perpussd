<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        request()->validate([
	        'email' => 'required|email',
	        'password' => 'required|min:6',
	    ],[
	    	'email.required' => 'Email harus di isi',
	    	'email.email' => 'Email tidak valid',
	    	'password.required' => 'Password harus di isi',
	    	'password.min' => 'Password minimal 6 karakter'
		]);

        if(Auth::attempt($request->only('email','password'))){  
            return response()->json(Auth::user(), 200); 
        }

        throw ValidationException::withMessages([
			'invalid' => ['Email dan password tidak sesuai']
		]);
    }

    public function logout(){
        Auth::logout();
    }
}
