<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('video_path');
            $table->enum('allowed_role', [
    'todos',
    'admin',
    'financeiro',
    'rh',
    'fiscal',
    'comercial',
    'compras',
    'mkt',
    'vendas',
    'estoque',
    'caixa',
    'gerencia',
    'diretoria',
    'proprietario',
])->default('todos');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};