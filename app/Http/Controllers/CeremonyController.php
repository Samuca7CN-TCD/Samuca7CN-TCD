<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Models\Ceremony;
use App\Models\Installment;
use App\Models\BudgetAdditional;
use App\Models\BudgetAdditionalVoucher;
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
                $this->set_budget_and_ceremony_status($budget, 1, 1, true);
                break;

            case 2:
                $this->set_budget_and_ceremony_status($budget, 3, 0, false);
                $this->handleClientStatus($budget);
                $this->deleteInstallments($budget);
                break;

            case 3:
                $new_budget_id = $this->clone_budget($budget);
                return to_route('budgets.show', $new_budget_id);

            case 4:
                $this->set_budget_and_ceremony_status($budget, 4, 0, false);
                $this->handleClientStatus($budget);
                break;
        }

        return to_route('budgets.show', $budget_id);
    }

    private function set_budget_and_ceremony_status($budget, $budgetStatus, $ceremonyStatus, $setClientStatus)
    {
        $this->set_budget_status($budget, $budgetStatus);
        $this->set_ceremony_status($budget, $ceremonyStatus);

        if ($setClientStatus) {
            $client_budgets = Budget::where('client_id', $budget->client_id)->where('status', 1)->get();
            if (!count($client_budgets)) {
                $this->set_client_status($budget, false);
            }
        }
    }

    private function handleClientStatus($budget)
    {
        $client_budgets = Budget::where('client_id', $budget->client_id)->where('status', 1)->get();
        if (!count($client_budgets)) {
            $this->set_client_status($budget, false);
        }
    }


    private function create_ceremony($budget)
    {
        $ceremony = new Ceremony([
            'budget_id' => $budget->id,
            'total_negotiated_amount' => $budget->budget_total_value,
            'paid_amount' => 0,
            'total_installments' => 0,
            'total_additions' => 0,
            'total_expenses' => 0,
            'total_discount' => 0,
            'status' => 0,
            'observations' => '',
        ]);

        $ceremony->save();

        $defaultExpenses = $this->getDefaultExpenses($budget);
        $this->saveDefaultExpenses($ceremony, $defaultExpenses);
    }

    private function getDefaultExpenses($budget)
    {
        return [
            ['name' => 'phol', 'amount' => $budget->dj ? 1200 : 0],
            ['name' => 'decoração', 'amount' => Decoration::find($budget->decoration_id)->price],
            // Adicione outras despesas padrão aqui
        ];
    }

    private function saveDefaultExpenses($ceremony, $defaultExpenses)
    {
        $sumExpenses = 0;

        foreach ($defaultExpenses as $expenseData) {
            $expense = new BudgetExpense([
                'ceremony_id' => $ceremony->id,
                'name' => $expenseData['name'],
                'amount' => $expenseData['amount'],
            ]);

            $expense->save();

            $sumExpenses += $expenseData['amount'];
        }

        $ceremony->total_expenses = $sumExpenses;
        $ceremony->save();
    }


    private function set_budget_status($budget, $status)
    {
        $budget->status = $status;
        $budget->save();
    }

    private function set_ceremony_status($budget, $status)
    {
        $ceremony = Ceremony::updateOrCreate(
            ['budget_id' => $budget->id],
            ['status' => $status]
        );
    }


    private function deleteInstallments($budget)
    {
        $ceremony = Ceremony::where('budget_id', $budget->id)->first();

        if ($ceremony) {
            Installment::where('ceremony_id', $ceremony->id)->delete();
            BudgetAdditional::where('ceremony_id', $ceremony->id)->delete();
            BudgetExpense::where('ceremony_id', $ceremony->id)->delete();
        }
    }


    private function set_client_status($budget, $status)
    {
        Client::where('id', $budget->client_id)->update(['active' => $status]);
    }


    private function clone_budget($budget)
    {
        $newBudget = $budget->replicate();
        $newBudget->status = 0;
        $newBudget->save();

        return $newBudget->id;
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
        $ceremony = Ceremony::findOrFail($id);
        $budget = Budget::findOrFail($ceremony->budget_id);

        $ceremony->total_installments = $this->generate_installments($ceremony->id, $request->installment_list);
        $ceremony->installment_option = $request->installment_list[0]['type'];

        if ($ceremony->installment_option == 3) {
            $ceremony->total_negotiated_amount = $budget->budget_total_value * 0.95;
        } else {
            $ceremony->total_negotiated_amount = $budget->budget_total_value;
        }

        $ceremony->save();

        return to_route('financials.index', $id);
    }


    private function verify_ceremony_status($ceremony)
    {
        $remainingAmount = ($ceremony->total_negotiated_amount + $ceremony->total_additions) - $ceremony->paid_amount;

        if ($remainingAmount < 0.01) {
            $ceremony->paid_amount += $remainingAmount;
            $ceremony->status = 1; // pago
        }

        $ceremony->save();
    }


    private function generate_installments($ceremonyId, $installments)
    {
        $totalValue = 0;

        Installment::where('ceremony_id', $ceremonyId)->delete(); // Exclui instâncias antigas

        foreach ($installments as $installmentData) {
            $totalValue += $installmentData['total_amount'];

            Installment::create([
                'ceremony_id' => $ceremonyId,
                'name' => $installmentData['name'],
                'type' => $installmentData['type'],
                'paid_amount' => $installmentData['paid_amount'],
                'paid' => $installmentData['paid'],
                'total_amount' => $installmentData['total_amount'],
                'deadline' => $installmentData['deadline'],
                'entry' => $installmentData['entry'],
            ]);
        }

        return $totalValue;
    }


    public function create_addition(Request $request)
    {
        $ceremonyId = $request->ceremony_id;

        $addition = BudgetAdditional::create([
            'ceremony_id' => $ceremonyId,
            'name' => $request->name,
            'amount' => $request->amount,
            'left_amount' => $request->amount,
            'paid' => $request->paid,
        ]);

        $ceremony = Ceremony::find($ceremonyId);
        $ceremony->total_additions = BudgetAdditional::where('ceremony_id', $ceremonyId)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $ceremonyId);
    }


    public function update_addition(Request $request, $id)
    {
        $ceremony = Ceremony::find($request->ceremony_id);

        $addition = BudgetAdditional::find($id);
        $addition->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'left_amount' => $request->amount,
            'paid' => false,
        ]);

        $ceremony->total_additions = BudgetAdditional::where('ceremony_id', $ceremony->id)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $ceremony->id);
    }


    public function pay_addition(Request $request, $id)
    {
        $ceremony = Ceremony::find($id);
        $addition = BudgetAdditional::find($request->budget_additional_id);
        $file = $request->file('file');
        $filename = $file->hashName();
        $path = $file->storeAs('public/addition_files', $filename);

        if ($path) {
            $paidAmount = $request->value;
            $additionPaidAmount = $addition->amount - $addition->left_amount;

            if (($addition->amount - $additionPaidAmount) - $paidAmount < 0.01) {
                $paidAmount = ($addition->amount - $additionPaidAmount);
                $addition->paid = true;
            }

            $voucher = BudgetAdditionalVoucher::create([
                'budget_additional_id' => $request->budget_additional_id,
                'name' => $request->name,
                'value' => $request->value,
                'file' => $filename,
                'payment_date' => $request->payment_date,
            ]);

            $addition->left_amount -= $paidAmount;
            $addition->save();

            $ceremony->paid_amount -= $paidAmount;
            $this->verify_ceremony_status($ceremony);
            $ceremony->save();

            // return Inertia::json($voucher);
        }
    }


    public function get_addition_vouchers($additionId)
    {
        return BudgetAdditionalVoucher::where('budget_additional_id', $additionId)->get();
    }


    public function delete_addition_voucher(Request $request, $id)
    {
        $ceremony = Ceremony::find($id);
        $voucher = BudgetAdditionalVoucher::findOrFail($request->id);
        $addition = BudgetAdditional::find($voucher->budget_additional_id);

        $addition->left_amount += $voucher->value;
        $addition->paid = false;
        $addition->save();

        $ceremony->paid_amount -= $voucher->value;
        $ceremony->status = 0;
        $ceremony->save();

        Storage::delete('public/addition_files/' . $voucher->file);
        $voucher->delete();

        return to_route('financials.index', $id);
    }


    public function delete_addition(Int $id)
    {
        $addition = BudgetAdditional::findOrFail($id);
        $ceremony = Ceremony::find($addition->ceremony_id);

        $addition->delete();

        $ceremony->total_additions = BudgetAdditional::where('ceremony_id', $ceremony->id)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $id);
    }


    public function create_expense(Request $request)
    {
        $expense = BudgetExpense::create([
            'ceremony_id' => $request->ceremony_id,
            'name' => $request->name,
            'amount' => $request->amount,
        ]);

        $ceremony = Ceremony::find($request->ceremony_id);
        $ceremony->total_expenses = BudgetExpense::where('ceremony_id', $ceremony->id)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $ceremony->id);
    }


    public function update_expense(Request $request, $id)
    {
        $ceremony = Ceremony::find($request->ceremony_id);

        $expense = BudgetExpense::find($id);
        $expense->update([
            'name' => $request->name,
            'amount' => $request->amount,
        ]);

        $ceremony->total_expenses = BudgetExpense::where('ceremony_id', $ceremony->id)->sum('amount');
        $ceremony->save();

        return to_route('financials.index', $ceremony->id);
    }


    public function delete_expense(Int $id)
    {
        $expense = BudgetExpense::findOrFail($id);
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
            $paidAmount = $request->value;

            if (($installment->total_amount - $installment->paid_amount) - $paidAmount < 0.01) {
                $paidAmount = ($installment->total_amount - $installment->paid_amount);
                $installment->paid = true;
            }

            $voucher = Voucher::create([
                'installment_id' => $request['installment_id'],
                'name' => $request['name'],
                'value' => $request['value'],
                'file' => $filename,
                'payment_date' => $request['payment_date'],
            ]);

            $installment->paid_amount += $paidAmount;
            $installment->save();

            $ceremony->paid_amount += $paidAmount;
            $this->verify_ceremony_status($ceremony);
            $ceremony->save();
        }
    }


    public function delete_voucher(Request $request, $id)
    {
        $ceremony = Ceremony::find($id);
        $voucher = Voucher::findOrFail($request->id);
        $installment = Installment::find($voucher->installment_id);

        $installment->paid_amount -= $voucher->value;
        $installment->paid = false;
        $installment->save();

        $ceremony->paid_amount -= $voucher->value;
        $ceremony->status = 0;
        $ceremony->save();

        Storage::delete('public/installment_files/' . $voucher->file);
        $voucher->delete();

        return to_route('financials.index', $id);
    }


    public function update_obs(Request $request, $id)
    {
        $ceremony = Ceremony::findOrFail($id);
        $ceremony->update(['observations' => $request->obs]);
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
