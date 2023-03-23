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
        $buffets = Buffet::where('type', $buffet->type)->where('status', 1)->get();
        $plates = BuffetPlate::select('buffet_plates.*', DB::raw('COUNT(plate_ingredients.cost) as ingredients_cost'))
            ->leftJoin('plate_ingredients', 'plate_ingredients.buffet_plate_id', 'buffet_plates.id')
            ->where('buffet_plates.buffet_id', $buffet_id)
            ->get();
        dd($plates);
        return Inertia::render('Plates', [
            'activated_page' => (int) $buffet_id,
            'submenu' => $buffets,
            'submenu_category' => 'plates',
            'buffet' => $buffet,
            'plate_list' => $plates,
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
        //
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
        //
    }
}
