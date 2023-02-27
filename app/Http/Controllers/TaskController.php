<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;
use App\Models\Menu;
use App\Models\Submenu;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index($code = null)
    {
        $task_list = [];
        if($code == null) return redirect()->route('tasks', ['code' => 'today']);
        if($code == 'today') $task_list = Task::all()->where('deadline', strtotime(Date('Y-m-d h:i:s')));
        $submenu = Submenu::select('menus.code AS menu_code', 'submenus.code AS submenu_code', 'submenus.name AS submenu_name', 'submenus.icon AS submenu_icon')->where('menus.code', 'tasks')->join('menus', 'submenus.menu_id', '=', 'menus.id')->get();
        return Inertia::render('Tasks', [
            'activated_page' => $code,
            'page_options' => $submenu,
            'task_list' => $task_list
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        //
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
