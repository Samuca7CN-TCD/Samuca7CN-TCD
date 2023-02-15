<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuffetEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buffet_entries')->insert([
            'name' => 'Tábua de Frios',
            'code' => 'cold_cuts_board',
            'description' => 'Mix de azeitonas, patê de frango com ervas finas e torradas, ovinhos de codorna, queijos mussarela e prato, lombo canadense defumado e pães mini brioche.',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('buffet_entries')->insert([
            'name' => 'Salgados Finos',
            'code' => 'fine_snacks',
            'description' => 'Quiche de ricota com espinafre, trouxinha de calabresa , croquete de carne, mini croissant, empada de frango/palmito, pérola de queijo  e crespinho de milho. ',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
