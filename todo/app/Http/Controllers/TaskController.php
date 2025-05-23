<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Dompdf\Dompdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();

        return view('task.index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::categories();

        return view('task.create', ['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       // return $request;

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'completed' => 'nullable|boolean',
            'due_date' => 'nullable|date',
            'category_id' => 'required|exists:categories,id'
        ]);

        // return redirect->back()->withErrors(['title.....'])->withInput()

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->input('completed', false),
            'due_date' => $request->due_date,
            'user_id' => Auth::user()->id,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('task.show', $task->id)->withSuccess('Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //select * from tasks where id = $task;
       return view('task.show', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
      return view('task.edit', ['task'=>$task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'completed' => 'nullable|boolean',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->input('completed', false),
            'due_date' => $request->due_date
        ]);

        return redirect()->route('task.show', $task->id)->withSuccess('Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete-task');
        $task->delete();
        return redirect()->route('task.index')->withSuccess('Task deleted successfully!');
    }

    public function completed($completed){
        $tasks = Task::where('completed', $completed)->get();
        return view('task.index', ['tasks' => $tasks]);
    }

        public function pdf(Task $task)
    {
        $qrCode = QrCode::size(200)->generate(route('task.show', $task->id));
        $pdf = new Dompdf();
        $pdf->setPaper('letter', 'portrait');
        $pdf->loadHtml(view('task.pdf', ["task"=>$task, "qrCode"=>$qrCode]));
        $pdf->render();
        return $pdf->stream('task_'.$task->id.'.pdf');
    }

    public function query(){
        //select * from tasks
        //$task = Task::all();
        //$task = Task::select('title', 'description')->get();
        // $task = Task::select()->get();
        // $task = Task::select()->first();

        //SELECT * FROM tasks order by title
        $task = Task::select()->orderby('title')->get();

        //SELECT * FROM tasks where id = ?;
        $task = Task::find(3);
        $task = Task::where('id', 3)->first();

        //SELECT * FROM tasks WHERE title LIKE "e%";
        $task = Task::where('title', 'like', 'e%')->get();

        //SELECT * FROM tasks WHERE title LIKE "e%" AND user_id = 5;
        $task = Task::where('title', 'like', 'e%')
        ->where('user_id', '=', 5)
        ->get();

        //SELECT * FROM tasks WHERE title LIKE "e%" OR user_id = 4;
        $task = Task::where('title', 'like', 'e%')
        ->orwhere('user_id', '=', 4)
        ->get();

        //SELECT * FROM tasks INNER JOIN users on users.id = tasks.user_id
        
        $task = Task::select()
        ->join('users', 'user_id', '=', 'users.id')
        ->get();

        // SELECT count(id) FROM tasks
        $task = Task::count('id');

        // SELECT count(id) FROM tasks where user_id = 1;
        $task = Task::where('user_id', '=', 1)->count('id');

        return $task;
    }
}
