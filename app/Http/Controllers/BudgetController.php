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
            'budget_total_value' => ['nullable', 'numeric'],

            'status' => ['required', 'numeric'],

            'budget_comment' => ['nullable', 'string'],
            'budget_token' => ['nullable', 'string', 'unique:budgets'],
            'budget_link' => ['nullable', 'string', 'unique:budgets'],
        ]));

        /*
        $ceremony = Ceremony::create([
            'budget_id' => $budget->id,
            'ceremony_status_id' => 1,
            'total_negotiated_amount' => $budget->budget_total_value,
            'entry_amount' => 0.0,
            'remaining_amount' => $budget->budget_total_value,
        ]);

        $client = Client::find($request->client_id);
        $event = Event::find($request->event_id);
        $decoration = Decoration::find($request->decoration_id);
        $buffet_entry = Buffet::find($request->buffet_entry_id);
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
        */

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
        $ceremony = Ceremony::where('budget_id', $budget->id)->first();

        $budgets = Budget::select('budgets.*', 'events.name AS event_name')
            ->where('client_id', $budget->client_id)
            ->leftJoin('events', 'events.id', '=', 'budgets.event_id')
            ->get();

        $budget_selects_options = array(
            "events" => Event::all(),
            "decorations" => Decoration::all(),
            "buffet_entries" => Buffet::where('type', 2)->where('status', 1)->get(),
            "buffets" => Buffet::where('type', 1)->where('status', 1)->get(),
        );

        return Inertia::render('Clients', [
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        Budget::find($id)->update($request->validate([
            'client_id' => ['required', 'numeric'],

            'event_id' => ['required', 'numeric'],
            'decoration_id' => ['required', 'numeric'],
            'buffet_entry_id' => ['required', 'numeric'],
            'buffet_id' => ['required', 'numeric'],

            'beer' => ['required', 'boolean'],
            'bar' => ['required', 'boolean'],
            'dj' => ['required', 'boolean'],
            'advisory' => ['required', 'boolean'],

            'guests_quantity' => ['required', 'numeric', 'min:1'],
            'event_date' => ['required', 'date_format:Y-m-d\TH:i'],
            'budget_total_value' => ['nullable', 'numeric'],

            'budget_comment' => ['nullable', 'string'],
            'budget_token' => ['nullable', 'string', 'unique:budgets'],
            'budget_link' => ['nullable', 'string', 'unique:budgets'],
        ]));
        return to_route('budgets.index');
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
