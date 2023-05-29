<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuffetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buffets')->insert([
            'status' => 1,
            'name' => 'Churrasco',
            // 'code' => 'barbecue',
            'description' => '- Arroz branco ou Arroz a Grega

- Saladas de folhas e legumes
Alface, rúcula, salada bicolor, brócolis, couve-flor, tomate, vinagrete, maionese de legumes e molhos variados. 

- Carnes
Fraldinha
Contra Filé
Sobrecoxa e Asinha de Frango 
Linguiça Toscana 
Pão de Alho 

- Acompanhamento
Farofa com calabresa 
    
- Sobremesa
Bolo com sorvete 

- Encerramento
Mesa de café 
Petit fours',
            'price' => 640,
            'type' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffets')->insert([
            'status' => 1,
            'name' => 'Jantar',
            // 'code' => 'dinner',
            'description' => '- Saladas de folhas e legumes
Alface, rúcula, salada bicolor, brócolis, couve-flor, tomate, maionese de legumes e molhos variados. 

- Fettuccine ao molho branco ou sugo 

- Arroz branco

- Batatinhas ao molho pesto 

- Strogonoff de Frango ou Frango ao molho de laranja

- Sobremesa
Bolo com sorvete

- Encerramento
Mesa de café 
Petit fours ',
            'price' => 440,
            'type' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffets')->insert([
            'status' => 1,
            'name' => 'Finger Food',
            // 'code' => 'finger_food',
            'description' => '- Saladas de folhas e legumes
Alface, rúcula, salada bicolor, brócolis, couve-flor, tomate, maionese de legumes e molhos variados. 

- Mini Polentinha com ragu de linguiça 

- Mini Batata Bolinha com bacon e catupiry 

- Frango com creme de Milho 

- Massa
Fettuccine ao molho branco ou sugo 

- Sobremesa
Bolo com sorvete

- Encerramento
Mesa de café 
Petit fours',
            'price' => 440,
            'type' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffets')->insert([
            'status' => 1,
            'name' => 'Comida de Boteco',
            // 'code' => 'bar_food',
            'description' => '- Arroz branco  

- Saladas de folhas e legumes
Alface, rúcula, salada bicolor, brócolis, couve-flor, tomate, maionese de legumes e molhos variados. 

-Batata frita

-Calabresa acebolada

-Frango a passarinho 

-Torresmo

-Polenta Frita 

-Farofa com bacon

- Sobremesa
Bolo com sorvete

- Encerramento
Mesa de café 
Petit fours',
            'price' => 440,
            'type' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffets')->insert([
            'status' => 1,
            'name' => 'Coquetel',
            // 'code' => 'cocktail',
            'description' => 'Mini-Salgados:

- Fritos: coxinha, maravilha de queijo, croquete de carne, crespinho de milho, croquete de calabresa, mini quibe, Risoles ( pizza, palmito, calabresa com catupiry) 

- Assados : Esfiha de carne ou frango, trouxinha de calabresa ,enroladinho de salsicha, empada (frango e palmito)

- Mini Hambúrguer, Mini Cachorro-quente e batata frita

- Massa
Fettuccine ao molho branco ou sugo 

- Sobremesa
Bolo com sorvete

- Encerramento
Mesa de café 
Petit fours',
            'price' => 440,
            'type' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffets')->insert([
            'status' => 1,
            'name' => 'Tábua de Frios',
            // 'code' => 'cold_cuts_board',
            'description' => 'Mix de azeitonas, patê de frango com ervas finas e torradas, ovinhos de codorna, queijos mussarela e prato, lombo canadense defumado e pães mini brioche.',
            'price' => 100,
            'type' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffets')->insert([
            'status' => 1,
            'name' => 'Salgados Finos',
            // 'code' => 'fine_snacks',
            'description' => 'Quiche de ricota com espinafre, trouxinha de calabresa , croquete de carne, mini croissant, empada de frango/palmito, pérola de queijo  e crespinho de milho. ',
            'price' => 100,
            'type' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
