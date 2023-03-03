<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Task;
use App\Models\Tag;
use App\Models\Ceremony;
use App\Models\User;
use App\Models\Menu;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $code
     * @return \Inertia\Response
     */
    public function index($code = 0)
    {
        $task_list = Task::select('id', 'title', 'description', 'deadline', 'tags')->where('user_id', Auth::id())->orderBy('priority', 'asc')->groupBy('deadline')->get();
        dd($task_list);
        $tags = Tag::all();
        $ceremonies = Ceremony::all()->where('ceremony_status_id', 1);
        $users = User::all()->where('id', '<>', Auth::id());

        $submenu = Menu::find(3)->submenu;

        return Inertia::render('Tasks', [
            'activated_page' => (int) $code,
            'page_url_base' => 'tasks',
            'submenu' => $submenu,
            'task_list' => $task_list,
            'task_form_selects' => (object) array(
                'tags' => $tags,
                'ceremonies'=> $ceremonies,
                'users' => $users,
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(Request $request)
    {
        Task::create($request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'deadline' => ['required', 'date_format:Y-m-d H:i:s'],
            'priority' => ['required', 'integer'],
            'tags' => ['nullable', 'JSON'],
            'ceremony_id' => ['nullable', 'integer'],
            'user_id' => ['required', 'integer'],
            'task_id' => ['nullable', 'integer'],
            'task_status_id' => ['required', 'integer'],
        ]));
        return to_route('tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        return Inertia::render('');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function edit($id)
    {
        return Inertia::render('');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function update(Request $request, $id)
    {
        return Inertia::render('');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function destroy($id)
    {
        return Inertia::render('');
    }
}
