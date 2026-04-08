<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notices', function (Blueprint $table) {
            // Adicionar default ou fazer nullable
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Reverter se necessário
    }
};