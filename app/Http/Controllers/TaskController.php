<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Task;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Ceremony;
use App\Models\User;
use App\Models\Menu;
use PhpParser\Node\Expr\Cast\Object_;

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
        $tags = Tag::all();
        $users = User::all();
        $submenu = Menu::find(3)->submenu;

        if($code == 0 || $code == 1){
            $deadlines = Task::select('tasks.deadline')->groupBy('tasks.deadline')->get();
            $task_list = array();
            foreach($deadlines as $item){
                $task_list[$item->deadline] = Task::select('tasks.*', 'clients.name AS client_name', 'events.name AS event_name', 'users.username AS user_username')
                ->leftJoin('ceremonies', 'tasks.ceremony_id', '=', 'ceremonies.id')
                ->leftJoin('budgets', 'ceremonies.budget_id', '=', 'budgets.id')
                ->leftJoin('clients', 'budgets.client_id', '=', 'clients.id')
                ->leftJoin('events', 'budgets.event_id', '=', 'events.id')
                ->leftJoin('users', 'tasks.user_id', '=', 'users.id')
                ->where('tasks.task_id', null)
                ->where('tasks.task_status_id', 1)
                ->where('tasks.deadline', $item->deadline)
                ->groupBy('tasks.id')
                ->orderBy('tasks.deadline')
                ->orderBy('tasks.priority')
                ->orderBy('tasks.id')
                ->get();
            }
            // dd($task_list);
            $ceremonies = Ceremony::select('ceremonies.*', 'clients.name AS client_name', 'events.name AS event_name')
                ->join('budgets', 'ceremonies.budget_id', '=', 'budgets.id')
                ->join('clients', 'budgets.client_id', '=', 'clients.id')
                ->join('events', 'budgets.event_id', '=', 'events.id')
                ->where('ceremonies.ceremony_status_id', 1)
                ->get();
            // dd($ceremonies);

            return Inertia::render('Tasks', [
                'activated_page' => (int) $code,
                'page_url_base' => 'tasks',
                'submenu' => $submenu,
                'task_list' => (object) $task_list,
                'task_form_selects' => (object) array(
                    'tags' => $tags,
                    'ceremonies'=> $ceremonies,
                    'users' => $users,
                ),
            ]);
        }elseif($code == 2){
            return Inertia::render('Tasks', [
                'activated_page' => (int) $code,
            'page_url_base' => 'tasks',
            'submenu' => $submenu,
                'tags' => Tag::all(),
            ]);
        }else{
            return Inertia::render('NotFound');
        }
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
     * Duplicate resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function task_duplicate(Request $request){
        Task::find($request->id)->replicate()->push();
        return to_route('tasks');
    }

    /**
     * Mark resource as done in storage.
     *
     * @param  int  $id
     * @return \Inertia\Response
     */
    public function show($id)
    {
        return Inertia::render('');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function task_done($id)
    {
        $task = Task::find($id);
        $task->task_status_id = 2;
        $task->save();
        // return to_route('tasks');
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
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->update($request->validate([
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->task_status_id = 3;
        $task->save();
        $task->delete();
        // return to_route('tasks');
    }
}
