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
     * @return \Inertia\Response
     */
    public function index()
    {
        $buffet_list = array(
            "entries" => BuffetEntry::all(),
            "buffets" => Buffet::all(),
        );
        return Inertia::render('BuffetCalculator', [
            'activated_page' => 0,
            'page_url_base' => 'buffet_calculator',
            "submenu" => array(),
            "buffet_list" => $buffet_list,
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
        $content_list = array();
        $buffet = array();
        $plate= array();
        if($type == 'plates'){
            if($buffet_type == 'buffet'){
                $content_list = BuffetPlate::where('buffet_id', $id)->get();
                $buffet = Buffet::find($id);
            }else if($buffet_type == 'buffet_entry'){
                $content_list = BuffetPlate::where('buffet_entry_id', $id)->get();
                $buffet = BuffetEntry::find($id);
            }
        }elseif($type == 'ingredients'){
            $content_list = PlateIngredient::where('plate_id', $id)->get();
            $plate = BuffetPlate::find($id);
        }
        return Inertia::render('BuffetCalculator', [
            'activated_page' => 0,
            'page_url_base' => 'buffet_calculator',
            'submenu' => array(),
            'buffet' => $buffet,
            'plate' => $plate,
            'content_type' => $type,
            'content_buffet_type' => $buffet_type,
            'content_list' => $content_list,
        ]);
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
