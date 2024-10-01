<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class NoteController extends Controller
{


    public function index()
    {
        // Devuelve solo las notas del usuario autenticado
        return response()->json(Note::where('user_id', auth()->user()->id)->get(), 200);
    }

    public function store(Request $request)
    {
        // Validación de datos (ajusta las reglas según tus necesidades)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user' => 'required|string',
            'tags' => 'nullable|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de la imagen
        ]);

        $note = new Note(); // Suponiendo que tu modelo se llama Note

        // Asignar valores a las propiedades
        $note->title = $request->title;
        $note->description = $request->description;
        $note->user = auth()->user()->id;
        $note->tags = $request->tags;
        $note->due_date = $request->due_date;

        // Manejar la carga de la imagen
        if ($request->hasFile('image')) {
            // Guardar la imagen y almacenar la ruta correcta
            $imagePath = $request->file('image')->store('images', 'public');
            $note->image_path = $imagePath; // Guarda la ruta completa de la imagen
        }

        // Guardar la nota en la base de datos
        $note->save();

        return response()->json($note, 201); // Devuelve la nota creada
    }

    public function show(Note $note)
    {
        // Devolver la nota específica en formato JSON
        return response()->json($note, 200);
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user' => 'required|string',
            'tags' => 'nullable|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'El título es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'user.required' => 'El usuario es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif.',
            'image.max' => 'La imagen no debe pesar más de 2MB.',
        ]);

        $note = Note::findOrFail($id);

        // Asignar valores
        $note->title = $request->title;
        $note->description = $request->description;
        $note->user = $request->user;
        $note->tags = $request->tags;
        $note->due_date = $request->due_date;

        // Manejar la carga de la imagen
        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($note->image_path) {
                $oldImagePath = 'public/' . $note->image_path; // Asegúrate de que esta ruta sea correcta
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }

            // Guardar la nueva imagen
            $imagePath = $request->file('image')->store('images', 'public');
            $note->image_path = $imagePath; // Almacena la ruta completa
        }

        // Guardar la nota actualizada
        $note->save();

        return response()->json($note, 200);
    }

    public function destroy(Note $note)
    {
        // Eliminar la imagen asociada
        if ($note->image_path) {
            $imagePath = 'public/' . $note->image_path; // Ruta completa para eliminar
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        // Eliminar la nota
        try {
            $note->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar la nota'], 500);
        }

        return response()->json(['message' => 'Nota eliminada correctamente'], 204);
    }
}
