<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('accounting_statuses')->insert([
            'name' => 'Pendente',
            'code' => 'pendent',
            'description' => 'Não pago, mas dentro do prazo de pagamento',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('accounting_statuses')->insert([
            'name' => 'Pago',
            'code' => 'paid',
            'description' => 'Já foi pago',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('accounting_statuses')->insert([
            'name' => 'Atrasado',
            'code' => 'late',
            'description' => 'Não pago, pagamento atrasado',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('accounting_statuses')->insert([
            'name' => 'Pago com atraso',
            'code' => 'paid_late',
            'description' => 'Não pago, pagamento atrasado',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('accounting_statuses')->insert([
            'name' => 'Extornado',
            'code' => 'reversed',
            'description' => 'Valor devolvido por algum motivo em particular',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
