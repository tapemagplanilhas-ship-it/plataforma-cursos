<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run()
    {
        Badge::create([
            'name' => 'Iniciante',
            'description' => 'Completou o primeiro curso',
            'icon' => 'badges/iniciante.png',
            'type' => 'bronze',
            'required_completions' => 1
        ]);

        Badge::create([
            'name' => 'Mestre de Vendas',
            'description' => 'Completou 5 cursos de vendas',
            'icon' => 'badges/vendas.png',
            'type' => 'gold',
            'required_completions' => 5
        ]);

        // Adicione mais para RH, Estoque, etc.
    }
}