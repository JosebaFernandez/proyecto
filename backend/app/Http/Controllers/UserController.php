<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'required|string|max:255',
            'dni' => 'required|string|max:255|unique:users',
            'fecha_nacimiento' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $usuario = User::create([
            'nombre'=> $request->get('nombre'),
            'apellido1'=> $request->get('apellido1'),
            'apellido2'=> $request->get('apellido2'),
            'dni'=> $request->get('dni'),
            'fecha_nacimiento'=> $request->get('fecha_nacimiento'),
        ]);

        return response()->json(['message' => 'Usuario creado','data'=>$usuario], 201);
    }

    public function show($id) {
        $usuario = User::findOrFail($id);
        return response()->json(['message' => 'Usuario encontrado','data'=>$usuario], 201);
    }

    public function index() {
        $usuarios = User::all();
        return response()->json(['message' => 'Usuarios encontrados','data'=>$usuarios], 201);
    }
}
