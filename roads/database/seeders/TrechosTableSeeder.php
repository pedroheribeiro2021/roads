<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrechosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('trechos')->insert([
            ['nome' => 'Trecho 1', 'descricao' => 'Descrição do Trecho 1'],
            ['nome' => 'Trecho 2', 'descricao' => 'Descrição do Trecho 2'],
            // Adicione mais dados conforme necessário
        ]);
    }
}

