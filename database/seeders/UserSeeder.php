<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            // SUPORTE / ADMIN
            ['name' => 'Sup',            'email' => 'suporte@tapemag.com.br',        'role' => 'admin'],
            ['name' => 'Victor',         'email' => 'victor.araujo@tapemag.com.br',  'role' => 'admin'],

            // FINANCEIRO
            ['name' => 'Luciana',        'email' => 'financeiro@tapemag.com.br',     'role' => 'financeiro'],
            ['name' => 'Luana',          'email' => 'financeiro@tapemag.com.br',     'role' => 'financeiro'],
            ['name' => 'Ketonny',        'email' => 'financeiro@tapemag.com.br',     'role' => 'caixa'],
            ['name' => 'Larissa',        'email' => 'financeiro@tapemag.com.br',     'role' => 'caixa'],

            // RH
            ['name' => 'Beatriz',        'email' => 'beatriz.veras@tapemag.com.br',  'role' => 'rh'],
            ['name' => 'Recrutamento',   'email' => 'recrutamento@tapemag.com.br',   'role' => 'rh'],

            // FISCAL
            ['name' => 'Carlos',         'email' => 'carlos.oliveira@tapemag.com.br','role' => 'fiscal'],

            // COMERCIAL
            ['name' => 'Cesar Antunes',  'email' => 'cesar.antunes@tapemag.com.br',  'role' => 'comercial'],
            ['name' => 'Gabriele',       'email' => 'gabriele.pires@tapemag.com.br', 'role' => 'comercial'],

            // COMPRAS
            ['name' => 'Cesar Oliveira', 'email' => 'cesar.oliveira@tapemag.com.br', 'role' => 'compras'],
            ['name' => 'Fernando',       'email' => 'compras@tapemag.com.br',        'role' => 'compras'],

            // MKT
            ['name' => 'Tiago',          'email' => 'contato@tapemag.com.br',        'role' => 'mkt'],

            // VENDAS
            ['name' => 'Elisandro',      'email' => 'elisandro@tapemag.com.br',      'role' => 'vendas'],
            ['name' => 'Eliseu',         'email' => 'eliseu@tapemag.com.br',         'role' => 'vendas'],
            ['name' => 'David',          'email' => 'vendas@tapemag.com.br',         'role' => 'vendas'],
            ['name' => 'Douglas',        'email' => 'vendas3@tapemag.com.br',        'role' => 'vendas'],
            ['name' => 'Rafael Vendas',  'email' => 'vendas4@tapemag.com.br',        'role' => 'vendas'],
            ['name' => 'Tiago Henrique', 'email' => 'vendas5@tapemag.com.br',        'role' => 'vendas'],
            ['name' => 'Matheus',        'email' => 'vendas7@tapemag.com.br',        'role' => 'vendas'],
            ['name' => 'Celso',          'email' => 'vendas8@tapemag.com.br',        'role' => 'vendas'],
            ['name' => 'Leonardo',       'email' => 'vendas9@tapemag.com.br',        'role' => 'vendas'],
            ['name' => 'Nicolly',        'email' => 'vendas10@tapemag.com.br',       'role' => 'vendas'],
            ['name' => 'Juan',           'email' => 'vendas11@tapemag.com.br',       'role' => 'vendas'],
            ['name' => 'Julia',          'email' => 'vendas12@tapemag.com.br',       'role' => 'vendas'],

            // ESTOQUE
            ['name' => 'Estoque',        'email' => 'estoque@tapemag.com.br',        'role' => 'estoque'],
            ['name' => 'Estoquista',     'email' => 'estoque@tapemag.com.br',        'role' => 'estoque'],
            ['name' => 'Marcos',         'email' => 'estoque@tapemag.com.br',        'role' => 'estoque'],
            ['name' => 'Hugo',           'email' => 'hugo.cezario@tapemag.com.br',   'role' => 'estoque'],

            // GERÊNCIA / DIRETORIA / PROPRIETÁRIO
            ['name' => 'Jorge',          'email' => 'jorge.vaz@tapemag.com.br',      'role' => 'gerencia'],
            ['name' => 'Juliano',        'email' => 'vendas6@tapemag.com.br',        'role' => 'diretoria'],
            ['name' => 'Mauro',          'email' => 'mauro@tapemag.com.br',          'role' => 'proprietario'],
        ];

        foreach ($users as $u) {
            $senha = $u['role'] === 'admin' ? '98732905' : 'tapemag123';

            \App\Models\User::create([
                'name'     => $u['name'],
                'email'    => $u['email'],
                'password' => Hash::make($senha),
                'role'     => $u['role'],
            ]);

            echo "✅ " . $u['name'] . " — " . $u['email'] . " — senha: " . $senha . "\n";
        }
    }
}