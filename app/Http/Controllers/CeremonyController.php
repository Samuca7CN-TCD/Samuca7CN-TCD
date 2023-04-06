<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Ceremony;
use App\Models\Budget;
use App\Models\Decoration;
use App\Models\Buffet;
use App\Models\Client;

class CeremonyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Inertia\Inertia  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Cicle of the ceremony lifecycle
     *
     * @param  int $budget_id
     * @param  int $option
     * @return mixed
     */
    public function cycle_ceremony($budget_id, $option)
    {
        $budget = Budget::find($budget_id);
        switch ($option) {
            case 0:
                $this->create_ceremony($budget);
                $this->set_budget_status($budget, 2);
                break;
            case 1:
                $this->set_budget_status($budget, 1);
                $this->set_ceremony_status($budget, 1);
                $this->set_client_status($budget, true);
                break;
            case 2:
                $this->set_budget_status($budget, 3);
                $this->set_ceremony_status($budget, 0);
                $client_budgets = Budget::where('client_id', $budget->client_id)->where('status', 1)->get();
                if (!count($client_budgets)) $this->set_client_status($budget, false);
                break;
            case 3:
                $new_budget_id = $this->clone_budget($budget);
                return to_route('budgets.show', $new_budget_id);
            case 4:
                $this->set_budget_status($budget, 4);
                $client_budgets = Budget::where('client_id', $budget->client_id)->where('status', 1)->get();
                if (!count($client_budgets)) $this->set_client_status($budget, false);
                break;
        }
        return to_route('budgets.show', $budget_id);
    }

    private function create_ceremony($budget)
    {
        $ceremony = new Ceremony();
        $ceremony->budget_id = $budget->id;
        $ceremony->total_negotiated_amount = $budget->budget_total_value;
        $ceremony->paid_amount = 0;
        $ceremony->installments = json_encode(array());
        $ceremony->expenses = array(
            'phol' => $budget->dj ? 1200 : 0,
            'decoração' => Decoration::find($budget->decoration_id)->price,
            'compra' => (Buffet::find($budget->buffet_entry_id)->cost * ($budget->guests_quantity / 10)) + (Buffet::find($budget->buffet_id)->cost * ($budget->guests_quantity / 10)),
            'bebida' => $budget->beer ? 150 : 0,
            'locações' => 0,
            'garçon' => 150 * ceil($budget->guests_quantity / 30),
            'ajudante de cozinha' => 150,
            'nil cozinheira' => 1000,
            'staff chicago' => 1500,
            'fornecedores' => 0,
            'churrasqueiro' => $budget->buffet_id == 1 ? 150 : 0,
            'gelo' => 0,
            'rateio luz e água' => 100,
            'rateio aluguel' => 1000,
        );
        $ceremony->total_expenses = array_sum($ceremony->expenses);
        $ceremony->expenses = json_encode($ceremony->expenses);
        $ceremony->status = 0;
        $ceremony->observations = '';
        $ceremony->save();
    }

    private function set_budget_status($budget, $status)
    {
        $budget->status = $status;
        $budget->save();
    }

    private function set_ceremony_status($budget, $status)
    {
        $ceremony = Ceremony::where('budget_id', $budget->id)->first();
        if ($ceremony) {
            $ceremony->status = $status;
            $ceremony->save();
        }
    }

    private function set_client_status($budget, $status)
    {
        $client = Client::find($budget->client_id);
        $client->active = $status;
        $client->save();
    }

    private function clone_budget($budget)
    {
        $new_budget = new Budget();
        $new_budget->client_id = $budget->client_id;

        $new_budget->event_id = $budget->event_id;
        $new_budget->decoration_id = $budget->decoration_id;
        $new_budget->buffet_entry_id = $budget->buffet_entry_id;
        $new_budget->buffet_id = $budget->buffet_id;

        $new_budget->beer = $budget->beer;
        $new_budget->bar = $budget->bar;
        $new_budget->dj = $budget->dj;
        $new_budget->advisory = $budget->advisory;

        $new_budget->guests_quantity = $budget->guests_quantity;
        $new_budget->event_date = $budget->event_date;
        $new_budget->budget_total_value = $budget->budget_total_value;

        $new_budget->status = 0;

        $new_budget->budget_comment = $budget->budget_comment;
        $new_budget->budget_token = $budget->budget_token;
        $new_budget->budget_link = $budget->budget_link;

        $new_budget->save();
        return $new_budget->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return mixed
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
        $ceremony = Ceremony::find($id);
        $ceremony->installments = json_encode($request->installment_list);
        $ceremony->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {
        //
    }
}
