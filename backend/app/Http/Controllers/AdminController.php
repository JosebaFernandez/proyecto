<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //Funcion para guardar admins no se usa
    //Se usó una vez para insertar el admin

    /*
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'dni' => 'required|string|max:255|unique:users',
            'nombre' => 'required|string|max:255',
            'apellido1' => 'required|string|max:255',
            'apellido2' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $usuario = Admin::create([
            'nombre'=> $request->get('nombre'),
            'apellido1'=> $request->get('apellido1'),
            'apellido2'=> $request->get('apellido2'),
            'dni'=> $request->get('dni'),
            'email'=> 'jose@jose.com',
            'fecha_nacimiento'=> $request->get('fecha_nacimiento'),
            'password'=> bcrypt($request->get('password')),
        ]);

        return response()->json(['message' => 'Usuario creado','data'=>$usuario], 201);
    */
}
