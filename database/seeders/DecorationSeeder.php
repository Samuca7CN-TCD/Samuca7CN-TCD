<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DecorationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('decorations')->insert([
            'name' => 'Decoração no Espaço Chicago Eventos',
            'code' => 'chicago_eventos_space_decoration',
            'description' => 'Além de toda a decoração já existente em nosso espaço, também incluímos uma decoração completa e personalizada para sua cerimônia e mesa de bolo.
            - 20 bancos de 4 lugares + Altar estilo rústico
            - Tapete para caminho
            - 6 vasos para caminho com arranjos
            - 6 buchinhos
            - 2 luminárias lanternas para pergolado
            - 1 bolo fake com suporte
            - 4 vasos com arranjos (escolher cor)
            - 2 vasos laterais
            - 4 suportes de doce
            - 2 suportes de velas
            - Arranjos de centro de mesa
            - Enfeite letras de mesa (Amor ou Love)
            - Arranjos com flores permanentes a escolher.',
            'price' => '1900',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('decorations')->insert([
            'name' => 'Decoração em espaço secundário',
            'code' => 'secondary_space_decoration',
            'description' => '- Mesa do Bolo
            - Centros de Mesa',
            'price' => '1500',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
