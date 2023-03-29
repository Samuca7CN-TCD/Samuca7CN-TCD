<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Buffet;
use App\Models\BuffetPlate;
use App\Models\PlateIngredient;
use Illuminate\Support\Facades\DB;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  int  $plate_id
     * @return \Inertia\Response
     */
    public function index($plate_id)
    {
        $plate = BuffetPlate::find($plate_id);
        $plates = BuffetPlate::where('buffet_id', $plate->buffet_id)->get();
        $ingredients = PlateIngredient::where('buffet_plate_id', $plate_id)->get();
        return Inertia::render('Ingredients', [
            'activated_page' => (int) $plate_id,
            'submenu' => $plates,
            'submenu_category' => 'ingredients',
            'plate' => $plate,
            'ingredient_list' => $ingredients,
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
        PlateIngredient::create($request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'numeric'],
            'measure_unity' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
            'buffet_plate_id' => ['required', 'numeric'],
        ]));

        $this->recalc_buffet_cost();
        return to_route('ingredients.index', $request->buffet_plate_id);
    }

    private function recalc_buffet_cost(){
        $plates = BuffetPlate::all();
        foreach($plates as $plate){
            $cost = PlateIngredient::select(DB::raw('SUM(cost * quantity) AS total_value'))
                ->where('buffet_plate_id', $plate->id)
                ->get();
            $plate->cost = $cost[0]->total_value;
            $plate->save();
        }

        $buffets = Buffet::all();
        foreach($buffets as $buffet){
            $cost = BuffetPlate::select(DB::raw('SUM(cost * qtd_per_ten_people) AS total_value'))
                ->where('buffet_id', $buffet->id)
                ->get();
            $buffet->cost = $cost[0]->total_value;
            $buffet->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ingredient = PlateIngredient::find($id);
        $ingredient->delete();
        $this->recalc_buffet_cost();
        return to_route('ingredients.index', $ingredient->buffet_plate_id);
    }
}
