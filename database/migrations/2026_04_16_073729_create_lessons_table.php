<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            // Relacionamento: Esta aula pertence a qual curso?
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            
            $table->string('title'); // Ex: "Aula 01 - Introdução"
            $table->text('description')->nullable();
            $table->string('video_path'); // O caminho do vídeo
            $table->integer('order')->default(0); // Para ordenar a playlist (1, 2, 3...)
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};