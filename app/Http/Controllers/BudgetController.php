<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Budget;
use App\Models\Ceremony;
use App\Models\Task;

use App\Models\Client;
use App\Models\Event;
use App\Models\Decoration;
use App\Models\BuffetEntry;
use App\Models\Buffet;

class BudgetController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $budget = Budget::create($request->validate([
            'client_id' => ['required', 'numeric'],

            'event_id' => ['required', 'numeric'],
            'decoration_id' => ['required', 'numeric'],
            'buffet_entry_id' => ['required', 'numeric'],
            'buffet_id' => ['required', 'numeric'],

            'beer' => ['required', 'boolean'],
            'bar' => ['required', 'boolean'],
            'dj' => ['required', 'boolean'],
            'advisory' => ['required', 'boolean'],

            'guests_quantity' => ['required', 'numeric'],

            'event_date' => ['required', 'date_format:Y-m-d\TH:i'],
            'event_place' => ['required', 'string'],

            'budget_total_value' => ['nullable', 'numeric'],

            'budget_comment' => ['nullable', 'string'],
            'budget_token' => ['nullable', 'string', 'unique:budgets'],
            'budget_link' => ['nullable', 'string', 'unique:budgets'],
        ]));

        $ceremony = Ceremony::create([
            'budget_id' => $budget->id,
            'ceremony_status_id' => 1,
            'total_negotiated_amount' => $budget->budget_total_value,
            'entry_amount' => $budget->budget_total_value * 0.1,
            'remaining_amount' => $budget->budget_total_value - ($budget->budget_total_value * 0.1),
        ]);

        $client = Client::find($request->client_id);
        $event = Event::find($request->event_id);
        $decoration = Decoration::find($request->decoration_id);
        $buffet_entry = BuffetEntry::find($request->buffet_entry_id);
        $buffet = Buffet::find($request->buffet_id);

        Task::create([
            'title' => $event->name.' de '.$client->name,
            'description' => '
                Decoração: '.$decoration->name.'
                Entrada do Buffet: '.$buffet_entry->name.'
                Buffet: '.$buffet->name,
            'deadline' => $request->event_date,
            'priority' => 1,
            'tags' => json_encode(array()),
            'ceremony_id' => $ceremony->id,
            'user_id' => Auth::id(),
            'task_id' => null,
            'task_status_id' => 1,
        ]);

        return to_route('clients.show', $request->client_id);
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
        $active_clients = Client::where('active', true)->get();
        $client = Client::find($budget->client_id);
        $client_budgets = Budget::select('budgets.*', 'events.name AS event_name')
            ->where('budgets.client_id', $budget->client_id)
            ->leftJoin('events', 'events.id', '=', 'budgets.event_id')
            ->orderBy('budgets.created_at', 'desc')
            ->get();

        $budget_selects_options = array(
            "events" => Event::all(),
            "decorations" => Decoration::all(),
            "buffet_entries" => BuffetEntry::all(),
            "buffets" => Buffet::all(),
        );

        return Inertia::render('Clients', [
            'activated_page' => $client->id,
            'page_url_base' => 'clients',
            "submenu" => $active_clients,
            "selected_client" => $client,
            "client_budgets" => $client_budgets,
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
