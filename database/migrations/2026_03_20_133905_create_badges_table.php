<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Ex.: "Mestre de Vendas"
            $table->string('description');  // "Completou 5 cursos de vendas"
            $table->string('icon');  // URL do ícone (ex.: 'badges/vendas.png')
            $table->string('type');  // 'bronze', 'silver', 'gold' ou 'role_specific'
            $table->integer('required_completions')->default(1);  // Nº de cursos para desbloquear
            $table->timestamps();
        });

        Schema::create('user_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');
            $table->timestamp('unlocked_at');
            $table->unique(['user_id', 'badge_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_badges');
        Schema::dropIfExists('badges');
    }
};