<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Buffet;
use App\Models\BuffetPlate;

class BuffetPlateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Arroz branco ou Arroz a Grega',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Saladas de folhas e legumes',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Carnes',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Acompanhamento',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Sobremesa (Bolo com Sorvete)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Encerramento (Mesa de Café, Petit Fours)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Saladas de folhas e legumes',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Ravioli Quatro queijos ao molho (sugo ou rosê)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Arroz Branco',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Batatinhas ao molho pesto',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Filé de frango com creme de milho',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Filé de frango ao molho de maracujá ou laranja',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Sobremesa (Bolo com Sorvete)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Encerramento (Mesa de Café, Petit Fours)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Saladas de folhas e legumes',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Mini Polentinha com ragu de linguiça',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Mini Batata Bolinha com bacon e catupiry',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Frango com creme de Milho',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Massa (Ravioli 4 queijos com molho (Rosê ou Sugo))',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Sobremesa (Bolo com Sorvete);',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Encerramento (Mesa de Café, Petit Fours)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 3,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Arroz Branco',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Saladas de folhas e legumes',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Batata Frita',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Calabresa Acebolada',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Frango a Passarinho',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Torresmo',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Polenta Frita',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Farofa com Bacon',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Sobremesa (Bolo com Sorvete)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Encerramento (Mesa de Café, Petit Fours)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Mini-Salgados (Fritos, Assados, Mini Hambúrguer, Mini Cachorro-quente e Batata Frita)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Massa (Raviolli de 4 queijos com molho sugo)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Sobremesa (Bolo com sorvete)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Encerramento (Mesa de café e Petit fours)',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 5,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Quiche de ricota com espinafre',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Trouxinha de calabresa',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Croquete de carne',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Mini croissant',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Empada de frango/palmito',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Pérola de queijo',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Crespinho de milho',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 6,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Mix de azeitonas',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Patê de frango com ervas finas e torradas',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Ovinhos de codorna',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Queijos mussarela e prato',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Combo canadense defumado',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_plates')->insert([
            'status' => 1,
            'name' => 'Pães mini brioche',
            'description' => null,
            'cost' => 0.00,
            'qtd_per_ten_people' => 1,
            'measure_unity' => 'unidades',
            'buffet_id' => 7,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
