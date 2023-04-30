<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Budget;
use App\Models\Ceremony;
use App\Models\Event;
use App\Models\Decoration;
use App\Models\Buffet;

class InstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Inertia\Inertia  $request
     * @return \Inertia\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $budget = Budget::find($id);
        $ceremony = Ceremony::where('budget_id', $budget->id)->first();

        $budgets = Budget::select('budgets.*', 'events.name AS event_name')
            ->where('budgets.client_id', $budget->client_id)
            ->leftJoin('events', 'events.id', '=', 'budgets.event_id')
            ->orderBy('budgets.created_at', 'desc')
            ->orderBy('budgets.event_date', 'desc')
            ->get();

        $budget_selects_options = array(
            "events" => Event::all(),
            "decorations" => Decoration::all(),
            "buffet_entries" => Buffet::where('type', 2)->where('status', 1)->get(),
            "buffets" => Buffet::where('type', 1)->where('status', 1)->get(),
        );
        return Inertia::render('Financials', [
            'activated_page' => (int) $id,
            "submenu" => $budgets,
            'submenu_category' => 'budgets',
            "client_budgets" => $budgets,
            "ceremony" => $ceremony,
            "budget" => $budget,
            "budget_selects_options" => $budget_selects_options,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
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
