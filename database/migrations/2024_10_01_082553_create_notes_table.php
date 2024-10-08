<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('user'); // Relación con el id de la tabla users
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade'); // Definir la clave foránea
            $table->string('tags'); // Puedes usar JSON si quieres múltiples etiquetas
            $table->date('due_date'); // Fecha de vencimiento
            $table->string('image_path')->nullable(); // Hacer que image_path sea nullable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }

}
