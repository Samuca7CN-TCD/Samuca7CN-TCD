<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\MonthlyExpense;
use App\Models\ExpenseRecord;

class MonthlyExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return mixed
     */
    public function index()
    {
        $expense_records = ExpenseRecord::orderBy('year', 'desc')->orderBy('month', 'desc')->limit(12)->get();
        $last_expense_record = $expense_records->first();
        $monthly_expenses = MonthlyExpense::all();
        if (empty($expense_records) || $last_expense_record == null || $last_expense_record->year < date('Y') || $last_expense_record->month < date('m')) {
            $expense_record = new ExpenseRecord();
            $expense_record->month = date('m');
            $expense_record->year = date('Y');
            $expense_record->last_record = json_encode($monthly_expenses);
            $expense_record->save();
            $expense_records = ExpenseRecord::orderBy('year', 'desc')->orderBy('month', 'desc')->limit(12)->get();
        }
        return Inertia::render('MonthlyExpense', [
            'activated_page' => 0,
            'submenu' => $expense_records,
            'submenu_category' => 'monthly_expenses',
            'monthly_expenses' => $monthly_expenses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        MonthlyExpense::create($request->validate([
            'name' => ['required', 'string', 'unique:monthly_expenses'],
            'amount' => ['required', 'numeric']
        ]));
        return to_route('monthly_expenses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense_record = ExpenseRecord::find($id);
        $expense_records = ExpenseRecord::orderBy('id', 'desc')->limit(12)->get();
        return Inertia::render('MonthlyExpense', [
            'activated_page' => (int) $id,
            'submenu' => $expense_records,
            'submenu_category' => 'monthly_expenses',
            'expense_record' => $expense_record,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $monthly_expense = MonthlyExpense::find($id);
        $monthly_expense->update($request->validate([
            'name' => ['required', 'string', 'unique:monthly_expenses'],
            'amount' => ['required', 'numeric']
        ]));
        return to_route('monthly_expenses.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_record(Request $request, string $id)
    {
        $expense_record = ExpenseRecord::find($id);
        $expense_record->update($request->validate([
            'last_record' => ['required', 'json'],
            'month' => ['required', 'numeric'],
            'year' => ['required', 'numeric'],
        ]));
        return to_route('monthly_expenses.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $monthly_expense = MonthlyExpense::find($id);
        $monthly_expense->delete();
        return to_route('monthly_expenses.index');
    }
}
