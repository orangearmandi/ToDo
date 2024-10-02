<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    public function index($id)
    {
        // Obtener las notas del usuario con el ID proporcionado
        $notes = Note::where('user', $id)->get();

        if ($notes->isEmpty()) {
            return response()->json(['message' => 'No se encontraron notas para este usuario.'], 404);
        }

        return response()->json($notes, 200); // Devolver las notas en formato JSON
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'user' => 'required|string',
            'tags' => 'nullable|string',
            'due_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $note = new Note();

        // Asignar valores a las propiedades
        $note->title = $request->title;
        $note->description = $request->description;
        $note->user = $request->user;
        $note->tags = $request->tags;
        $note->due_date = $request->due_date;

        // Manejar la carga de la imagen
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $note->image_path = $imagePath;
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

        'tags' => 'nullable|string',
        'due_date' => 'nullable|date',
    ], [
        'title.required' => 'El título es obligatorio.',
        'description.required' => 'La descripción es obligatoria.',

    ]);

    $note = Note::findOrFail($id);

    // Asignar valores
    $note->title = $request->title;
    $note->description = $request->description;
    $note->user = $request->user;
    $note->tags = $request->tags;
    $note->due_date = $request->due_date;

    // Guardar la nota actualizada
    $note->save();

    return response()->json($note, 200);
}

    public function destroy($id)
    {
        // Encontrar la nota
        $note = Note::findOrFail($id);

        // Eliminar la imagen asociada
        if ($note->image_path) {
            $imagePath = 'public/' . $note->image_path;
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
