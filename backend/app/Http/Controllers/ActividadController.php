<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActividadController extends Controller
{


    public function store(Request $request) {
        // 📌 Validar los datos incluyendo la imagen
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'lugar' => 'required|string|max:255',
            'edad' => 'required|string|max:255',
            'fecha' => 'required|date|after_or_equal:today',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif' // Solo imágenes hasta 2MB
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // 📌 Subir imagen si existe
        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('imagenes', 'public'); // Guarda en storage/app/public/imagenes
        }

        // 📌 Crear la actividad con la imagen
        $actividad = Actividad::create([
            'titulo' => $request->get('titulo'),
            'descripcion' => $request->get('descripcion'),
            'lugar' => $request->get('lugar'),
            'edad' => $request->get('edad'),
            'fecha' => $request->get('fecha'),
            'imagen' => $imagePath // Guardamos la ruta de la imagen
        ]);

        return response()->json($actividad, 201);
    }


    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'lugar' => 'required|string|max:255',
            'edad' => 'required|string|max:255',
            'fecha' => 'required|date|after_or_equal:today'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $actividad = Actividad::findOrFail($id);

        $actividad -> update([
            'titulo' => $request->get('titulo'),
            'descripcion' => $request->get('descripcion'),
            'lugar' => $request->get('lugar'),
            'edad' => $request->get('edad'),
            'fecha' => $request->get('fecha')
        ]);
        return response()->json($actividad, 200);
    }

    public function destroy($id) {
        $actividad = Actividad::findOrFail($id);
        $actividad -> delete();
        return response()->json(['message'=>'Actividad borrada exitosamente'], 204);
    }

    public function show($id) {
        $actividad = Actividad::findOrFail($id);
        return response()->json($actividad, 200);
    }

    public function index(Request $request) {
        $query = Actividad::query();

        // Filtro por fecha
        if ($request->filled('fInicio') && $request->filled('fFin')) {
            $query->whereBetween('fecha', [$request->fInicio, $request->fFin]);
        }

        // Filtro por lugar
        if ($request->filled('lugar')) {
            $query->where('lugar', $request->lugar);
        }

        // Filtro por idioma
        if ($request->filled('idioma')) {
            $query->where('idioma', $request->idioma);
        }

        // Filtros por edad
        if ($request->filled('edad_maxima')) { // Cambiado de edadMax a edad_maxima
            $query->where('edad_maxima', '>=', $request->edad_maxima);
        }
        if ($request->filled('edad_minima')) { // Cambiado de edadMin a edad_minima
            $query->where('edad_minima', '<=', $request->edad_minima);
        }

        // Filtro por hora
        if ($request->filled('hInicio') && $request->filled('hFin')) {
            $query->whereBetween('hora', [$request->hInicio, $request->hFin]);
        }

        return response()->json($query->get(), 200);
    }



    public function asignarActividades(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        // Validar que los IDs de las actividades sean válidos
        $request->validate([
            'actividades' => 'required|array',
            'actividades.*' => 'exists:actividades,id', // Asegura que cada ID de actividad existe
        ]);

        // Obtener el usuario por su ID
        $user = User::find($id);

        // Si el usuario no existe, retornar un error 404
        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        // Asignar las actividades al usuario utilizando la tabla intermedia
        $user->actividades()->attach($request->actividades);

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Actividades asignadas correctamente'], 200);
    }

}
