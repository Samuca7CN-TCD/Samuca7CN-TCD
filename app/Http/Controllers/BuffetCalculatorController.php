<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Buffet;
use App\Models\BuffetEntry;
use App\Models\BuffetPlate;
use App\Models\PlateIngredient;

class BuffetCalculatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $entry_id
     * @param int $buffet_id
     * @return \Inertia\Response
     */
    public function index($qtd_pessoas = 10, $entry_id = 0, $buffet_id = 0)
    {
        $buffet_list = array(
            "entries" => Buffet::where('type', 2)->get(),
            "buffets" => Buffet::where('type', 1)->get(),
        );
        $options = array(
            'qtd_pessoas' => $qtd_pessoas,
            'entry' => $entry_id,
            'buffet' => $buffet_id,
        );

        $entry_plates = $buffet_plates = array();
        if(!empty($entry_id)){
            $entry_plates = BuffetPlate::where('buffet_id', $entry_id)->get();
        }

        if(!empty($buffet_id)){
            $buffet_plates = BuffetPlate::where('buffet_id', $buffet_id)->get();
        }

        //dd($entry_plates);
        return Inertia::render('BuffetCalculator', [
            'activated_page' => 0,
            'submenu' => array(),
            'submenu_category' => 'buffet_calculator',
            'buffet_list' => $buffet_list,
            'options' => $options,
            'entry_plates' => $entry_plates,
            'buffet_plates' => $buffet_plates,
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
     * @param  \Inertia\Inertia  $request
     * @return \Inertia\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show_sub_itens($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  string  $type
     * @param  string  $buffet_type
     * @return \Inertia\Response
     */
    public function edit($id, $type, $buffet_type = 'buffet')
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Inertia\Inertia  $request
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function update(Request $request, $id)
    {
        //
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
