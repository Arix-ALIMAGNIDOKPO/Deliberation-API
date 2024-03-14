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
        Schema::create('u_e_s', function (Blueprint $table) {
            $table->id();
            $table->integer('semestre');
            $table->string('code_UE')->unique();
            $table->integer('credit');
            $table->string('intitulé');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_e_s');
    }
};
