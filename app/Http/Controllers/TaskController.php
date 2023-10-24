<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::paginate(5);
        return view('task.index',compact('tasks'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $task = [
            'title'=>$request->title,
            'description'=>$request->description
        ];

        Task::create($task);

    
        return redirect()->route('task.index')->with('success', 'Task created successfully');

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
    public function edit(Task $task)
    {
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        
        $task=Task::find($request->task_id);
        
        $validator = Validator::make($request->all(), [
            'task_title' => 'required',
            'task_description' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'id'=>$request->task_id,
            'title'=>$request->task_title,
            'description'=>$request->task_description
        ];
        

        $task->update($data);

    
        return redirect()->route('task.index')->with('success', 'Task Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
    
        $task->delete();
    
        return response()->json(['message' => 'Task Deleted Successfully']);
    }
}
