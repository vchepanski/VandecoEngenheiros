<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subtask;
use Illuminate\Http\Request;

class SubtaskController extends Controller
{
    // Cria uma nova subtask vinculada a uma task
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $task->subtasks()->create([
            'description' => $request->description,
            'content' => $request->content,
        ]);

        return redirect()->route('tasks.show', $task)->with('success', 'Subtask added.');
    }

    // Marca como concluída ou não
    public function update(Request $request, Subtask $subtask)
    {
        $subtask->update([
            'completed' => $request->has('completed'),
        ]);

        return redirect()->route('tasks.show', $subtask->task)->with('success', 'Subtask updated.');
    }

    // Remove uma subtask
    public function destroy(Subtask $subtask)
    {
        $task = $subtask->task;
        $subtask->delete();

        return redirect()->route('tasks.show', $task)->with('success', 'Subtask deleted.');
    }
}
