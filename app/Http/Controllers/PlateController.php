<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Buffet;
use App\Models\BuffetPlate;
use App\Models\PlateIngredient;
use Illuminate\Support\Facades\DB;

class PlateController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  int  $buffet_id
     * @return \Inertia\Response
     */
    public function index($buffet_id)
    {
        $buffet = Buffet::find($buffet_id);
        $buffets = Buffet::where('type', $buffet->type)->where('status', 1)
            ->orderBy('status', 'desc')
            ->orderBy('name', 'asc')
            ->orderBy('price', 'desc')
            ->get();
        $plates = BuffetPlate::select('buffet_plates.*')
            ->where('buffet_plates.buffet_id', $buffet_id)
            ->get();
        return Inertia::render('Plates', [
            'activated_page' => (int) $buffet_id,
            'submenu' => $buffets,
            'submenu_category' => 'plates',
            'buffet' => $buffet,
            'plate_list' => $plates,
        ]);
    }

    private function recalc_buffet_cost()
    {
        $plates = BuffetPlate::all();
        foreach ($plates as $plate) {
            $cost = PlateIngredient::select(DB::raw('SUM(cost * quantity) AS total_value'))
                ->where('buffet_plate_id', $plate->id)
                ->get();
            $plate->cost = $cost[0]->total_value;
            $plate->save();
        }

        $buffets = Buffet::all();
        foreach ($buffets as $buffet) {
            $cost = BuffetPlate::select(DB::raw('SUM(cost * qtd_per_ten_people) AS total_value'))
                ->where('buffet_id', $buffet->id)
                ->get();
            $buffet->cost = $cost[0]->total_value;
            $buffet->save();
        }
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
        BuffetPlate::create($request->validate([
            'status' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'cost' => ['nullable', 'numeric'],
            'qtd_per_ten_people' => ['required', 'numeric'],
            'measure_unity' => ['required', 'string'],
            'buffet_id' => ['required', 'numeric'],
        ]));

        $this->recalc_buffet_cost();
        return to_route('plates.index', $request->buffet_id);
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
        $plate = BuffetPlate::find($id);
        $plate->delete();
        $this->recalc_buffet_cost();
        return to_route('plates.index', $plate->buffet_id);
    }
}
