<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Menu;
use App\Models\Submenu;
use App\Models\Client;
use App\Models\Ceremony;
use App\Models\Installment;
use App\Models\Voucher;
use App\Models\Budget;
use App\Models\MonthlyExpense;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response;
     */
    public function index()
    {
        $budgets = Budget::select(
            'budgets.id',
            'clients.name AS client_name',
            'events.name AS event_name',
            'ceremonies.total_negotiated_amount AS total_negociado',
            'ceremonies.total_additions AS total_adicionado',
            'ceremonies.paid_amount AS valor_pago',
            'ceremonies.total_expenses AS total_gastos'
        )
            ->where('budgets.status', 1)
            ->leftJoin('clients', 'clients.id', 'budgets.client_id')
            ->leftJoin('events', 'events.id', 'budgets.event_id')
            ->leftJoin('ceremonies', 'ceremonies.budget_id', 'budgets.id')
            ->orderBy('clients.name')
            ->get();

        $valor_total = Ceremony::select(
            DB::raw('(SUM(ceremonies.total_negotiated_amount) + SUM(ceremonies.total_additions)) as total'),
            DB::raw('SUM(ceremonies.paid_amount) as paid'),
            DB::raw('SUM(ceremonies.total_expenses) as expenses'),
        )
            ->where('budgets.status', 1)
            ->leftJoin('budgets', 'budgets.id', 'ceremonies.budget_id')
            ->first();

        return Inertia::render('Dashboard', [
            'budgets' => $budgets,
            'valor_total' => (float) $valor_total->total,
            'total_recebido' => (float) $valor_total->paid,
            'total_a_receber' => (float) $valor_total->total - (float) $valor_total->paid,
            'total_custos' => (float) $valor_total->expenses,
            'total_gastos_mensais' => (float) MonthlyExpense::sum('amount'),
            'total_lucro' => (float) $valor_total->total - (float) $valor_total->expenses,
        ]);
    }

    public function to_receive($begin, $end)
    {
        $valor = array('to_receive' => 0);
        if ($begin == $end) {
            $valor = Installment::select(
                DB::raw('(SUM(installments.amount) - SUM(installments.paid_amount)) as to_receive'),
            )
                ->where('installments.deadline', 'like', $begin . '%')
                ->first();
        } else {
            $valor = Installment::select(
                DB::raw('(SUM(installments.amount) - SUM(installments.paid_amount)) as to_receive'),
            )
                ->where('installments.deadline', '>=', $begin . ' 00:00:00')
                ->where('installments.deadline', '<=', $end . ' 23:59:59')
                ->first();
        }
        return $valor->to_receive;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response;
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Inertia\Inertia  $request
     * @return \Inertia\Response;
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response;
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response;
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Inertia\Inertia  $request
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function destroy($id)
    {
        //
    }
}
