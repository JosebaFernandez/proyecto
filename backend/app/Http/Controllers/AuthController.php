<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'dni' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = $request->only('dni', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['user' => Auth::guard('admin')->user(), 'role' => 'admin']);
        }

        if (Auth::guard('web')->attempt($credentials)) {
            return response()->json(['user' => Auth::guard('web')->user(), 'role' => 'user']);
        }

        return response()->json(['error' => 'DNI o contraseña incorrectos'], 401);
    }


}

