<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('matricule')->unique();
            $table->string('nom');
            $table->string('prenoms');
            $table->enum('filiere', ['IA', 'GL', 'SI', 'IM', 'SEIOT']);
            $table->string('email')->unique();
            $table->unsignedTinyInteger('semestre_actuel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
