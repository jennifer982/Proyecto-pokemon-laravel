<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_pokemons', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pokeapi_id')->unique();
            $table->string('nombre')->unique();
            $table->string('imagen');
            $table->string('imagen_shiny')->nullable();
            $table->decimal('altura', 5, 1);
            $table->decimal('peso', 5, 1);
            $table->unsignedSmallInteger('experiencia')->nullable();
            $table->json('tipos');
            $table->json('habilidades');
            $table->json('stats');
            $table->json('movimientos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_pokemons');
    }
};
