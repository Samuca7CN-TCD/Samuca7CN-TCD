<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PlateIngredient;

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
        $ingredients = PlateIngredient::where('plate_id', $plate_id);
        return Inertia::render('Ingredients', [
            'activated_page' => (int) $plate_id,
            'submenu' => array(),
            'submenu_category' => 'ingredients',
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
