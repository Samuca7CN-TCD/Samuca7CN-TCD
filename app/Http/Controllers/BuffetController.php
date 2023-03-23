<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Buffet;
use App\Models\BuffetPlate;

class BuffetController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  int  $type
     * @return mixed
     */
    public function index(int $type = 1)
    {
        //dd($type);
        $buffets = Buffet::where('type', (int) $type)
        ->orderBy('status', 'desc')
        ->orderBy('name', 'asc')
        ->orderBy('price', 'desc')
        ->get();
        return Inertia::render('Buffets', [
            'activated_page' => $type - 1,
            'submenu' => array(),
            'submenu_category' => 'buffets',
            'buffet_list' => $buffets,
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        Buffet::create($request->validate([
            'status' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'plates' => ['nullable', 'json'],
            'price' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
        ]));
        return to_route('buffets.index', $request->type);
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
        Buffet::find($id)->update($request->validate([
            'status' => ['required', 'numeric'],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'plates' => ['nullable', 'json'],
            'price' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
        ]));

        return to_route('buffets.index', $request->type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {
        $task = Buffet::find($id);
        $task->delete();
    }
}
