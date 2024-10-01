<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Obtener todas las notas (GET /api/notes)
Route::get('notes', [NoteController::class, 'index']);

// Crear una nueva nota (POST /api/notes)
Route::post('notes', [NoteController::class, 'store']);

// Obtener una nota específica (GET /api/notes/{note})
Route::get('notes/{note}', [NoteController::class, 'show']);

// Actualizar una nota existente (PUT /api/notes/{note})
Route::put('notes/{note}', [NoteController::class, 'update']);

// Eliminar una nota (DELETE /api/notes/{note})
Route::delete('notes/{note}', [NoteController::class, 'destroy']);
