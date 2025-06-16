<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\WeatherService;

class TaskController extends Controller
{
    public function index(WeatherService $weather)
    {
        $tasks = Task::latest()->get();
        $data = $weather->getCurrentWeather('Palmeira'); // ou qualquer cidade desejada

        return view('tasks.index', compact('tasks', 'data'));
    }


    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'type' => 'required',
            'priority' => 'required',
            'status' => 'required',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task){
        $task->load('subtasks');
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task){
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task){
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'priority' => 'required|string',
            'status' => 'required|string',
            'description' => 'nullable|string',
            'documentation' => 'nullable|string',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.show', $task)->with('success', 'Task updated successfully.');
    }
}
