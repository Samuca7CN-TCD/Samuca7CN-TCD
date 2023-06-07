<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Ceremony;
use App\Models\Installment;
use App\Models\BudgetAdditional;
use App\Models\BudgetExpense;
use App\Models\Voucher;
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
                $this->deleteInstallments($budget);
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
        $ceremony->total_installments = 0;
        $ceremony->total_additions = 0;
        $ceremony->total_expenses = 0;
        $ceremony->total_discount = 0;
        $ceremony->status = 0;
        $ceremony->observations = '';
        $ceremony->save();

        $default_expenses = array(
            array("name" => "phol", "amount" => $budget->dj ? 1200 : 0),
            array("name" => "decoração", "amount" => Decoration::find($budget->decoration_id)->price),
            array("name" => "compra", "amount" => (Buffet::find($budget->buffet_entry_id)->cost * ($budget->guests_quantity / 10)) + (Buffet::find($budget->buffet_id)->cost * ($budget->guests_quantity / 10))),
            array("name" => "bebidas", "amount" => $budget->beer ? 150 : 0),
            array("name" => "locações", "amount" => 0),
            array("name" => "garçon", "amount" => 150 * ceil($budget->guests_quantity / 30)),
            array("name" => "ajudante de cozinha", "amount" => 150),
            array("name" => "cozinheira", "amount" => 1000),
            array("name" => "staff chicago", "amount" => 1500),
            array("name" => "fornecedores", "amount" => 0),
            array("name" => "churrasqueiro", "amount" => $budget->buffet_id == 1 ? 150 : 0),
            array("name" => "gelo", "amount" => 0),
            array("name" => "rateio luz e água", "amount" => 100),
            array("name" => "rateio aluguel", "amount" => 1000),
        );

        $sum_expenses = 0;
        foreach ($default_expenses as $exp) {
            $expense = new BudgetExpense();
            $expense->ceremony_id = $ceremony->id;
            $expense->name = $exp['name'];
            $expense->amount = $exp['amount'];
            $expense->save();
            $sum_expenses += $exp['amount'];
        }

        $ceremony->total_expenses = $sum_expenses;
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

    private function deleteInstallments($budget)
    {
        $ceremony = Ceremony::where('budget_id', $budget->id)->first();
        $installments = Installment::where('ceremony_id', $ceremony->id)->get();
        $additions = BudgetAdditional::where('ceremony_id', $ceremony->id)->get();
        $expenses = BudgetExpense::where('ceremony_id', $ceremony->id)->get();

        if ($installments) {
            $installments->each->delete();
            $additions->each->delete();
            $expenses->each->delete();
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
        $new_budget->event_time = $budget->event_time;
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
        $budget = Budget::find($ceremony->budget_id);
        // $ceremony->installments = json_encode($request->installment_list);
        // $total = 0;
        // foreach ($request->installment_list as $installment) $total += $installment['total_amount'];
        $ceremony->total_installments = $this->generate_installments($ceremony->id, $request->installment_list);
        $ceremony->installment_option = $request->installment_list[0]['type'];
        if ($ceremony->installment_option == 3) $ceremony->total_negotiated_amount = $budget->budget_total_value * 0.95;
        else $ceremony->total_negotiated_amount = $budget->budget_total_value;
        $ceremony->save();
        return to_route('financials.index', $id);
    }

    private function generate_installments($ceremony_id, $installments)
    {
        $total_value = 0;

        $old_installments = Installment::where('ceremony_id', $ceremony_id)->get();
        $old_installments->each->forceDelete();

        foreach ($installments as $installment) {
            $total_value += $installment['total_amount'];
            $installment_new = new Installment();
            $installment_new->ceremony_id = $ceremony_id;
            $installment_new->name = $installment['name'];
            $installment_new->type = $installment['type'];
            $installment_new->paid_amount = $installment['paid_amount'];
            $installment_new->paid = $installment['paid'];
            $installment_new->total_amount = $installment['total_amount'];
            $installment_new->deadline = $installment['deadline'];
            $installment_new->entry = $installment['entry'];
            $installment_new->save();
        }
        return $total_value;
    }

    public function create_addition(Request $request)
    {
        $ceremony = Ceremony::find($request->ceremony_id);
        //$budget = Budget::find($ceremony->budget_id);

        $addition = new BudgetAdditional();
        $addition->ceremony_id = $request->ceremony_id;
        $addition->name = $request->name;
        $addition->amount = $request->amount;
        $addition->left_amount = $request->left_amount;
        $addition->paid = $request->paid;
        $addition->save();

        $ceremony->total_additions = BudgetAdditional::where('ceremony_id', $ceremony->id)->sum('amount');

        //$ceremony->total_negotiated_amount = $budget->budget_total_value;
        //if ($ceremony->installment_option == 3)  $ceremony->total_negotiated_amount *= 0.95;

        $ceremony->save();

        return to_route('financials.index', $ceremony->id);
    }

    public function update_addition(Request $request, $id)
    {
        $ceremony = Ceremony::find($request->ceremony_id);

        $addition = BudgetAdditional::find($id);
        $addition->name = $request->name;
        $addition->amount = $request->amount;
        $addition->left_amount = $request->left_amount;
        $addition->paid = $request->paid;
        $addition->save();

        $ceremony->total_additions = BudgetAdditional::where('ceremony_id', $ceremony->id)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $ceremony->id);
    }

    public function delete_addition(Int $id)
    {
        $addition = BudgetAdditional::find($id);
        $ceremony = Ceremony::find($addition->ceremony_id);
        $addition->delete();

        $ceremony->total_additions = BudgetAdditional::where('ceremony_id', $ceremony->id)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $id);
    }

    public function create_expense(Request $request)
    {
        $expense = new BudgetExpense();
        $expense->ceremony_id = $request['ceremony_id'];
        $expense->name = $request['name'];
        $expense->amount = $request['amount'];
        $expense->save();

        $ceremony = Ceremony::find($request->ceremony_id);
        $ceremony->total_expenses = BudgetExpense::where('ceremony_id', $ceremony->id)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $ceremony->id);
    }

    public function update_expense(Request $request, $id)
    {
        $ceremony = Ceremony::find($request->ceremony_id);

        $expense = BudgetExpense::find($id);
        $expense->name = $request->name;
        $expense->amount = $request->amount;
        $expense->save();

        $ceremony->total_expenses = BudgetExpense::where('ceremony_id', $ceremony->id)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $ceremony->id);
    }

    public function delete_expense(Int $id)
    {
        $expense = BudgetExpense::find($id);
        $ceremony = Ceremony::find($expense->ceremony_id);
        $expense->delete();

        $ceremony->total_expenses = BudgetExpense::where('ceremony_id', $ceremony->id)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $id);
    }

    public function update_voucher(Request $request, $id)
    {
        $ceremony = Ceremony::find($id);
        $installment = Installment::find($request->installment_id);

        $file = $request->file('file');
        $filename = $file->hashName();
        $path = $file->storeAs('public/installment_files', $filename);

        if ($path) {
            $paid_amount = $request->value;
            if (($installment->total_amount - $installment->paid_amount) - $paid_amount < 0.01) {
                $paid_amount = ($installment->total_amount - $installment->paid_amount);
                $installment->paid = true;
            }

            $voucher = new Voucher();
            $voucher->installment_id = $request['installment_id'];
            $voucher->name = $request['name'];
            $voucher->value = $request['value'];
            $voucher->file = $filename;
            $voucher->payment_date = $request['payment_date'];
            $voucher->save();

            $installment->paid_amount += $paid_amount;
            $installment->save();

            $ceremony->paid_amount += $paid_amount;

            if (($ceremony->total_negotiated_amount + $ceremony->total_additions) - $ceremony->paid_amount < 0.01) {
                $ceremony->paid_amount = ($ceremony->total_negotiated_amount + $ceremony->total_additions);
                $ceremony->status = 1; //pago
            }

            $ceremony->save();
        }
    }

    public function delete_voucher(Request $request, $id)
    {
        $ceremony = Ceremony::find($id);
        $voucher = Voucher::find($request->id);
        $installment = Installment::find($voucher->installment_id);

        $installment->paid_amount -= $voucher->value;
        $installment->paid = false;
        $installment->save();

        $ceremony->paid_amount -= $voucher->value;
        $ceremony->status = 0;
        $ceremony->save();

        Storage::delete('public/installment_files/' . $voucher->file);
        $voucher->delete();
    }

    public function update_obs(Request $request, $id)
    {
        $ceremony = Ceremony::find($id);
        $ceremony->observations = $request->obs;
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
