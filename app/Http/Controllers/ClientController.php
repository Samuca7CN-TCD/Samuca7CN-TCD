<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Client;
use App\Models\Budget;
use App\Models\Ceremony;
use App\Models\Event;
use App\Models\Decoration;
use App\Models\BuffetEntry;
use App\Models\Buffet;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $clients = Client::select('clients.*', 'budgets.event_date', 'budgets.event_time')
            ->leftJoin('budgets', 'budgets.client_id', '=', 'clients.id')
            ->groupBy('clients.id')
            ->orderBy('clients.active', 'desc')
            ->orderBy('budgets.event_date')
            ->orderBy('budgets.event_time')
            ->orderBy('clients.created_at', 'desc')
            ->orderBy('clients.name', 'asc')
            ->get();
        $active_clients = Client::where('active', true)->orderBy('created_at', 'asc')->get();
        return Inertia::render('Clients', [
            "submenu" => $active_clients,
            'submenu_category' => 'clients',
            'activated_page' => 0,
            "clients_list" => $clients,
        ]);
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
        Client::create($request->validate([
            'name' => ['required', 'string'],
            'contact' => ['nullable', 'string', 'unique:clients'],
            'email' => ['nullable', 'email', 'unique:clients'],
            'active' => ['required', 'boolean'],
        ]));
        return to_route('clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        $active_clients = Client::where('active', true)->get();
        $client = Client::find($id);
        $client_budgets = Budget::select('budgets.*', 'events.name AS event_name')
            ->where('budgets.client_id', $id)
            ->leftJoin('events', 'events.id', '=', 'budgets.event_id')
            ->orderBy('budgets.created_at', 'desc')
            ->get();
        $budget_selects_options = array(
            "events" => Event::all(),
            "decorations" => Decoration::all(),
            "buffet_entries" => Buffet::where('type', 2)->get(),
            "buffets" => Buffet::where('type', 1)->get(),
        );

        return Inertia::render('Clients', [
            'activated_page' => $client->id,
            "submenu" => $active_clients,
            'submenu_category' => 'clients',
            "selected_client" => $client,
            "client_budgets" => $client_budgets,
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
     * @param  @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        Client::find($id)->update($request->validate([
            'name' => ['required', 'string'],
            'contact' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'active' => ['required', 'boolean'],
        ]));
        return to_route('clients.index');
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
